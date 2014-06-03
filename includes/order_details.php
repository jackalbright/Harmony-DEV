<?


function get_shipping_address($shippingID, $database)
{
	$result = mysql_query ("SELECT contact_info.*, countries.name as countryName FROM contact_info, countries WHERE contact_id='$shippingID' AND contact_info.Country = countries.iso_code", $database); 	
	$result_object = mysql_fetch_object($result);
	return $result_object;
}
	

function get_shipping_options($purchaseID, $database)
{
// Get Shippers
	#error_log("GETSHIPPIN OPTIONS");
		$purchase = get_purchase_record($purchaseID, $database);
		$shippingMethodID = $purchase->Shipping_Method;
		$orderstatus = $purchase->Order_Status;

		#error_log("SHIPPING METHOD=$shippingMethodID");

		$i=0;
		$result = mysql_query ("SELECT shippingMethodID, name FROM shippingMethod", $database); 	
		while ($row = mysql_fetch_object($result)){
			$shipperName[$i]= "<option value='$row->shippingMethodID'";
			if ($shippingMethodID == $row->shippingMethodID && $orderstatus=="Shipped"){ 
				$shipperName[$i] .= " SELECTED";
			};
			$shipperName[$i].= ">$row->name</option>";
			$i++;
		};


		$address = get_shipping_address($purchase->Shipping_ID, $database);

		$isoCode = $address->Country;

		#error_log("PUR=".print_r($purchase,true));
		#error_log("ADD=".print_r($address,true));

// Get information for Shipping Cost Recalc
/* ######## Load settings ######## */
	$queryString = "SELECT packageWeightMultiplier, internationalSurcharge FROM settings WHERE settingsID =1";
	$result = mysql_query ($queryString, $database);
	$temp = mysql_fetch_object($result);
	$packageWeightMultiplier = $temp->packageWeightMultiplier;
	$internationalSurcharge = $temp->internationalSurcharge;

	$itemWeight=0;
	# NO LONGER USING 'shipWeight'
	#$result = mysql_query ("SELECT order_item.Quantity, product_type.shipWeight FROM order_item, product_type WHERE order_item.purchase_id='$purchaseID' AND product_type.product_type_id = order_item.product_type_id AND Accepted='Yes'", $database); 	
	$result = mysql_query ("SELECT order_item.Quantity, order_item.Price, product_type.weight, product_type.code FROM order_item, product_type WHERE order_item.purchase_id='$purchaseID' AND product_type.product_type_id = order_item.product_type_id AND Accepted='Yes'", $database); 	
	$ineligibleWeight = 0;
	$eligiblePrice = 0;

	while ($row = mysql_fetch_object($result)){
		$tempQuantity = $row->Quantity;
		$code = $row->code;
		$product = db_get_record("product_type", array('code'=>$code),null,array('free_shipping'));
		$free_shipping = $product['free_shipping'];
		$tempPrice = $row->Price;
		$tempWeight = $row->weight;
		$itemWeight = $itemWeight + ($tempQuantity * $tempWeight);
		if(empty($free_shipping)) #in_array($row->code, array('MG','MG-USA','PW','PWK','DPWK','DPW','DPW-FLC','DPWK-FLC')))
		{
			$ineligibleWeight += ($tempQuantity * $tempWeight);
		} else {
			$eligiblePrice += $tempQuantity*$tempPrice;
		}
	};

	# Get more accurate weight!
	#error_log("ITEM WEIGHT_GM=$itemWeight");

/* ######## Calculate weights for different shipping determinations ######## */
	$factor = 0.00220462262;
	$packageWeight = 0;#$itemWeight * $packageWeightMultiplier;
	$orderWeight = $packageWeight + $itemWeight;
	$poundWeight = $orderWeight * $factor;

	$zip2state = get_db_record("zipCode", array('zip'=>$address->Zip_Code));

	$state = !empty($zip2state) ? $zip2state['state'] : null;
	#error_log("STATE=$state, COUNRY=$isoCode");

	$merged_shippingOptions = get_merged_shipping_options($poundWeight, $address, $database);

	if($isoCode == 'US' && !in_array($state, array('HI','AK','VI')))
	{
		$ineligiblePoundWeight = $ineligibleWeight * $factor;
		$ineligibleShippingWeight = ceil($ineligiblePoundWeight);
		#error_log("INELIG_WT=$ineligibleShippingWeight");
	
		$minCosts = get_db_record("configs", array('name'=>'free_ground_shipping_minimum'));
		$freeShippingMinimum = $minCosts['value'];
		#error_log("FREE_GRND=$freeShippingMinimum");

		$smids = array_keys($merged_shippingOptions);
		$ground_smid = $smids[0];

		if(!empty($ineligiblePoundWeight))
		{
			$ineligible_shippingOptions = get_merged_shipping_options($ineligiblePoundWeight, $address, $database);
			$merged_shippingOptions[$ground_smid]->cost = $ineligible_shippingOptions[$ground_smid]->cost;
		}
	}

	return $merged_shippingOptions;
}

function get_merged_shipping_options($poundWeight, $address, $database)
{
	$isoCode = $address->Country;

	if (!$isoCode || $isoCode == 'US' || $isoCode == 'PR')
	{
		$query = "SELECT MAX(weight) AS max_weight FROM shippingPricePoint, shippingZoneUS WHERE shippingZoneUS.zoneNumber = shippingPricePoint.zoneNumber AND shippingZoneUS.shippingMethod = shippingPricePoint.shippingmethod";
	} else if ($isoCode == 'CA') { 
		$query = "SELECT MAX(weight) AS max_weight FROM shippingPricePoint, shippingZoneCA WHERE shippingZoneCA.zone = shippingPricePoint.zoneNumber AND shippingZoneCA.shippingMethod = shippingPricePoint.shippingmethod";
	} else {
		$query = "SELECT MAX(weight) AS max_weight FROM shippingPricePoint, shippingZoneInt WHERE shippingZoneInt.zone = shippingPricePoint.zoneNumber AND shippingZoneInt.country = '$isoCode' AND shippingZoneInt.shippingMethod = shippingPricePoint.shippingmethod";
	}
	$maxWeightRecord = mysql_fetch_object(mysql_query($query, $database));
	$maxWeight = !empty($maxWeightRecord) ? $maxWeightRecord->max_weight : 0;

	$shippingWeight = ceil($poundWeight);
	$total_shippingWeight = $remainingWeight = $shippingWeight;
	$boxCount = ceil($shippingWeight / $maxWeight);

	$config = get_db_record("configs", array('name'=>'international_surcharge'));
	$internationalSurcharge = !empty($config['value']) ? $config['value'] : 0;

	$merged_shippingOptions = $shippingOptions = array();
	while($remainingWeight > 0 )
	{
		$shippingWeight = $maxWeight < $remainingWeight? $total_shippingWeight / $boxCount : $remainingWeight;
		#error_log("SHIPPING WEIGHT X=$shippingWeight");

		$queryString = "SELECT * from `handlingCharge` where weight <= $poundWeight order by weight desc limit 1";
		$result = mysql_query ($queryString, $database);
		$temp = mysql_fetch_object($result);
		$handlingCharge = $temp->price;
		#error_log("HANDL ($queryString)=$handlingCharge");

		$rounded_shippingWeight = ceil($shippingWeight);

		if ($address->Country == 'US' || $address->Country == 'PR') {
			$shippingZip = substr ($address->Zip_Code, 0, 5);
			$queryString = "SELECT shippingMethod.*, shippingPricePoint.cost+$handlingCharge as cost FROM `shippingZoneUS`, `shippingPricePoint`, `shippingMethod` WHERE shippingZoneUS.zipStart <= $shippingZip and shippingZoneUS.zipEnd >= $shippingZip and shippingZoneUS.shippingMethod = shippingMethod.shippingMethodID and shippingMethod.available = 'yes' and shippingMethod.shippingMethodID = shippingPricePoint.shippingmethod and shippingZoneUS.zoneNumber = shippingPricePoint.zoneNumber and shippingPricePoint.weight = $rounded_shippingWeight order by shippingMethod.dayMin desc";
			$result = mysql_query($queryString, $database);
			#error_log("Q=$queryString");
			while ($temp = mysql_fetch_object($result)) {
				#error_log("     OPT=".print_r($temp,true));
				$shippingOptions[$temp->shippingMethodID] = $temp;
			}			
		} else if ($address->Country == 'VI' || $address->Country == 'GU') {
			$shippingZip = substr ($address->Zip_Code, 0, 5);
			$queryString = "SELECT shippingMethod.*, shippingPricePoint.cost+$handlingCharge as cost FROM `shippingZoneUS`, `shippingPricePoint`, `shippingMethod` WHERE shippingZoneUS.zipStart <= $shippingZip and shippingZoneUS.zipEnd >= $shippingZip and shippingZoneUS.shippingMethod = shippingMethod.shippingMethodID and shippingMethod.available = 'yes' and shippingMethod.shippingMethodID = shippingPricePoint.shippingmethod and shippingZoneUS.zoneNumber = shippingPricePoint.zoneNumber and shippingPricePoint.weight = $rounded_shippingWeight order by shippingMethod.dayMin desc";
			$result = mysql_query($queryString, $database);
			while ($temp = mysql_fetch_object($result)) {
				$shippingOptions[$temp->shippingMethodID] = $temp;
			}			
			$isoCode = $address->Country;
			$queryString = "SELECT shippingMethod.*, shippingPricePoint.cost+$handlingCharge as cost FROM `shippingZoneInt`, `shippingPricePoint`, `shippingMethod` WHERE shippingZoneInt.country = '$isoCode' and shippingZoneInt.shippingMethod = shippingMethod.shippingMethodID and shippingMethod.available = 'yes' and shippingMethod.shippingMethodID = shippingPricePoint.shippingmethod and shippingZoneInt.zone = shippingPricePoint.zoneNumber and shippingPricePoint.weight = $rounded_shippingWeight order by shippingMethod.dayMin desc";
			$result = mysql_query($queryString, $database);
			while ($temp = mysql_fetch_object($result)) {
				$shippingOptions[$temp->shippingMethodID] = $temp;
			}
		} else if ($address->Country == 'CA') {
			$shippingCode = substr ($address->Zip_Code, 0, 3);
			$queryString = "SELECT shippingMethod.*, shippingPricePoint.cost+$handlingCharge+$internationalSurcharge as cost FROM `shippingZoneCA`, `shippingPricePoint`, `shippingMethod` WHERE shippingZoneCA.codeMin <= '$shippingCode' and shippingZoneCA.codeMax >= '$shippingCode' and shippingZoneCA.shippingMethod = shippingMethod.shippingMethodID and shippingMethod.available = 'yes' and shippingMethod.shippingMethodID = shippingPricePoint.shippingmethod and shippingZoneCA.zone = shippingPricePoint.zoneNumber and shippingPricePoint.weight = $rounded_shippingWeight order by shippingMethod.dayMin desc";
			$result = mysql_query($queryString, $database);
			while ($temp = mysql_fetch_object($result)) {
				$shippingOptions[$temp->shippingMethodID] = $temp;
			}			
		} else {
			#error_log("INTERNATIONAL BULL");
			$isoCode = $address->Country;
			$queryString = "SELECT shippingMethod.*, shippingPricePoint.cost+$handlingCharge+$internationalSurcharge as cost FROM `shippingZoneInt`, `shippingPricePoint`, `shippingMethod` WHERE shippingZoneInt.country = '$isoCode' and shippingZoneInt.shippingMethod = shippingMethod.shippingMethodID and shippingMethod.available = 'yes' and shippingMethod.shippingMethodID = shippingPricePoint.shippingmethod and shippingZoneInt.zone = shippingPricePoint.zoneNumber and shippingPricePoint.weight = $rounded_shippingWeight order by shippingMethod.dayMin desc";
			$result = mysql_query($queryString, $database);
			while ($temp = mysql_fetch_object($result)) {
				$shippingOptions[$temp->shippingMethodID] = $temp;
			}
		}

		#echo "Q=$queryString<br/>";

		# MERGE RESULTS TOGETHER...
		foreach($shippingOptions as $smid => $ship)
		{
			foreach($ship as $skey => $svalue)
			{
				if(in_array($skey, array('cost','weight','cost_old')))
				{
					if(empty($merged_shippingOptions[$smid]->$skey)) { 
						$merged_shippingOptions[$smid]->$skey = 0; 
					}
					$merged_shippingOptions[$smid]->$skey += $svalue;
				} else {
					$merged_shippingOptions[$smid]->$skey = $svalue;
				}
			}
		}

		$remainingWeight -= $shippingWeight;
		#error_log("REMAINING WEIGHT=$remainingWeight (FROM $shippingWeight)");

	}
	return $merged_shippingOptions;
}

function get_purchase_record($purchaseID, $database)
{
	$testQuery="SELECT purchase.*, shippingMethod.name as Ship_ID FROM purchase, shippingMethod WHERE purchase.purchase_id='$purchaseID' and purchase.shipping_Method = shippingMethod.shippingMethodID";
	$result = mysql_query ($testQuery, $database); 	
	$result_object = mysql_fetch_object($result);
	return $result_object;
}

function print_order_customer($purchaseID, $database, $readonly = false, $shippingOptions = null)
{
	//Pull in General Order Information
	$purchase = get_purchase_record($purchaseID, $database);

	$orderdate=$purchase->Order_Date;
	$customer_po=$purchase->customer_po;
	$orderstatus=$purchase->Order_Status;
	$shippingmethod=$purchase->Ship_ID;
	$customerID=$purchase->Customer_ID;
	$shippingAddress=$purchase->Shipping_ID;
	$shippingID=$purchase->Shipping_Method;
	$creditCardID=$purchase->Credit_Card_ID;
	$billingID=$purchase->Billing_ID;
	$shippingCost=$purchase->Shipping_Cost;
	$oldShippingCost=$purchase->Old_Shipping_Cost;
	$originalShipping = $purchase->Shipping_Cost;
	$orderComment=$purchase->order_comment;
	$txtShipper=$purchase->shipper;
	$txtTrackingNumber=$purchase->tracking_number;
	$freeShipping = $purchase->free_shipping;
	$txtCardNumber = $purchase->cardLast4;

// Pull in Shipping Address
	$address = get_shipping_address($shippingAddress, $database);
	$shipAddress1=$address->Address_1;
	$shipAddress2=$address->Address_2;
	$shipInCareOf=$address->In_Care_Of;
	$shippingCompany=$address->Company;
	$shipCity=$address->City;
	$shipState=$address->State;
	$shipZipCode=$address->Zip_Code;
	$shipCountry=$address->Country;
	$shipCountryName = $address->countryName;

	#error_log("SO=".print_r($shippingOptions,true));
	#$shippingOptions = null;

	if(empty($shippingOptions))
	{#
		$shippingOptions = get_shipping_options($purchaseID, $database);
	}#

//Pull in Customer Information
	$result2 = mysql_query ("SELECT * FROM customer WHERE customer_id='$customerID'", $database);
	while ($row2 = mysql_fetch_object($result2)){
		$customerFirstName=$row2->First_Name;
		$customerLastName=$row2->Last_Name;
		$customerCompany=$row2->Company;
		$customerPhone=$row2->Phone;
		$customerEmail=$row2->eMail_Address;
		$custPhone=strtok($customerPhone, '() -');
		$txtCardType = $row2->cardType;
	};

//Pull in Billing Address
	$result = mysql_query ("SELECT contact_info.*, countries.name as countryName FROM contact_info, countries WHERE contact_id='$billingID' AND contact_info.Country = countries.iso_code", $database); 	
	while ($row = mysql_fetch_object($result)){
		$billAddress1=$row->Address_1;
		$billAddress2=$row->Address_2;
		$billInCareOf=$row->In_Care_Of;
		$billingCompany=$row->Company;
		$billCity=$row->City;
		$billState=$row->State;
		$billZipCode=$row->Zip_Code;
		$billCountry=$row->Country;
		$billCountryName = $row->countryName;
	};

//Pull in Credit Card information
	/*
	include_once (dirname(__FILE__)."/encdecclass.php");
	$encdec = &New EncDec;

	if($creditCardID > 0)
	{
	$result = mysql_query ("SELECT card_type, cardholder, number, expiration FROM credit_card WHERE credit_card_id='$creditCardID'", $database); 	
	while ($row = mysql_fetch_object($result)){
		$txtCardType=$row->card_type;
		$txtCardHolder=$row->cardholder;
		$txtCardNumber=$encdec->phpDecrypt($row->number);
		$txtCardExpiration=date("m/Y", strtotime($row->expiration));
	};

	if ($readonly) { 
		$txtCardNumber = str_repeat("X", strlen($txtCardNumber)-4) . substr($txtCardNumber, -4);
	}
	}
	*/

?>
<style type="text/css" media="screen">
		<!--
		.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
		.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; line-height: normal; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
		.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
		.style1 {font-weight: bold}
		--></style>
	<table width="450" border="0" cellspacing="2" cellpadding="0">
		<tr>
			<td valign="top" width="50%">
				<h3><b><font color="purple">Order Number: <?php echo "$purchaseID"; ?>
				  <input type="hidden" name="hdnPurchaseID" value="<?php echo "$purchaseID"; ?>">
                                      <input type="hidden" name="hdnUpdate" value="true">
</font></b></h3>							  </td>
			<td valign="top"><h4><b>Date:  <?php echo "$orderdate"; ?></b></h4></td>
		</tr>
		<tr>
			<td valign="top" width="50%">
				<b>Shipping to:</b>
				<br /><?php
					if (!empty($shipInCareOf)){
					  echo "ATTN: $shipInCareOf<br />";
					} else {
					  echo "ATTN: $customerFirstName $customerLastName<br />";
					};
					if (!empty($shippingCompany)){
					  echo "$shippingCompany<br />";
					};
					echo "$shipAddress1<br />$shipAddress2<br />$shipCity, $shipState $shipZipCode<br />$shipCountryName<br />$customerPhone<br /><a href=\"mailto:$customerEmail\">$customerEmail</a>";
				?>
			</td>
			<td valign="top">
				<b>Billing to:</b>
				<br /><?php
					if (!empty($billInCareOf)){
					  echo "ATTN: $billInCareOf<br />";
					} else {
					  echo "ATTN: $customerFirstName $customerLastName<br />";
					};
					if (!empty($billingCompany)){
					  echo "$billingCompany<br />";
					};
					echo "$billAddress1<br />$billAddress2<br />$billCity, $billState $billZipCode<br />$billCountryName<br />$customerPhone<br /><a href=\"mailto:$customerEmail\">$customerEmail</a>";
				?>
			</td>
		</tr>
		<tr>
			<td valign="top" width="50%">
				<!--
				<b>Shipping Method:</b>
				<br />
				<?php echo $shippingmethod; ?>
				-->
			</td>
			<td valign="top" rowspan="3"><b>Order Comments:</b><br /><?php echo $orderComment; ?></td>
		</tr>
		<tr>
			<td valign="top" width="50%">
				<b>Payment Method:</b><br />
				<? if($creditCardID == -1) { ?>
					&nbsp;&nbsp;&nbsp;&nbsp;PayPal
				<? } else if ($creditCardID == -2) { ?>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<b>Bill Me Later</b>
					<? if(!empty($customer_po)) { ?>
					<br/>
					&nbsp;&nbsp;&nbsp;&nbsp;
					PO # <?= $customer_po ?>
					<? } ?>
				<? } else if ($creditCardID == -3) { ?>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<b>Amazon Payments</b>
				<? } else { ?>
			<?php
				if(empty($txtCardType)) { $txtCardType = 'Card'; }
				#echo "&nbsp;&nbsp;&nbsp;&nbsp;<b>Card Type:</b>  $txtCardType<br />";
				#echo "&nbsp;&nbsp;&nbsp;&nbsp;<b>Cardholder: </b> $txtCardHolder<br />";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;<b>$txtCardType ending in:</b>  $txtCardNumber<br />";
				#echo "&nbsp;&nbsp;&nbsp;&nbsp;<b>Expires:</b>  $txtCardExpiration<br />";
				}
			?>
			</td>
		</tr>
		<tr>
			<td valign="top" width="50%">
				<b>Shipping Method:</b><br />
				<? if ($readonly) { 
					$dayMax = $dayMin = 0;
					$methodCost = 0;
					$methodName = "";

					foreach($shippingOptions as $shippingMethod)
					{
						if(is_array($shippingMethod))
						{
							$shippingMethodID = $shippingMethod['shippingMethod']['shippingMethodID'];
							$dayMax = $shippingMethod['shippingMethod']['dayMax'];
							$dayMin = $shippingMethod['shippingMethod']['dayMin'];
							$methodName = $shippingMethod['shippingMethod']['name'];
							$methodCost = $shippingMethod[0]['cost']; # XXX TODO TOMAS_MALY this is why we show wrong shipping price on email.
						} else if (is_object($shippingMethod)) { 
							$shippingMethodID = $shippingMethod->shippingMethodID;
							$dayMin = $shippingMethod->dayMin;
							$dayMax = $shippingMethod->dayMax;
							$methodName = $shippingMethod->name;
							$methodCost = $shippingMethod->cost;
						}
						if ( $shippingID === $shippingMethodID ) { break; }
					}

					if($purchase->free_shipping)
					{
						$methodCost = 0;
					}

					if ($dayMin == $dayMax){
						echo sprintf("%s {%d days - $%.02f}", $methodName, $dayMin, $methodCost);
					} else {
						echo sprintf("%s {%d - %d days - $%.02f}", $methodName, $dayMin, $dayMax, $methodCost);
					}
				} else { ?>
				<select name="txtShipper">
					<?php
						foreach ( $shippingOptions as $method_id => $shippingMethod ) {
							if(is_array($shippingMethod))
							{
								$shippingMethodID = $shippingMethod['shippingMethod']['shippingMethodID'];
								$dayMax = $shippingMethod['shippingMethod']['dayMax'];
								$dayMin = $shippingMethod['shippingMethod']['dayMin'];
								$methodName = $shippingMethod['shippingMethod']['name'];
								$methodCost = $shippingMethod['shippingPricePoint']['cost'];
							} else if (is_object($shippingMethod)) { 
								$shippingMethodID = $shippingMethod->shippingMethodID;
								$dayMin = $shippingMethod->dayMin;
								$dayMax = $shippingMethod->dayMax;
								$methodName = $shippingMethod->name;
								$methodCost = $shippingMethod->cost;
							}

							echo "<option value=\"$shippingMethodID\"";
							if ( $shippingID == $shippingMethodID ) {
								echo " selected=\"selected\"";
							};
							echo ">$methodName ";
							if ($dayMin == $dayMax){
								echo sprintf("{%s %d days - $%.02f}", $methodName, $dayMin, $methodCost);
							} else {
								echo sprintf("{%s %d - %d days - $%.02f}", $methodName, $dayMin, $dayMax, $methodCost);
							}
							echo "</option>";
						}
					?>
				</select>
				<? } ?>
				<? if(!empty($purchase->ships_by)) { ?>
				<br/>
				<b>Ships by:</b> <?= date("m/d/Y", strtotime($purchase->ships_by)); ?>
				<br/>
				<? } ?>

				<? if(!empty($purchase->rush_date) && (!$readonly || $readonly == 'admin')) { ?>
				<div style="color: red; font-weight: bold; font-size: 2em;">
				RUSH
				</div>
				<? } ?>
			</td>
		</tr>
		<tr>
			<td valign="top" width="50%">
				<b>Tracking Number:</b><br />
				<? if ($readonly) { ?>
					<?= $txtTrackingNumber ?>
				<? } else { ?>
					<input name="txtTrackingNumber" type="text" size="30" value="<?php echo $txtTrackingNumber; ?>">
				<? } ?>

				
		  </td>
			<td valign="top">
			<strong>Order Status:</strong><br />
			<? if ($readonly) { ?>
				<?= $orderstatus ?>
			<? } else { ?>

			<select name="txtOrderStatus">
			  <option value="Submitted" <?php if ($orderstatus=="Submitted"){echo " SELECTED";}; ?>>New Order</option>
			  <option value="Processing" <?php if ($orderstatus=="Processing"){echo " SELECTED";}; ?>>In Progress</option>
			  <option value="Shipped" <?php if ($orderstatus=="Shipped"){echo " SELECTED";}; ?>>Shipped</option>
		    	</select>

			<? } ?>
		    </td>
		</tr>
		<tr>
		  <td valign="top">&nbsp;</td>
		  <td valign="top"><div align="right">
			<? if (!$readonly) { ?>
		    <input type="submit" name="Submit1" value="Recalculate and Submit Changes">						      
		    	<? } ?>
	      </div></td>
	  </tr>
	</table>
<?
}

function print_order_items($purchaseID, $database, $readonly = false)
{
	include(dirname(__FILE__)."/../app/config/background_colors.php"); # multiple times, just in case. 2nd+ time we wont have access to var anymore.
	$backgroundColors = $config['BackgroundColors']; # Save since var wiped out.
	# List vars need to be declared here, for scope reasons...
	
	$host = 'http://'.$_SERVER['HTTP_HOST'];

	$purchase = get_purchase_record($purchaseID, $database);
	$originalShipping = $purchase->Shipping_Cost;
	$oldShippingCost=$purchase->Old_Shipping_Cost;
	$itemCancel = array();

	$shippingOptions = get_shipping_options($purchaseID, $database);

	#error_log("SHIP_OPT=".print_r($shippingOptions,true));

	$purchase = get_purchase_record($purchaseID, $database);
	$shippingID = $purchase->Shipping_Method;

	$shippingCost = $shippingOptions[$shippingID]->cost;
	if ($purchase->free_shipping)
	{
		$shippingCost = 0;
	}
?>
<div align="center">
	<table border="1" cellspacing="0" cellpadding="5">
		<tr>
			<td width="200">
				<h4>Preview</h4>
			</td>
			<td width="500">
				<h4>Description</h4>
			</td>
			<td width="125">
				<h4>Image</h4>
			</td>
			<td width="75" align='right'>
				<h4>Qty.</h4>
			</td>
			<td width="100" align='right'>
				<h4>Price Ea.</h4>
			</td>
			<td width="100" align='right'>
				<h4>Ext. Price</h4>
			</td>
		</tr>
		<?php

		$items = db_get_records("order_item", array('purchase_id'=>$purchaseID));

		$total = 0;

		foreach($items as &$item)
		{
			$pid = $item['product_type_id'];
			$product = db_get_record("product_type", array('product_type_id'=>$pid));
			$item['Product'] = $product;

			$code = $item['code'] = $product['code'];
			$parentCode = null;

			if(!empty($product['parent_product_type_id']))
			{
				$parent = db_get_record("product_type", array('product_type_id'=>$product['parent_product_type_id']));
				$parentCode = $parent['code'];
			}

			$webroot = dirname(__FILE__)."/../app/webroot";

			/*
			$oldBuild = false;
			if(!empty($sides[0]['catalogNumber'])) { # STAMP, use old previewer. 
				$oldBuild = true;
			}
			if(!file_exists("$webroot/images/designs/products/$code.svg") && (empty($parentCode) || !file_exists("$webroot/images/designs/products/$parentCode.svg")))
			{
				$oldBuild = true;
			}
			*/
			
			$sides = db_get_records("item_parts", array('order_Item_ID'=>$item['order_item_id']));

			###############################

			$item['Total']=$item['Quantity'] * $item['Price'] + $item['setupPrice'];
			$total += $item['Total'];
		?>
		<tr>
			<td>
				<? if(empty($item['new_build'])) { # Stamp or non-svg product.... ?>
					<a rel='shadowbox' href="/product_image/order_view?order_item_id=<?= $item['order_item_id'] ?>"><img src="/product_image/order_view/-200x200.png?order_item_id=<?= $item['order_item_id'] ?>"/></a>
					<br/>
				<? } else { # Custom, new ?>
					<? for($i = 0; $i < count($sides); $i++) { ?>
						<? if(count($sides) > 1) { ?>
							<div class='bold'>Side <?= $i+1 ?></div>
						<? } ?>
						<a rel='shadowbox' href="/designs/png/<?= $i+1 ?>/order_item_id:<?= $item['order_item_id'] ?>">
							<img src="/designs/png/<?= $i+1 ?>/width:100/order_item_id:<?= $item['order_item_id'] ?>"/>
						</a>
						<br/>
					<? } ?>
				<? } ?>
			</td>
			<td valign="top">
			<?
				$imageName = null;
				if(!empty($sides[0]['catalogNumber']))
				{
					$imageName = db_get_field("stamp", array('catalog_number'=>$imageName), "stamp_name");
				} else if (!empty($sides[0]['imageID'])) { 
					$imageName = "Custom";
				}
				if($item['code'] == 'TA')
				{
					$imageName=db_get_field("tassel", array('tassel_id'=>$sides[0]['tassel_ID']), "color_name");
				} else if ($item['code'] == 'CH') { 
					$imageName=db_get_field("charm", array('charm_id'=>$sides[0]['charm_ID']), "name");
				}
			?>
			<b>Name:</b> 
				<?= !empty($imageName) ? $imageName : null ?>
				<?= $product['name'] ?>
				<? if(!empty($sides[0]['reproduction'])) { ?>
					(reproduction)
				<? } ?>
				<? if(!empty($sides[1])) { ?>
				(Double Sided)
				<? } ?>
				
				<br />
				<b>Catalog:</b> 
				<? $i = 0; foreach($sides as $side) { ?>
					<?= $i++ > 0 ? " / " : "" ?>
					<? if(!empty($side['reproduction'])) { ?>R-<? } ?>
					<?= $item['code'] ?><? if(!empty($side['personalizationLogo'])) { ?>-Logo#<?= $side['personalizationLogo'] ?>
					<? } ?><? if(!empty($side['catalogNumber'])) { ?>-<?= $side['catalogNumber'] ?>
					<? } ?><? if(!empty($side['imageID'])) { ?>-CI#<?= $side['imageID'] ?>
					<? } ?><? if ($product['code']=="CH"){ ?>-<?= $side['charm_ID'] ?>
					<? } ?><? if ($product['code']=="TA"){ ?>-<?= $side['tassel_ID'] ?>
					<? } ?>

				<? } ?>
					<? if(!empty($item['new_build']) && (empty($readonly) || $readonly == 'admin')) { ?>
					<div>
						<? for($i = 0; $i < count($sides); $i++) { ?>
							<?= $i > 0 ? " | " : "" ?>
							<a href="/designs/svg/<?= $i+1 ?>/order_item_id:<?=$item['order_item_id']?>/print:1/Order-<?=$item['Purchase_id'] ?>-<?= $product['code'] ?>-<?= !empty($sides[$i]['imageID']) ? $sides[$i]['imageID'] : null ?>-side<?= $i+1?>.svg">Download SVG Side <?= $i+1 ?></a>
						<? } ?>
					</div>
					<? } ?>
				<br/>

			<? if(!empty($item['proof'])) { ?><b>Proof:</b> <?= $item['proof'] ?><br/><? } ?>
				
			<?
			# NOW GO THROUGH EACH SIDE....

			$sidenum = 1; foreach($sides as $side)
			{
				if(count($sides) > 1) { 
					echo "<br/><i>Side $sidenum</i><div style='padding-left: 25px;'>";
				}
				$sidenum++;

				if(!empty($side['template'])) { ?>
					<b>Layout:</b> <?= $side['template'] ?><br/>
				<? } 
				if (!empty($side['ribbon_ID'])){
					$ribbonColor = db_get_field("ribbon", array('ribbon_id'=>$side['ribbon_ID']), 'color_name');
					echo "<b>Ribbon:</b> $ribbonColor<br/>";
				};
				if (!empty($side['tassel_ID']))
				{
					$tasselColor = db_get_field("tassel", array('tassel_id'=>$side['tassel_ID']), 'color_name');
					echo "<b>Tassel:</b> $tasselColor<br/>";
				};
				if (!empty($side['charm_ID']))
				{
					$charm = db_get_record("charm", array('charm_id'=>$side['charm_ID']));
					echo "<b>Charm:</b> " . $charm['name'] . "<br /><IMG alt='{$charm['name']} charm' src='" . $charm['graphic_location'] ."'/><br />";
				};
				if (!empty($side['quote_ID']))
				{
					$quote = db_get_record("quote", array('quote_id'=>$side['quote_ID']));
					echo "<b>Quote:</b> ".(!empty($quote['text']) ? $quote['text'] : $quote['title']). "<i>{$quote['attribution']}</i><br/>";
				};
				if (!empty($side['custom_quote'])){
					echo "<b>CUSTOM QUOTE";
					echo ": </b>  {$side['custom_quote']}<br />";
				};
				if(!empty($side['quote_ID']) || !empty($side['custom_quote'])) { 
					if(!empty($side['centerQuote']))
					{
						echo "<b>Centered Quote</b><br/>";
					}
					if(!empty($side['textSize']))
					{
						echo "<b> ({$side['textSize']})</b> ";
					}
					if(!empty($side['alignQuote']))
					{
						echo "<b>({$side['alignQuote']} align)</b><br/>";
					}
				}

				if ($side['personalization'] == "") { $side['personalization'] = "<i>None</i>"; }

				if (!empty($side['personalization_logo_id'])) { echo "<b>Personalization Logo:</b> Logo #{$side['personalization_logo_id']}<br/>"; 
				} else if (!empty($side['personalization'])) { 
					echo "<b>Personalization";
					if(!empty($side['personalizationSize']))
					{
						echo " ({$side['personalizationSize']})";
					}
					echo ": </b>  {$side['personalization']} ";
					echo " (";
					if(!empty($side['personalizationColor'])) {echo $side['personalizationColor']." "; }
					if(!empty($side['personalizationStyle'])) { echo $side['personalizationStyle']; };
					echo ")";
					echo "<br/>";
				}
				if (!empty($side['border_ID'])){
					$border = db_get_record("border", array('border_id'=>$side['border_ID']));
					
					echo "<b>Border:</b> {$border['name']} <IMG align='absmiddle' alt='{$border['name']} border' src='{$border['location']}'/><br />";
				};
				if (!empty($side['frameID'])){
					$frame = db_get_field("frame", array('frame_id'=>$side['frame_ID']),'name');
					echo "<b>Frame</b>: $frame<br />";
				};
				if (!empty($side['pinStyle'])){
					echo "<b>Pin Style:</b>  {$side['pinStyle']}<br />";
				};
				if (!empty($side['handles'])){
					echo "<b>Handle Color:</b>  {$side['handles']}<br />";
				};
				if (!empty($side['backgroundColor']) && !in_array($side['backgroundColor'], array('FFF','FFFFFF')) ){
					if(!preg_match("/^#/", $side['backgroundColor'])) { $side['backgroundColor'] = '#'.$side['backgroundColor']; }
					echo "<b>Background Color:</b>  <span style='background-color: {$side['backgroundColor']};'>&nbsp; &nbsp; &nbsp; &nbsp;</span><br />";
				};
				if (!empty($side['Size'])){
					echo "<b>Size:</b>  {$side['Size']}<br />";
				};
				if (!empty($side['PrintSide'])){
					echo "<b>Print Side:</b>  {$side['PrintSide']}<br />";
				};
				if(count($sides) > 1) { 
					echo "</div>";
				}
			}
			if (!empty($item['comments'])){
				echo "<br /><br /><b>Item Comments:</b>  <i>{$item['comments']}</i><br />";
			};
			?>
			</td>
			<td valign="top">
			<? $i = 0; foreach($sides as $side) { # XXX TODO RAW IMAGES ?>
				<?
				$imageLocation = $imageThumb = null;
				if(!empty($side['imageID']))
				{
					$image = db_get_record("custom_image", array('image_id'=>$side['imageID'])); 
					# XXX may need to hack for other location...
					$imageLocation = $image['Image_Location'];
					$imageThumb = $image['thumbnail_location'];
				} else if (!empty($side['catalogNumber'])) { 
					$image = db_get_record("stamp", array('catalog_number'=>$side['catalogNumber'])); 
					$imageLocation = $image['image_location'];
					$imageThumb = $image['thumbnail_location'];

				} else if (!empty($side['personalization_logo_id'])) { 
					$image = db_get_record("custom_image", array('image_id'=>$side['personalization_logo_id'])); 
					$imageLocation = $image['Image_Location'];
					$imageThumb = $image['thumbnail_location'];

				}

				if(!empty($imageLocation)) { ?>
					<a title="Side <?= $i+1 ?>" href="<?= $imageLocation ?>"><img src="<?= $imageThumb ?>" width="80"/></a><br>
				<? } ?>
			<? $i++; } ?>

			</td>
			<td valign="top" align='right'>
				<? if(!empty($item['Size'])) { ?>
				<table>
					<?
						# Q S, Q S, Q S
						preg_match_all("/(\d+) (\w+),/", $item['Size'], $pairs);
						$sizes = array_combine($pairs[2], $pairs[1]);

						foreach($sizes as $size=>$qty)
						{
						?>
						<tr><td style="height: 2em;">
							<b><?= $size ?>:</b> <?= $qty ?>
						</td></tr>
						<?
						}
						?>
				</table>
				<? } else { ?>
					<?php echo $item['Quantity']; ?><br />
				<? } ?>
			
			</td>
			<td valign="top" align='right'>
				<? if(!empty($item['Size'])) { ?>
				<table>
					<?
						# Q S, Q S, Q S
						preg_match_all("/(\d+) (\w+),/", $item['Size'], $pairs);
						$sizes = array_combine($pairs[2], $pairs[1]);

						foreach($sizes as $size=>$qty)
						{
						?>
						<tr><td style="height: 2em;">
						<?
							$surcharge = !empty($item['Product']["surcharge_$size"]) ? $item['Product']["surcharge_$size"] : 0; 
							echo sprintf('x $%01.2f', $item['Price']+$surcharge); 
						?>
						</td></tr>
						<?
						}
						?>
				</table>
				<? } else { ?>
					<?php echo "\$".sprintf("%01.2f", $item['Price']); ?>
				<? } ?>

				<? if(intval($item['setupPrice']) && empty($sizes)) { ?>
				<div style="font-weight: bold;"> <?= sprintf("+$%u setup", $item['setupPrice']); ?></div>
				<? } ?>
			</td>
			<td valign="top" align='right'><?php echo "\$".sprintf("%01.2f", $item['Total']); ?></td>
		</tr>
		<?php
			};
		?>
		<tr>
		  <td></td>
			<td></td>
			<? if (!$readonly) { ?>
			<td></td>
			<? } ?>
			<td colspan="2">
				<div align="right">
					<b>Sub-Total:</b></div>
			</td>
			<td align='right'>

			<?= sprintf('$%01.2f', $total); ?>
		</tr>
		<? if(!empty($purchase->discount)) { ?>
		<tr>
		  <td></td>
			<td></td>
			<? if (!$readonly) { ?>
			<td></td>
			<? } ?>
			<td colspan="2">
				<div align="right">
					<b>Promo Code:</b><br/>
					(<?= $purchase->coupon ?>)
				</div>
			</td>
			<td align='right'>
				<?= sprintf("-$%01.2f", $purchase->discount); ?>
			</td>
		</tr>
		<? } ?>
		<tr>
		  <td></td>
			<td></td>
			<? if (!$readonly) { ?>
			<td></td>
			<? } ?>
			<td colspan="2">
				<div align="right">
					<b>Shipping:</b></div>
			</td>
			<td align='right'>
			<? if ($purchase->free_shipping) { ?>
				<div style="text-decoration: line-through;">
					<?= sprintf("$%01.2f", $oldShippingCost); ?>
				</div>
			<div class="bold alert2" style="font-weight: bold; color: red;">FREE</div>
			<? } else { ?>
				<b><?= sprintf("$%01.2f", $shippingCost); ?></b>
			<? } ?>
			</td>
		</tr>
		<? if (!$readonly) { ?>
		<?php
			if ( (float)$shippingCost != (float)$originalShipping ) {
				echo "<tr>\n<td colspan=\"3\"></td>\n<td colspan=\"2\" style=\"text-align: right; font-style: italic;\">Original Shipping:</td>\n";
				echo "<td style=\"font-style: italic;\" align='right'>\$$originalShipping</td>\n</tr>\n";
			}
		?>
		<? } ?>

		<? if(!empty($purchase->rush_cost)) { ?>
		<tr>
		  <td></td>
			<td></td>
			<? if (!$readonly) { ?>
			<td></td>
			<? } ?>
			<td colspan="2">
				<div align="right">
					<b>Rush charge:</b></div>
			</td>
			<td align='right'>
				<?= sprintf("$%01.2f", $purchase->rush_cost); ?>
			</td>
		</tr>
		<? } ?>
		<tr>
		  <td></td>
			<td></td>
			<? if (!$readonly) { ?>
			<td><div align="right">
						    <input type="submit" name="Submit1" value="Recalculate and Submit Changes">						      
					      </div></td>
			<? } ?>
			<td colspan="2">
				<div align="right">
					<b>Total:</b></div>
			</td>
			<td align='right'>
				<?= sprintf("\$%01.2f", $total+$shippingCost+$purchase->rush_cost-$purchase->discount);
				?>
			</td>
		</tr>
	</table>
</div>

<?
}

?>
