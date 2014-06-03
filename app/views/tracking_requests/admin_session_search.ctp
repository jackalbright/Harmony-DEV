<div>
	From: <b><?= $date_start ?> - <?= $date_end ?></b>
	<form method="POST">
	<select id="select_url" name="data[TrackingRequest][select_url]">
		<option value="">[Common Pages]</option>
		<? foreach($products as $p) { ?>
			<option value="/details/<?= $p['Product']['prod'] ?>.php"><?= $p['Product']['name'] ?> Landing Page</option>
		<? } ?>
		<option value="/build/customize/%">Build Page</option>
		<option value="/cart/add%">Add To Cart</option>
		<option value="/checkout%">Checkout</option>
	</select> OR
	<input type="text" name="data[TrackingRequest][url]" value="<?= !empty($this->data['TrackingRequest']['url']) ? $this->data['TrackingRequest']['url'] : "" ?>"/>
	<input type="submit" value="Search"/>
	</form>
	<script>
		<? if(!empty($this->data['TrackingRequest']['select_url'])) { ?>
		$('select_url').value = '<?= $this->data['TrackingRequest']['select_url'] ?>';
		<? } ?>
	</script>

	<? if(!empty($requests)) { ?>
	<?= count($requests) ?> requests
	<table>
		<tr>
			<td>Session ID</td>
			<td>Date/Time</td>
		</tr>
		<? foreach($requests as $req) { ?>
		<tr>
			<td>
				<a href="/admin/tracking_requests/session/<?= $req['TrackingRequest']['session_id'] ?>"><?= $req['TrackingRequest']['session_id'] ?></a>
			</td>
			<td>
				<?= $req['TrackingRequest']['date'] ?>
			</td>
		</tr>
		<? } ?>
	</table>
	<? } ?>
</div>
