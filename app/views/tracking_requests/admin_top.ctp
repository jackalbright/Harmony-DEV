<?= $this->element("admin/tracking_requests/header"); ?>
<div>
<h4>Summary Report: <?= $report ?></h4>
	<table border=1>
	<? foreach($top_records as $record) { ?>
	<tr>
		<td>
			<?= $record[0]['count'] ?>
		</td>
		<td>
			<?= $record['tracking_requests']['url'] ?>
			<br/>
			<?= $record['tracking_requests']['query_string'] ?>
			<br/>
			<a href="/admin/tracking_requests/trail?path=<?= $record['tracking_requests']['url'] ?>">View Pages They Viewed</a>
		</td>
	</tr>
	<? } ?>
	</table>
</div>
