<div>
<h3>User Session:</h3>

<div class="right hidden">
	doesnt work for long sessions....
	<a href="/admin/tracking_requests/session/<?= $session_prev ?>">&laquo; Previous</a> |
	<a href="/admin/tracking_requests/session/<?= $session_next ?>">Next &raquo;</a>
</div>
<table border=1>
<tr>
	<th>Session ID</th>
	<td>
		<?= $session_id ?>
	</td>
</tr>
<tr>
	<th>Session Time:
	</th>
	<td>
		<?= $session_start ?> - <?= $session_end ?><br/>
		<?
		$seconds = $session_length;
		$mins = 0;
		$hours = 0;
		if ($seconds > 60)
		{
			$mins = intval($session_length / 60);
			$seconds -= $mins*60;
		}
		if ($mins > 60)
		{
			$hours = intval($mins / 60);
			$mins -= $hours*60;
		}
		?>
		<?= sprintf("%u hours, %u minutes, %u seconds", $hours, $mins, $seconds); ?>
	</td>
</tr>

<tr>
	<th>Account</th>
	<td>
		<pre>
			<? print_r($account); ?>
		</pre>
	</td>
</tr>

<tr>
	<th>Computer Address:
	</th>
	<td>
		<a href="/admin/tracking_requests/session/<?= $address_ip ?>"><?= $address?></a> (<?= $address_ip ?>)
	</td>
</tr>
<tr>
	<th>Location:
	</th>
	<td>
		<?= $location['city'] ?>, <?= $location['region'] ?> <?= $location['country_name'] ?> <?= $location['postal_code'] ?> (<?= $location['longitude']?> longitude, <?= $location['latitude'] ?> latitude, area code <?= $location['area_code'] ?>)
	</td>
</tr>
<tr>
	<th>Browser:
	</th>
	<td>
		<?= $browser ?>
	</td>
</tr>
<tr>
	<th>Referral Source:
	</th>
	<td>
		<?= $referer ?>
	</td>
</tr>
<tr>
	<th>Search Keywords:
	</th>
	<td>
		<?= $keywords ?>
	</td>
</tr>
<tr>
	<th>Custom Images:
	</th>
	<td>
		<? foreach($custom_images as $custom_image) {  ?>
			<a href="<?= $custom_image['CustomImage']['Image_Location'] ?>">
			<img src="<?= $custom_image['CustomImage']['display_location']; ?>" height="150">
			</a>
		<? } ?>
		
	</td>
</tr>

<tr>
	<th>Cart Items:
	</th>
	<td>
		<? foreach($cart_items as $cart_item) {  ?>
			<div class="left" style="width: 200px; border-right: solid #CCC 1px;">
			<b>Cart ID:</b> <?= $cart_item['CartItem']['cart_item_id'] ?><br/>
			<b>Date/Time:</b> <?= $cart_item['CartItem']['created'] ?><br/>
			<b>Item:</b> <?= $cart_item['CartItem']['productCode'] ?><br/>
			<b>Date:</b> <?= $cart_item['CartItem']['created'] ?><br/>
			<b>Qty:</b> <?= $cart_item['CartItem']['quantity'] ?><br/>
			<b>Price:</b> <?= $cart_item['CartItem']['unitPrice'] ?><br/>
			<b>Parts:</b>
				<div style="padding-left: 20px;">
					<? $parts = unserialize($cart_item['CartItem']['parts']); 
					foreach($parts as $part => $value) { ?>
					<i><?= $part ?>:</i> <?= $value ?><br/>
					<? } ?>
				</div>
				<br/>
			<b>Preview:</b>
			<?
				$prod = $cart_item['CartItem']['productCode'];
				$imgtype = "";
				if (!empty($parts['customImageID'])) { $imgtype = 'Custom'; $imgid = $parts['customImageID']; }
				if (!empty($parts['catalogNumber'])) { $imgtype = 'Gallery'; $imgid = $parts['catalogNumber']; }
			?>
			<div>
			<a rel="" href="/images/preview/<?= $prod ?>/<?= $imgtype ?>/<?= $imgid ?>.png">
				<img src="/images/preview/<?= $prod ?>/<?= $imgtype ?>/_<?= $imgid ?>/x150.png"/>
			</a>
			</div>

			</div>
		<? } ?>
		
	</td>
</tr>
<? if(!empty($cart_items) && !empty($account)) { ?>
<tr>
	<th>Send Reminder Email:</th>
	<td>
		<form method="POST" action="/admin/cart/send_email/<?= $account['Customer']['customer_id'] ?>/<?=$session_id?>">
			<div>
			<label>Supplemental Message</label>
			<textarea name="data[message]" style="width: 50%;" cols=5></textarea>
			</div>
			<input type="image" src="/images/buttons/Send-Email-grey.gif"/>
		</form>
	</td>
</tr>
<? } ?>
<tr>
	<th>Completed Orders:</th>
	<td>
		<? foreach($purchases as $purchase) { ?>
		<div>
			<a href="/admin38/order/vieworders2.php?purchaseID=<?= $purchase['Purchase']['purchase_id'] ?>">Order #<?= $purchase['Purchase']['purchase_id'] ?>: <?= $purchase['Purchase']['Order_Date'] ?>
		</div>
		<? } ?>
	</td>
</tr>
<tr>
	<th>Calculator Requests
	</th>
	<td>
		<a href="/admin/tracking_requests/pricing_calculator/<?= $session_id ?>">Calculator Requests</a>
	</td>
</tr>
<tr>
	<th valign="top">Significant Pages Visited:</th>
	<td>
		<table border=1>
		<? foreach($significant_requests as $request) { ?>
		<tr>
			<td class="bold">
				<?= $request['TrackingRequest']['method'] ?>
				<a href="<?= $request['TrackingRequest']['url']; ?>"><?= $request['TrackingRequest']['url_name'] ?></a>
			</td>
			<td>
				<?= $request['TrackingRequest']['date'] ?>
			</td>
		</tr>
		<? } ?>
		</table>
	</td>
</tr>
<tr>
	<th valign="top">Raw Pages Visited:</th>
	<td>
		<a href="Javascript:void(0)" onClick="$('raw_pages').toggleClassName('hidden');">[+]</a>
		<div class="hidden" id="raw_pages">
		<?= count($requests) ?> total pages visited
		<table border=1>
		<tr>
			<th>
				Page
			</th>
			<th>
				Query String
			</th>
			<th>
				Date
			</th>
		</tr>
		<? foreach($requests as $request) { ?>
		<tr>
			<td>
				<?= $request['TrackingRequest']['url'] ?>
			</td>
			<td>
				<?= $request['TrackingRequest']['query_string'] ?>
			</td>
			<td>
				<?= $request['TrackingRequest']['date'] ?>
			</td>
		</tr>
		<? } ?>
		</table>
		</div>
	</td>
</tr>
</table>

</div>
