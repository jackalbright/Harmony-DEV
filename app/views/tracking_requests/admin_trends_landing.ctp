<div>
	<?
		$minweek = min($weeks);
		$maxweek = max($weeks);
		preg_match("/(\d{4})(\d{2})/", $minweek, $minmatches);
		$min_weekyear = $minmatches[1]; $min_weekweek = $minmatches[2];

		preg_match("/(\d{4})(\d{2})/", $maxweek, $maxmatches);
		$max_weekyear = $maxmatches[1]; $max_weekweek = $maxmatches[2];

		$start_date = date("m/d/y", strtotime("$min_weekyear-01-01")+($min_weekweek-1)*7*24*60*60 + 24*60*60);
		$end_date = date("m/d/y", strtotime("$max_weekyear-01-01")+($max_weekweek-1)*7*24*60*60 + 24*60*60);
	?>
	<h2><?= $start_date ?> - <?= $end_date ?>: <?= $grand_total ?> visits </h2>


	<h3>Landing Pages</h3>
	<table>
	<tr>
		<th>Week:</th>
		<? foreach($weeks as $week) { 
			preg_match("/(\d{4})(\d{2})/", $week, $matches);
			$weekyear = $matches[1]; $weekweek = $matches[2];
			$weekname_start = date("m/d/y", strtotime("$weekyear-01-01")+($weekweek-1)*7*24*60*60 + 24*60*60);
			$weekname_end = date("m/d/y", strtotime("$weekyear-01-01")+($weekweek-1)*7*24*60*60 + 6*24*60*60 + 24*60*60);
		?>
		<th ><?= $weekname_start ?> - <?= $weekname_end ?></th>
		<? } ?>
	</tr>
	<tr>
		<th></th>
		<? foreach($weeks as $week) { ?>
		<th>Visits/%, Success %</th>
		<? } ?>
	</tr>
	<tr>
		<th>Landing Page Visit Totals</th>
		<? foreach($weeks as $week) { ?>
		<th><?= $total_weeks[$week] ?></th>
		<? } ?>
	</tr>
	<? $i = 0; foreach($landing_pages as $url => $page_weeks) { 
	?>
	<tr style="background-color: <?= $i % 2 == 0 ? "#FFF":"#DDD"; ?>;" >
		<td>
			<a target="_new" href="<?= $url ?>"><?= $url ?></a>
		</td>
		<? foreach($weeks as $week) { 
			$count = !empty($page_weeks[$week]) ? $page_weeks[$week] : 0; 
			$success_count = $landing_successes[$url][$week];
		?>
		<td align="center">
			<? if($count > 0) { ?>
			<?= $count ?>
			(<?= sprintf("%.02f%%", $count / $total_weeks[$week] * 100); ?>)
			<div style="<?= $success_count > 0 ? "font-weight: bold; color: #009900;" : ""; ?>">(<?= empty($success_count) ? "0" : $success_count ?> @ <?= sprintf("%.02f%%", $success_count / $count * 100); ?>)</div>
			<? } else { ?>
				&mdash;
			<? } ?>
		</td>
		<? } ?>
	</tr>
	<? $i++; } ?>
	</table>

</div>
