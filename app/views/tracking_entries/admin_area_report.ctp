<div>
	<h2><?= $area['TrackingArea']['name'] ?>: <?= $start ?> - <?= $finish ?></h2>


	<table border=1>

	<tr>
		<th>Step:</th>
		<th>
			Task:
		</th>
		<th>
			Total Hits:
		</th>
		<th>
			%
		</th>
	</tr>

	<? $previous_task_id = ""; $previous_task_step = 1; foreach($area['TrackingTask'] as $task) { 
		$task_id = $task['tracking_task_id'];
		$task_step = $task['sort_index'];
	?>
	<tr>
		<td>
			<?= $task_step; ?>
		</td>
		<td>
			<?= $task['name'] ?>
		</td>
		<td>
			<?= !empty($tracking_entries[$task_id]) ? count($tracking_entries[$task_id]) : 0; ?>
		</td>
		<td>
			<? if($previous_task_id) { ?>
			<?= sprintf("%.02f", !empty($tracking_entires[$task_id]) ? count($tracking_entries[$task_id]) / count($tracking_entries[$previous_task_id]) * 100 : 0); ?>
			<? } ?>
		</td>
	</tr>
	<?
		if($previous_task_step != $task_step)
		{
			$previous_task_id = $task_id;
			$previous_task_step = $task_step;
		}
	} ?>

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
