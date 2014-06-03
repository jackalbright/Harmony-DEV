<?= $this->element("admin/tracking_requests/header"); ?>
<div>
<h4>Top Pages:</h4>

<?= $total ?> Requests

	<table border=1>
	<? foreach($top_pages as $record) { ?>
	<tr>
		<td>
			<?= sprintf("%u%%", $record[0]['count'] / $total * 100); ?>
		</td>
		<td>
			<?= $record[0]['count'] ?>
		</td>
		<td>
			<?= $record['tracking_requests']['url'] ?>
			<br/>
			<a href="/admin/tracking_requests/trail?path=<?= $record['tracking_requests']['url'] ?>">View Pages They Viewed</a>
		</td>
	</tr>
	<? } ?>
	</table>
</div>
