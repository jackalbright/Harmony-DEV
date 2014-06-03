<?
# Centralized code for retrieving pricing of a product, especially for wholesale accounts....


function get_product_pricing($productCode, $quantity = null, $options = array())
# If we specify a specific quantity, just return that pricing (per item)
# Otherwise, return a list of all quantities....
{

	if ($quantity > 0)
	{
		return get_product_pricing_for_quantity($productCode, $quantity, $options);
	} else {
		return get_product_pricing_all($productCode, $options);
	}
}

function update_cart_pricing() # For wholesalers who log in after items put in cart.
{
	$modifiedCart = array();

	foreach($_SESSION['shoppingCart'] as &$cartItem)
	{
		list ($quantity, $unitPrice) = get_product_pricing_for_quantity($cartItem->productCode, $cartItem->quantity, $cartItem);
		$cartItem->unitPrice = $unitPrice;
		$modifiedCart[] = $cartItem;
	}
	$_SESSION['shoppingCart'] = $modifiedCart;
}

function get_product_pricing_for_quantity($productCode, $quantity, $options = array())
{
		global $database;
		$pricePoints = array();
		$pricing = array();

		if (is_object($options) && is_object($options->parts)) { $options = get_object_vars($options->parts); }
		else if (is_object($options)) { $options = get_object_vars($options); }
		#error_log("CUST_OPT=".print_r($options,true));

		if ($productCode == 'BC') { 
			$productCode = 'B'; 
			$options['charm'] = 1;
		} # proper pricing....
		if ($productCode == 'PSF') { 
			$productCode = 'PS'; 
			$options['poster_frame'] = 1;
		} # proper pricing....

		$product = get_db_record("product_type", array("code"=>$productCode));
		$base_price = $product['base_price'];
		$product_id = $product['product_type_id'];
		#error_log("BASE1=$base_price");
		$product_parts = get_db_records("product_part", array('product_type_id'=>$product_id));

		#error_log("BASE_PRICE=$base_price");



		#$q="SELECT MAX(quantity) AS min_quantity FROM pricePoint WHERE productCode = '$productCode' AND quantity < '$quantity'";
		#$result = mysql_query($q, $database);
		#$minimum = mysql_fetch_assoc($result);
		#$min_quantity = $minimum['min_quantity'];
		$min_quantity = $product['minimum'];
		##error_log("MIN=($q)=".print_r($minimum,true));

		$customer = !empty($_SESSION['customerRecord']) ? $_SESSION['customerRecord'] : null;
		# XXX TODO FOR CUSTOMER
		if ($customer && !empty($customer['pricing_level']))
		{
			$pricing_level = $customer['pricing_level'];
			if ($pricing_level != "" && $pricing_level > $min_quantity) { $quantity = $pricing_level; }
		}

		#error_log("Q=$quantity, MIN=$min_quantity");

		$result = mysql_query ("Select quantity, price,percent_discount from pricePoint where productCode = '$productCode' AND quantity <= '$quantity' ORDER BY quantity DESC LIMIT 1", $database);
		$pricing = mysql_fetch_assoc($result);
		#error_log("BASE2=$base_price, PRIC=".print_r($pricing,true));
		$discount = $pricing['percent_discount'];
		if ($discount <= 0) { 
			$price = $pricing['price']; 
		} else {
			$price = round($base_price * $discount / 100, 2);
		}

		#error_log("DISCOUNT=$discount, DISC_PRICE_START=$price");

		# MOVED PART PRICING ADD TO AFTER DISCOUNT APPLIED
		# NOT ADDING PARTS TO PRICING....
		foreach($product_parts as $product_part)
		{
			$part_id = $product_part['part_id'];
			$part = get_db_record("part_type", array('part_id'=>$part_id));
			$part_code = $part['part_code'];
			$value = !empty($options[$part_code."ID"]) ? $options[$part_code."ID"] : null;
			if (!$value && !empty($options[$part_code])) { $value = $options[$part_code]; }

			$custom_value = !empty($options["custom".ucfirst($part_code)]) ?  $options["custom".ucfirst($part_code)] : null;
			#error_log("C=$part_code, V=$value, C=$custom_value, PRICE=".$part['price']);
			if ($value != 'None' && $part['price'] > 0 && $product_part['optional'] == 'yes' && (!empty($value) || is_numeric($value) || is_numeric($custom_value))) # We are set.
			{
				$price += $part['price'];
			#} else if ($part['price'] > 0 && $product_part['optional'] == 'yes' && (!is_numeric($value) && !is_numeric($custom_value))) # We are set.
			#{
			#####	# Excluded, subtract.
			}
		}

		#error_log("PRICE=$price");

		$result = mysql_query ("Select * FROM price_points WHERE quantity <= '$quantity' ORDER BY quantity DESC LIMIT 1", $database);
		$pricePoint = mysql_fetch_assoc($result);

		if ($price == 0) { $price = $base_price; } # Don't let anything crazy happen....

		#return array($pricePoint['quantity'], $pricing['price']);
		return array($pricePoint['quantity'], $price);
}

function get_product_pricing_all($productCode, $options = array())
# For the 'chart', unknown quantity.
{
		global $database;
		$pricePoints = array();
		$pricing = array();

		if (is_object($options)) { $options = get_object_vars($options); }

		if ($productCode == 'BC') { $productCode = 'B'; } # proper pricing....

		$customer = !empty($_SESSION['customerRecord']) ? $_SESSION['customerRecord'] : null;
		# $customer['wholesale_level'] = 100 # Default... so get the 100 pricing
		# What if we ask for 500? do we just get that pricing? ie 'change the minimums' only?
		# XXX TODO FOR CUSTOMER
		$pricing_level = 1;
		if ($customer && !empty($customer['pricing_level']))
		{
			$pricing_level = $customer['pricing_level'];
			if ($pricing_level != "") { $quantity = $pricing_level; }
		}

		$product = get_db_record("product_type", array("code"=>$productCode));
		$product_id = $product['product_type_id'];
		$base_price = $product['base_price'];

		$product_parts = get_db_records("product_part", array('product_type_id'=>$product_id));
		$parts_price = 0;
		foreach($product_parts as $product_part)
		{
			$part_id = $product_part['part_id'];
			$part = get_db_record("part_type", array('part_id'=>$part_id));
			$part_code = $part['part_code'];
			$value = !empty($options[$part_code."ID"]) ? $options[$part_code."ID"] : null;
			$custom_value = !empty($options["custom".ucfirst($part_code)]) ?  $options["custom".ucfirst($part_code)] : null;
			#echo "C=$part_code, V=$value, C=$custom_value";
			if ($part['price'] > 0 && (is_numeric($value) || is_numeric($custom_value))) # We are set.
			{
				$parts_price += $part['price'];
			}
		}

		$result = mysql_query ("Select quantity, price,percent_discount  from pricePoint where productCode = '$productCode' order by quantity", $database);
		# All wholesale does is change minimum!
		$ix = 0;
		while ( $temp = mysql_fetch_object($result) ) {
			# Go thru and ADJUST pricing appropriately...
			if ($temp->quantity < $pricing_level) { $ix++; }
			$pricePoints[] = $temp->quantity;
			#$pricing[] = $temp->price;
			if ($temp->percent_discount <= 0)
			{
				$pricing[] = $temp->price + $parts_price;
			} else {
				$pricing[] = round($base_price * $temp->percent_discount / 100, 2) + $parts_price;
			}
		}
		#echo "IX=$ix";
		#error_log("PRIC ($base_price) =".print_r($pricing,true));
		#print_r($pricePoints);
	
		for($i = 0; $i < $ix; $i++)
		{
			$pricing[$i] = $pricing[$ix];
		}

		return array($pricePoints, $pricing);
}

?>
