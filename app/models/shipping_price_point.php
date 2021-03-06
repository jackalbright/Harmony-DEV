<?php
class ShippingPricePoint extends AppModel {

	var $name = 'ShippingPricePoint';
	var $useTable = 'shippingPricePoint';
	var $primaryKey = 'shippingMethod';
	var $free_shipping = true; # Whether free shipping is enabled or not.

	# For now, US only...
	function calculate_shipping_options($destination, $prodcode, $quantity = 1, $order_cost = 0, $is_wholesale = false)
	{
		return $this->calculate_shipping_options_list($destination, array($prodcode=>$quantity),$order_cost, $is_wholesale);
	}

	function calculate_shipping_options_list($destination, $raw_product_list, $order_cost = 0, $is_wholesale = false)
	{
		$is_po_box = !empty($destination['ContactInfo']['is_po_box']);

		# Implement wholesale pricing for whole site (wholesale.harmonydesigns.com)
		if(preg_match("/^(www[.])?(wholesale)[.]/", $_SERVER['HTTP_HOST']))
		{
			$is_wholesale = true;
		}

		$productModel = $this->get_model("Product");
		$product = null;

		$weight = 0;

		$product_list = $raw_product_list;
		#print_r($raw_product_list);
		if (!empty($raw_product_list[0]['cart_item_id']))
		{
			$product_list = array();
			foreach($raw_product_list as $item)
			{
				$code = $item['productCode'];
				#if ($code == 'BC') { $code = 'B'; } # Take weight from bookmark
				## Since we don't seem to keep things uniform (sometimes we dont realize we're getting a charm bookmark
				$qty = $item['quantity'];
				$product_list[$code] = $qty;
			}
		}
		#print_r($product_list);

		# Calculate how much of order is ineligible from free shipping.
		$ineligible_shipping_costs = 0;
		$ineligible_product_costs = 0;
		$ineligible_weight = 0;

		foreach($product_list as $prodcode => $quantity)
		{
			if (is_array($prodcode))
			{
				$product = $prodcode;
			} else if (is_numeric($prodcode)) {
				$product = $productModel->find("product_type_id = '$prodcode'");
			} else {
				$product = $productModel->find("code = '$prodcode'");
			}
			$code = $product['Product']['code'];
			#$weight += $product['Product']['shipWeight']*$quantity;
			$weight += $product['Product']['weight']*$quantity;
			##echo "W=$weight = ($code) $quantity * " . $product['Product']['weight'];
			# NO LONGER USING 'shipWeight' ......
			# XXX TOMAS_MALY probably better to change and pass order costs TO THIS!

			if(empty($product['Product']['free_shipping'])) #in_array($code, array('MG','MG-USA','PW','PWK','DPWK','DPW','DPW-FLC','DPWK-FLC'))) # Not eligible for free shipping
			{
				$cost = $productModel->getUnitPrice($code, $quantity)*$quantity;
				$ineligible_product_costs += $cost;
				$ineligible_weight += $product['Product']['weight']*$quantity;
			}
		}
		#echo("WEYT=({$product[Product][code]}) $weight, *".$product['Product']['weight']);

		$shippingOptions = $this->calculate_shipping_options_by_weight($destination, $weight, $order_cost);
		# Filter so only get cheapest one per day of delivery.
		$availableShippingOptions = array(); # May exclude fedex if po box...
		foreach($shippingOptions as $shippingOption)
		{
			$optionName = $shippingOption['shippingMethod']['name'];
			$dayMax = $shippingOption['shippingMethod']['dayMax'];
			if($is_po_box && !preg_match("/USPS/", $optionName))
			{
				continue; # only postal service can deliver to po box.
			}

			if(empty($availableShippingOptions[$dayMax]) || $availableShippingOptions[$dayMax][0]['cost'] > $shippingOption[0]['cost'])
			{
				$availableShippingOptions[$dayMax] = $shippingOption;
			}
		}

		if(!empty($ineligible_weight))
		{
			$ineligible_shippingOptions = $this->calculate_shipping_options_by_weight($destination, $ineligible_weight, $ineligible_product_costs);
			# Filter so only get cheapest one per day of delivery.
			$ineligible_availableShippingOptions = array(); # May exclude fedex if po box...
			foreach($ineligible_shippingOptions as $shippingOption)
			{
				$optionName = $shippingOption['shippingMethod']['name'];
				$dayMax = $shippingOption['shippingMethod']['dayMax'];
				if($is_po_box && !preg_match("/USPS/", $optionName))
				{
					continue; # only postal service can deliver to po box.
				}
	
				if(empty($ineligible_availableShippingOptions[$dayMax]) || $ineligible_availableShippingOptions[$dayMax][0]['cost'] > $shippingOption[0]['cost'])
				{
					$ineligible_availableShippingOptions[$dayMax] = $shippingOption;
				}
			}

		}

			##################################
			$isoCode = null;
			$zipCode = null;
			if (!empty($destination['ContactInfo']) && is_array($destination['ContactInfo'])) { 
				$zipCode = $destination["ContactInfo"]['Zip_Code'];
				$isoCode = $destination["ContactInfo"]['Country'];
			} else if (!empty($destination) && is_array($destination)) {
				list($zipCode, $isoCode) = $destination;
			} else {
				$zipCode = $destination;
			}

			$state = $this->zipCodeToState($zipCode); # Since they may manually enter zip for estimate.
			$excluded_states = array('AK','HI','VI'); # Maybe add guam, virgin islands, etc later?

	
			# Now adjust cheapest for free shipping if meet criteria....
			$free_ground_ship_minimum = $this->get_config_value("free_ground_shipping_minimum");
			if ($this->free_shipping && !$is_wholesale && $free_ground_ship_minimum && $order_cost-$ineligible_product_costs >= $free_ground_ship_minimum && !in_array($state, $excluded_states) && (!$isoCode || $isoCode == 'US')) # Only US. & contiguous 48
			{
				# Now set cheapest one to free....
				$days = array_keys($availableShippingOptions);
				$min_ix = !empty($days) ? $days[0] : null; # Get slowest. (ordered by dayMax DESC)
				if(!empty($availableShippingOptions[$min_ix][0]))
				{
					$availableShippingOptions[$min_ix][0]['original_cost'] = $availableShippingOptions[$min_ix][0]['cost'];
					$availableShippingOptions[$min_ix][0]['cost'] = !empty($ineligible_availableShippingOptions[$min_ix]) ? 
							$ineligible_availableShippingOptions[$min_ix][0]['cost'] : 0;
				}
			}
			###################################

			# Now that we have an optimal list, set cheapest to free.


		return $availableShippingOptions;
	}

	function calculate_shipping_options_by_weight($destination, $weight, $order_cost = 0)
	{
		#$packageWeightMultiplier = 0.2; 
		$packageWeightMultiplier = 0; 
		# Some products are heavier than others, so 20% of it's weight in packaging is bogus.... weights are adjusted individually for packaging...

		#print_r($destination);
		#print_r($destination);
		#echo "D=$destination";

		#echo "PROD=".  print_r($product,true);

		#$packageWeightMultiplier = 0;
		$total_weight = (1+$packageWeightMultiplier) * $weight;
		#echo "TW=$total_weight, ";
		$pound_weight = $total_weight * 0.00220462262;
		#$total_shippingWeight = ceil($pound_weight);
		$total_shippingWeight = $pound_weight;

		##echo "WEIGHT=$total_shippingWeight, ";

		# XXX TODO IF WEIGHT IS MORE THAN MAX, SPLIT INTO EQUAL PACKAGES, ADD SUMMARY TO COST....
		#
		$isoCode = null;
		$zipCode = null;
		if (!empty($destination['ContactInfo']) && is_array($destination['ContactInfo'])) { 
			$zipCode = $destination["ContactInfo"]['Zip_Code'];
			$isoCode = $destination["ContactInfo"]['Country'];
		} else if (!empty($destination) && is_array($destination)) {
			list($zipCode, $isoCode) = $destination;
		} else {
			$zipCode = $destination;
		}

		if($isoCode == 'undefined') { $isoCode = ''; }

		if (!$isoCode || $isoCode == 'US' || $isoCode == 'PR')
		{
			$query = "SELECT MAX(weight) AS max_weight FROM shippingPricePoint, shippingZoneUS WHERE shippingZoneUS.zoneNumber = shippingPricePoint.zoneNumber AND shippingZoneUS.shippingMethod = shippingPricePoint.shippingmethod";
		} else if ($isoCode == 'CA') { 
			$query = "SELECT MAX(weight) AS max_weight FROM shippingPricePoint, shippingZoneCA WHERE shippingZoneCA.zone = shippingPricePoint.zoneNumber AND shippingZoneCA.shippingMethod = shippingPricePoint.shippingmethod";
		} else {
			$query = "SELECT MAX(weight) AS max_weight FROM shippingPricePoint, shippingZoneInt WHERE shippingZoneInt.zone = shippingPricePoint.zoneNumber AND shippingZoneInt.country = '$isoCode' AND shippingZoneInt.shippingMethod = shippingPricePoint.shippingmethod";
		}
		$maxWeightRecord = $this->query($query);
		$maxWeight = !empty($maxWeightRecord) ? $maxWeightRecord[0][0]['max_weight'] : 0;

		$boxCount = ceil($total_shippingWeight / $maxWeight);

		$shippingOptions = array();

		#if ($shippingWeight > $maxWeight)
		#{
			$remainingWeight = $total_shippingWeight;
			#for($i = 0; $i < $boxCount; $i++)
			while($remainingWeight > 0)
			{
				$shippingWeight = $maxWeight < $remainingWeight? $total_shippingWeight / $boxCount : $remainingWeight;
				#$shippingWeight = $maxWeight < $remainingWeight ? $maxWeight : $remainingWeight;
				#echo "PART_WEIGHT=$partWeight<br/>";
				$handlingCharge = $this->calculateHandlingCharge($shippingWeight);
				if(empty($handlingCharge)) { $handlingCharge = 0; }
				$internationalSurcharge = $this->get_config_value("international_surcharge");
				if(empty($internationalSurcharge)) { $internationalSurcharge = 0; }

				$rounded_shippingWeight = ceil($shippingWeight);


				$query = "";

				#echo "ZC=$zipCode, ISO=$isoCode";

				if (!$isoCode || $isoCode == 'US' || $isoCode == 'PR')
				{
					if(strlen($zipCode) > 5)
					{
						$zipCode = substr(preg_replace("/\D/", "", $zipCode));
						# In case they entered in full 9-digit zip code.
					}
					#
					$query = "SELECT *,shippingPricePoint.cost+$handlingCharge as cost FROM `shippingZoneUS`, `shippingPricePoint`, `shippingMethod` WHERE shippingZoneUS.zipStart <= '$zipCode' and shippingZoneUS.zipEnd >= '$zipCode' and shippingZoneUS.shippingMethod = shippingMethod.shippingMethodID and shippingMethod.available = 'yes' and shippingMethod.shippingMethodID = shippingPricePoint.shippingmethod and shippingZoneUS.zoneNumber = shippingPricePoint.zoneNumber and shippingPricePoint.weight = $rounded_shippingWeight order by shippingMethod.dayMax DESC, shippingMethod.dayMin DESC";
				} else if ($isoCode == 'CA') { 
					$shippingCode = substr($zipCode, 0,3);
					$query = "SELECT *, shippingPricePoint.cost+$handlingCharge+$internationalSurcharge as cost FROM `shippingZoneCA`, `shippingPricePoint`, `shippingMethod` WHERE shippingZoneCA.codeMin <= '$shippingCode' and shippingZoneCA.codeMax >= '$shippingCode' and shippingZoneCA.shippingMethod = shippingMethod.shippingMethodID and shippingMethod.available = 'yes' and shippingMethod.shippingMethodID = shippingPricePoint.shippingmethod and shippingZoneCA.zone = shippingPricePoint.zoneNumber and shippingPricePoint.weight = $rounded_shippingWeight order by shippingMethod.dayMax DESC, shippingMethod.dayMin DESC";
				} else {
					$query = "SELECT *, shippingPricePoint.cost+$handlingCharge+$internationalSurcharge as cost FROM `shippingZoneInt`, `shippingPricePoint`, `shippingMethod` WHERE shippingZoneInt.country = '$isoCode' and shippingZoneInt.shippingMethod = shippingMethod.shippingMethodID and shippingMethod.available = 'yes' and shippingMethod.shippingMethodID = shippingPricePoint.shippingmethod and shippingZoneInt.zone = shippingPricePoint.zoneNumber and shippingPricePoint.weight = $rounded_shippingWeight order by shippingMethod.dayMax DESC ,shippingMethod.dayMin desc";
				}

				
				$shippingOptionsPart = $this->query($query);
				#error_log("Q=$query");
				#echo("Q=$query");
				#print_r($shippingOptionsPart);
				for ($i = 0; $i < count($shippingOptionsPart); $i++) # 2-day, groound, etc...
				{
					$option = $shippingOptionsPart[$i];
					#print_r($option);
					foreach($option as $key => $tabledata)
					{
						#echo "KEY=$key<br/>";
						if ($key === 0)
						{
							#if(!isset($shippingOptions[$i][$key]['weight'])) { $shippingOptions[$i][$key]['weight'] = 0; }
							#$shippingOptions[$i][$key]['weight'] += $tabledata['weight'];
							if(!isset($shippingOptions[$i][$key]['cost'])) { $shippingOptions[$i][$key]['cost'] = 0; }

							$shippingOptions[$i][$key]['cost'] += $tabledata['cost'];
							#echo "COST=".$tabledata['cost']."<br/>";
						} else {
							if($key == 'shippingPricePoint')
							{
								foreach($tabledata as $tkey => $tval)
								{
									if ($tkey == 'weight' || $tkey == 'cost' || $tkey == 'cost_old')
									{
										if (!isset($shippingOptions[$i][$key][$tkey])) { $shippingOptions[$i][$key][$tkey] = 0; }
										$shippingOptions[$i][$key][$tkey] += $tval;
									} else {
										$shippingOptions[$i][$key][$tkey] = $tval;
									}
								}
							} else {
								$shippingOptions[$i][$key] = $tabledata;
							}
						}
					}
				}
				$remainingWeight -= $shippingWeight;
				#echo "RW=$remainingWeight<br/>";
			}
			#echo "<br/><br/>SC=";
			#print_r($shippingOptions);
			
		#} else {
		#	$handlingCharge = $this->calculateHandlingCharge($shippingWeight);
		#	$shippingOptions = $this->query("SELECT *,shippingPricePoint.cost+$handlingCharge as cost FROM `shippingZoneUS`, `shippingPricePoint`, `shippingMethod` WHERE shippingZoneUS.zipStart <= '$zipCode' and shippingZoneUS.zipEnd >= '$zipCode' and shippingZoneUS.shippingMethod = shippingMethod.shippingMethodID and shippingMethod.available = 'yes' and shippingMethod.shippingMethodID = shippingPricePoint.shippingmethod and shippingZoneUS.zoneNumber = shippingPricePoint.zoneNumber and shippingPricePoint.weight = $shippingWeight order by shippingPricePoint.cost");
		#}


		return $shippingOptions;
	}

	function zipCodeToState($zipCode)
	{
		$zipCodeModel = ClassRegistry::init("ZipCode");
		$record = $zipCodeModel->find("zip = '$zipCode'");
		return $record['ZipCode']['state'];
	}

	function calculateHandlingCharge($shippingWeight)
	{
		$handlingChargeModel = ClassRegistry::init("HandlingCharge");
		$handlingChargeRecord = $handlingChargeModel->find("weight <= '$shippingWeight'", array(), "weight DESC");
		$handlingCharge = $handlingChargeRecord['HandlingCharge']['price'];
		return $handlingCharge;
	}

}
?>
