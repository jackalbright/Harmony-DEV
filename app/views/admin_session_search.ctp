<div>
	From: <b><?= $date_start ?> - <?= $date_end ?></b>
	<form method="POST">
	<input type="text" name="data[TrackingRequest][url]" value="<?= !empty($this->data['TrackingRequest']['url']) ? $this->data['TrackingRequest']['url'] : "" ?>"/>
	<input type="submit" value="Search"/>
	</form>

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
