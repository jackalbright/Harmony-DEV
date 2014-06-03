<?php
	include_once ('../includes/session.inc');
	include_once ('../includes/database.inc');
/* ######## Load settings ######## */
	$queryString = "SELECT packageWeightMultiplier FROM settings WHERE settingsID =1";
	$result = mysql_query ($queryString, $database);
	$object = mysql_fetch_object($result);
	$packageWeightMultiplier = $object->packageWeightMultiplier;

	$products = array();
	$queryString = "Select * from product_type where available = 'yes' order by sort_index";
	$result = mysql_query($queryString, $database);
	while ($temp = mysql_fetch_object($result)) {
		$products[$temp->product_type_id] = $temp;
	}
	
/* ######## Determine if Form was Submitted ######## */
	if (array_key_exists('zipCode', $_POST)) {
		$formSubmitted = true;
	} else {
		$formSubmitted = false;
	}
	
/* ######## Process Form ######## */
	if ($formSubmitted) {
		$zipCode = $_POST['zipCode'];
		unset($_POST['zipCode']);
		
		$itemWeight = 0;
		foreach ($_POST as $itemID => $itemQuantity) {
			$itemWeight += ($products[$itemID]->weight * $itemQuantity);
		}

		$packageWeight = $itemWeight * $packageWeightMultiplier;
		$orderWeight = $packageWeight + $itemWeight;
		$poundWeight = $orderWeight * 0.00220462262;
		$pkgMultiplier = ceil($poundWeight/70);
		$pkgWeight = ceil($poundWeight/$pkgMultiplier);
		$shippingWeight = ceil($poundWeight);

		$queryString = "SELECT * from `handlingCharge` where weight <= $poundWeight order by weight desc limit 1";
		$result = mysql_query ($queryString, $database);
		$object = mysql_fetch_object($result);
		$handlingCharge = $object->price;
	
		$shippingOptions = array();
		$queryString = "SELECT shippingMethod.*,shippingPricePoint.cost FROM `shippingZoneUS`, `shippingPricePoint`, `shippingMethod` WHERE shippingZoneUS.zipStart <= $zipCode and shippingZoneUS.zipEnd >= $zipCode and shippingZoneUS.shippingMethod = shippingMethod.shippingMethodID and shippingMethod.available = 'yes' and shippingMethod.shippingMethodID = shippingPricePoint.shippingmethod and shippingZoneUS.zoneNumber = shippingPricePoint.zoneNumber and shippingPricePoint.weight = $pkgWeight order by shippingMethod.type";
		$result = mysql_query($queryString, $database);
		while ($temp = mysql_fetch_object($result)) {
			$shippingOptions[] = $temp;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Shipping Calculator - Harmony Designs Inc.</title>
	<meta name="description" content="Calculate shipping for any quantity of harmony designs custom gifts." />
	<link rel="Stylesheet" href="/stylesheets/base.css" type="text/css" media="all" />
	<link rel="Stylesheet" href="/stylesheets/newLayout.css" type="text/css" media="all" />
	<style type="text/css" media="all">
		#main { width: 542px; }
		table.dataEntry
		{
			border-width: 3px;
			border-style: groove;
			border-color: #FFF;
			background-color: #FFE;
			margin-left: auto;
			margin-right: auto;
		}
		.dataEntry td { padding: 3px; }
		.dataEntry th
		{
			background-color: #060;
			color: #FFE;
			padding: 3px;
			text-align: left;
			font-family: serif;
			font-weight: bold;
			font-size: 1.1em;
		}
		.formLabel
		{
			text-align: right;
			font-weight: bold;
			font-size: 0.8em;
			vertical-align: text-top;
			line-height: 1.2em;
		}
		.formField { text-align: left; }
		.formField input
		{
			padding: 2px;
			margin: 0;
		}
	</style>
</head>
<body>
	<div id="mainWrapper">
		<div id="contentWrapper">
	
			<div id="title">
				<h1>Calculate Shipping <span class="note">(U.S. Only)</span></h1>
			</div> <!-- End Title -->
			
			<div id="main">
				<?php if ($formSubmitted) { ?>
					<table class="dataEntry" id="shippingResults">
						<tr>
							<th colspan="2">Shipping Destination</th>
						</tr>
						<tr>
							<td class="formLabel">Zip Code</td>
							<td class="formField"><?php echo $zipCode; ?></td>
						</tr>
						<tr>
							<th colspan="2">Shipping Options</th>
						</tr>
						<?php
							foreach ($shippingOptions as $shipMethod) {
								echo "<tr>\n";
								echo "<td class=\"formLabel\">" . $shipMethod->name . "</td>\n";
								echo "<td class=\"formField\">$" . round( $shipMethod->cost*$pkgMultiplier, 2 ) . "</td>\n";
								echo "</tr>\n";
							}
						?>
						<tr>
							<th colspan="2"></th>
						</tr>
						<tr>
							<td class="formLabel">Handling Charge</td>
							<td class="formField">$<?php echo $handlingCharge; ?></td>
						</tr>
						<tr>
							<th colspan="2"></th>
						</tr>
						<tr>
							<td class="formLabel">Total Weight<br /><span class="note">(Pounds)</span></td>
							<td class="formField"><?php echo $shippingWeight; ?></td>
						</tr>
						<tr>
							<td class="formLabel">Number of Packages</td>
							<td class="formField"><?php echo $pkgMultiplier; ?></td>
						</tr>
					</table>
				<?php } ?>
				<p>
					To calculate shipping please fill in the destination zip code and the quantity for each item.
				</p>
				<form action="/admin38/shippingCalculator.php" method="post" id="shippingCalc" name="shippingCalc">
					<table class="dataEntry">
						<tr>
							<th colspan="4">Shipping Destination</th>
						</tr>
						<tr>
							<td class="formLabel">Zip Code</td>
							<td colspan="2" class="formField"><?php echo "<input type=\"text\" id=\"zipCode\" name=\"zipCode\" size=\"12\" value=\"$zipCode\" />"; ?></td>
							<td></td>
						</tr>
						<tr>
							<th colspan="4">Item Quantities</th>
						</tr>
						<?php
							$ct = 1;
							foreach ($products as $product) {
								if ($ct%2 ==1)
									echo "<tr>\n";
								echo "<td class=\"formLabel\">" . $product->name . "</td>\n";
								echo "<td class=\"formField\"><input type=\"text\" id=\"" . $product->product_type_id . "\" name=\"" . $product->product_type_id . "\" size=\"4\" value=\"" . ($formSubmitted ? $_POST[$product->product_type_id] : 0) . "\"/></td>\n";
								if ($ct%2 == 0)
									echo "</tr>\n";
								$ct++;
							}
						?>
						<tr>
							<th colspan="4">
							</th>
						</tr>
						<tr>
							<td colspan="4" class="formButtons">
								<button class="imgButton" type="submit"><img src="/new-buttons/Submit-dk.gif" alt="Submit" width="96" height="29" /></button>
								<button class="imgButton" type="reset"><img src="/new-buttons/Reset-dk.gif" alt="Submit" width="96" height="29" /></button>
							</td>
						</tr>
					</table>
				</form>
			</div> <!-- End Main -->
			
		</div> <!-- End contentWrapper -->
		
		<div id="leftbar">
			<div id="bookmark">
				<div id="bookContents">
					<?php
						include ('../includes/mainNavigationLeft.inc');
					?>
				</div> <!-- End bookContents -->
				<div id="bookBottom">
				</div>
			</div> <!-- End bookmark -->
		</div> <!-- End leftbar -->
	
	</div> <!-- End mainWrapper -->
	
	<div id="footer">
		<?php
			include ('../includes/footer.inc')
		?>
	</div> <!-- End footer -->
	
	<br />
	<div id="header">
		<?php
			include ('../includes/header.inc')
		?>
	</div> <!-- End Header -->

</body>
</html>
