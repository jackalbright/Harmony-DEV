<div>
	<h1>Performance Trends</h1>

	<?
	$datakeys = array();
	?>

	<table width="100%" border=1>
	<tr>
		<th>&nbsp;</th>
		<? foreach($data['yearweeks'] as $yearweek) { 
			preg_match("/(\d{4})(\d{2})/", $yearweek, $match);
			$year = $match[1]; $week = $match[2];
		
		?>
		<th>
		  <?= date("m/d", strtotime("$year-01-01 +$week weeks Sunday -1 week")); ?>
		                  - <?= date("m/d", strtotime("$year-01-01 +$week weeks next Saturday -1 week")); ?>
		</th>

		<? } ?>
	</tr>
	<? foreach($data as $datakey => $datavals) { if($datakey == 'yearweeks') { continue; } ?>
	<tr>
		<td><?= Inflector::humanize($datakey) ?></td>
		<? foreach($data['yearweeks'] as $yearweek) { ?>
		<td>
			<?= !empty($datavals[$yearweek]) ? $datavals[$yearweek] : '&mdash;'; ?>
		</td>
		<? } ?>
	</tr>
	<? } ?>
	</table>
</div>
