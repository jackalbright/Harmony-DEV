<div>
	<h2><?= $area['TrackingArea']['name'] ?>:</h2>


	<table border=1>

	<tr>
		<th>Step:</th>
		<th>
			Task:
		</th>
		<th>
			Hits:
		</th>
	</tr>

	<? foreach($area['TrackingTask'] as $task) { 
		$task_id = $task['tracking_task_id'];
	?>
	<tr>
		<td>
			<?= $task['sort_index']+1 ?>
		</td>
		<td>
			<?= $task['name'] ?>
		</td>
		<td>
			<?= count($tracking_entries[$task_id]); ?>
		</td>
	</tr>
	<? } ?>

	<tr>
		<td>&nbsp;
		</td>
		<td>
			<b>Total:</b>
		</td>
		<td>
			<?= $total_entries ?>
		</td>
	</tr>
	</table>
</div>
