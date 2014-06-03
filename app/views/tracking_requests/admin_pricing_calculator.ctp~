<div>
<h3>Pricing Calculator Requests</h3>

<p><?= count($requests) ?> searches total, <?= count($calculator_users) ?> users total</p>

	<table border=1>
	<tr>
		<td>#</td>
		<td>User Session</td>
		<td>Last Visited Page</td>
		<td>Product</td>
		<td>Quantity / Minimum</td>
		<td>Options</td>
		<td>Time</td>
	</tr>
	<? foreach($calculator_users as $session_id => $requests) { ?>
	<? $tracking_requests = $user_tracking_requests[$session_id]; ?>
	<tr>
		<td>
			<?= count($requests) ?> requests
		</td>
		<td>
			<a href="/admin/tracking_requests/session/<?= $session_id ?>"><?= $session_id ?></a>
			<br/>(click to view pages they looked at)
		</td>
		<td>
			<?= $tracking_requests[count($tracking_requests)-1]['TrackingRequest']['complete_url'] ?>
		</td>
	</tr>
		<? array_reverse($requests); foreach($requests as $request) { ?>
		<? $product = $products[$request['productCode']]; ?>
		<tr>
			<td>
				&nbsp;
			</td>
			<td>
				&nbsp;
			</td>
			<td>
				&nbsp;
			</td>
			<td>
				<?= $product['name'] ?>
			</td>
			<td style="<? if($request['quantity'] < $product['minimum']) { echo "background-color: red;"; } ?>">
				<?= $request['quantity'] ?> (<?= $product['minimum'] ?> minimum)
			</td>
			<td>
				<?= preg_replace("/&/", "<br/>", $request['options']); ?>
			</td>
			<td>
				<?= $request['date'] ?>
			</td>
		</tr>
		<? } ?>
	<? } ?>
	</table>
</div>
