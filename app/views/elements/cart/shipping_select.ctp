<?  $updateClick = empty($checkout) ? "updateCartReview();" : "updateShippingSpeedReview();"; ?>
<?
	$order_more = $config['free_ground_shipping_minimum'] - $eligible_subtotal;
	# Need to loop through card and see if item is eligible. (need product info)
?>
<tr>
	<td align="left" valign="top" colspan=3>
	<?
		$hour_of_day = date("H");
		$minute_of_hour = date("i");
		$seconds_of_hour = date("s");
		$hours_until_noon = ($hour_of_day <= 12) ? (12 - $hour_of_day - 1) : (24 - $hour_of_day + 12 - 1);
		$minutes_until_hour = floor(60 - $minute_of_hour - $seconds_of_hour/60);
	?>
	
	<!--Order in the next <span style="color: #FF6600;"><? if($hours_until_noon > 0) { ?><?= $hours_until_noon > 1 ? "$hours_until_noon hours" : "$hours_until_noon hour" ?> and <? } ?><?= $minutes_until_hour ?> minutes</span> to ship by <?= date("l, F jS", $ships_by_time) ?>
	<br/>
	<br/>
	-->
	<? if(empty($checkout)) { ?>
	<div class="bold">Choose a shipping speed:</div>
	<? } ?>
	<? $fastest = null; ?>
	<div style="padding-left: 0px;">
	<table cellpadding=0 cellspacing=0 width="100%">
			<? if(!empty($shippingOptions) && empty($shipping_select)) { ?>
				<? if(!empty($read_only_summary)) { ?>
					<? $i = 0; foreach($shippingOptions as $shippingOption) { 
						if ((empty($defaultShippingMethod) && $i++ == 0) || $defaultShippingMethod == $shippingOption['shippingPricePoint']['shippingMethod'])
						{
							$dayMin = $shippingOption['shippingMethod']['dayMin'];
							$dayMax = $delivery_days = $shippingOption['shippingMethod']['dayMax'];
							$delivery_time = $ships_by_time;# + 24*60*60;
							while($delivery_days > 0)
							{
								$delivery_time += 24*60*60;
								$delivery_day = date("D", $delivery_time);
								if ($delivery_day != "Sun" && $delivery_day != "Sat") { $delivery_days--; }
							}
							$pretty_date = date("l, F jS", $delivery_time);
							?>
							<b><?= $pretty_date ?></b>
							<?= empty($shippingOption[0]['cost']) ? "- <span style='color: #009900; font-weight: bold;'>FREE</span>" : "" ?></b>
							<?
						}
					} ?>

				<? } else { ?>
					<? $i = 0; foreach($shippingOptions as $shippingOption) { ?>
					<?
						$dayMin = $shippingOption['shippingMethod']['dayMin'];
						$dayMax = $delivery_days = $shippingOption['shippingMethod']['dayMax'];
						$delivery_time = $ships_by_time;# + 24*60*60;
						while($delivery_days > 0)
						{
							$delivery_time += 24*60*60;
							$delivery_day = date("D", $delivery_time);
							if ($delivery_day != "Sun" && $delivery_day != "Sat") { $delivery_days--; }
						}
						#$pretty_date = date("D, M jS", $delivery_time);
						$pretty_date = date("l, F jS", $delivery_time);
						$num2name = array('Zero','One','Two','Three','Four','Five','Six','Seven','Eight','Nine','Ten');
						$shiptype = ucfirst($num2name[$dayMax]) . " Day";
						if($dayMax >= 5) { $shiptype = 'Standard'; }
						if($dayMax == 1) { $shiptype = 'Overnight'; }

						$fastest = $shippingOption;
					?>
					<tr>
					<td valign="top">
					<input type="radio" name="data[receive_by]" onClick="<?= $updateClick ?>" <?= ((empty($defaultShippingMethod) && $i == 0) || ($defaultShippingMethod == $shippingOption['shippingPricePoint']['shippingMethod'])) && empty($rush_date) ? "checked='checked'" : "" ?> value="<?= $shippingOption['shippingPricePoint']['shippingMethod']?>">
					</td>
					<td valign="top" align="left">
						<div style="padding-top: 2px; padding-bottom: 10px;">
						<? if(empty($country) || $country == 'US') { ?>
						<?= $shiptype ?> Shipping <? if($shiptype == 'Standard') { ?>(<?= $dayMin ?> - <?= $dayMax ?> days)<? } ?>
						<? } else { ?>
							<?= $shippingOption['shippingMethod']['name'] ?>
						<? } ?>
						<?= empty($shippingOption[0]['cost']) ? "<span style='color: #009900; font-weight: bold;'>- FREE</span> " : sprintf("- $%.02f", $shippingOption[0]['cost']); ?>
						<br/>
						<!--<span style="color: #009900; font-weight: bold;">Get it by <?= $pretty_date ?> </span>-->
						<? if($i == 0 && $order_more > 0 && empty($customer['is_wholesale']) && $this->params['controller'] != 'checkout') { ?>
						<div class="relative">
						<div class="alert2">Order <?= sprintf("$%.02f", $order_more); ?> more to qualify for FREE standard shipping (Excludes paperweights, paperweight kits and mugs.)
						</div>
						<? } ?>
						</div>
					</td>
					</tr>
					<? $i++; } ?>
				<? } ?>
			<? } else if (!empty($checkout)) { ?>
			<div class="bold">Please enter a valid postal code to calculate shipping costs</div>
			<? } ?>






	<br/>


	<!--
	changing one dropdown to set two values (rush_date AND shipping_method_id)
	make them hidden ? receive_by=ship_method_id:rush_date sets two hidden fields.
	-->


	<? 
	if(!empty($rush_dates)) { 

	$i = 0; foreach($rush_dates as $raw_date => $extra_cost) { 
		#$pretty_date = date("D, M jS", strtotime($raw_date));
		$pretty_date = date("l, F jS", strtotime($raw_date));
		$shiptype = "Standard";
		if($dayMax == '2') { $shiptype = 'Two Day'; }
		if($dayMax == '3') { $shiptype = 'Three Day'; }
		if($dayMax == '1') { $shiptype = 'Overnight'; }

	?>
	<tr>
	<td valign="top">
	<input type="radio" name="data[receive_by]" onClick="<?= $updateClick ?>" <?= (empty($rush_date) && $extra_cost == 0) || (!empty($rush_date) && $rush_date == $raw_date) ? "checked='checked'" : "" ?> value="<?= $rush_shipping_method_id ?>:<?= $raw_date ?>"/> 
	</td>
	<td valign="top" align="left">
		<div style="padding-top: 2px; padding-bottom: 10px;">
			<div style="">
				<?= $shiptype ?> + <b>Rush Order</b> - <?= sprintf(" $%.02f", $fastest[0]['cost']+$extra_cost); ?>
			</div>
			<span style="color: #444444; font-weight: bold;">Get it by <?= $pretty_date ?> </span>
		</div>
	</td>
	</tr>
	<? } 

	}
	
	?>

	<? if(false && !empty($rush_dates)) { ?>
	<tr>
		<td colspan=2>
			<div style="padding-left: 5px;">
			<b>* Rush charges may apply</b>. <!--No email proof available.-->
			</div>
		</td>
	</tr>
	<? } ?>

	</table>

	</div>

	</td>
</tr>

