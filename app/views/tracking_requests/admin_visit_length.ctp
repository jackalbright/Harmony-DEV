<?= $this->element("admin/tracking_visits/header"); ?>
<div>
<h2>Visit Length Information:</h2>

<?= $total_visits ?> total visits

<table border=1>
<tr>
	<th>%</th>
	<th>#</th>
	<th>Length</th>
	<th>User Sessions</th>
</tr>

<? foreach($visit_length as $length => $count) { ?>
<tr>
	<td>
		<?= sprintf("%u%%", $count / $total_visits * 100); ?>
	</td>
	<td>
		<?= $count ?>
	</td>
	<td>
		<?= $length ?>
	</td>
	<td style="width: 900px;">
		<? foreach($session_ids[$length] as $sessionid) { ?>
			<a href="/admin/tracking_requests/session/<?= $sessionid['tracking_visits']['session_id'] ?>"><?= $sessionid['tracking_visits']['session_id'] ?></a>&nbsp;&nbsp;&nbsp;
		<? } ?>
	</td>
</tr>
<? } ?>
</table>

<script type="text/javascript">
swfobject.embedSWF("/open-flash-chart.swf", "my_chart", "100%", "400", "9.0.0","expressInstall.swf",{"data-file":"/tracking_requests/chart_data/visit_length/<?= date("Y-m-d", strtotime($date_start)-24*60*60*30); ?>/<?= $date_end ?>"});
</script>
<div id="my_chart">Loading...</div>

</div>
