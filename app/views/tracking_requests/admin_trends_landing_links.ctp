<div>

	<h3>Custom Product Landing Page Link Effectiveness</h3>
	<table>
	<tr>
		<th>Link</th>
		<? foreach($weeks as $week) { 
			preg_match("/(\d{4})(\d{2})/", $week, $matches);
			$weekyear = $matches[1]; $weekweek = $matches[2];
			$weekname_start = date("m/d/y", strtotime("$weekyear-01-01")+($weekweek-1)*7*24*60*60 + 24*60*60);
			$weekname_end = date("m/d/y", strtotime("$weekyear-01-01")+($weekweek-1)*7*24*60*60 + 6*24*60*60 + 24*60*60);
		?>
		<th >
			<?= $weekname_start ?> - <?= $weekname_end ?><br/>
			<?= $landing_totals[$week] ?> visits<br/>
			Clicks / %
		</th>
		<? } ?>
	</tr>
	<? $i = 0; $link_sum = array(); foreach($links_count as $link_url => $link_data) { ?>
	<tr style="background-color: <?= $i % 2 == 0 ? "#FFF":"#DDD"; ?>;" >
		<td><a target="_new" href="<?= $link_url ?>"><?= !empty($landing_links[$link_url]) ? $landing_links[$link_url] : $link_url ?></a></td>
		<? foreach($weeks as $week) { 
			$link_count = $link_data[$week];
		?>
		<td align="center">
			<? if($link_count > 0) { ?>
			<div style="<?= $link_count > 0 ? "font-weight: bold; color: #009900;" : ""; ?>">
			<?= empty($link_count) ? "0" : $link_count ?> (<?= sprintf("%.02f%%", $link_count/$landing_totals[$week] * 100); ?>)
			</div>
			<? } else { ?>
				&mdash;
			<? } ?>
		</td>
		<? $link_sum[$week] += $link_count; } ?>
	</tr>
	<? $i++; } ?>
	<tr style="color: red; font-weight: bold;">
		<td>Other/Nothing</td>
		<? foreach($weeks as $week) { 
		?>
		<td style="">
			<? if($link_sum[$week] > 0) { ?>
			<?= $landing_totals[$week] - $link_sum[$week] ?> (<?= sprintf("%.02f%%", ($landing_totals[$week]-$link_sum[$week]) / $landing_totals[$week] * 100) ?>)
			<? } else { ?>
				&nbsp;
			<? } ?>
		</td>
		<? } ?>
	</tr>

	</table>

	<h3>Stock Item Landing Page Link Effectiveness</h3>
	<table>
	<tr>
		<th>Link</th>
		<? foreach($weeks as $week) { 
			preg_match("/(\d{4})(\d{2})/", $week, $matches);
			$weekyear = $matches[1]; $weekweek = $matches[2];
			$weekname_start = date("m/d/y", strtotime("$weekyear-01-01")+($weekweek-1)*7*24*60*60 + 24*60*60);
			$weekname_end = date("m/d/y", strtotime("$weekyear-01-01")+($weekweek-1)*7*24*60*60 + 6*24*60*60 + 24*60*60);
		?>
		<th >
			<?= $weekname_start ?> - <?= $weekname_end ?><br/>
			<?= $stock_landing_totals[$week] ?> visits<br/>
			Clicks / %
		</th>
		<? } ?>
	</tr>
	<? $i = 0; $stock_link_sum = array(); foreach($stock_links_count as $link_url => $link_data) { ?>
	<tr style="background-color: <?= $i % 2 == 0 ? "#FFF":"#DDD"; ?>;" >
		<td><a target="_new" href="<?= $link_url ?>"><?= !empty($landing_links[$link_url]) ? $landing_links[$link_url] : $link_url ?></a></td>
		<? foreach($weeks as $week) { 
			$link_count = $link_data[$week];
		?>
		<td align="center">
			<? if($link_count > 0) { ?>
			<div style="<?= $link_count > 0 ? "font-weight: bold; color: #009900;" : ""; ?>">
			<?= empty($link_count) ? "0" : $link_count ?> (<?= sprintf("%.02f%%", $link_count/$stock_landing_totals[$week] * 100); ?>)
			</div>
			<? } else { ?>
				&mdash;
			<? } ?>
		</td>
		<? $stock_link_sum[$week] += $link_count; } ?>
	</tr>
	<? $i++; } ?>
	<tr style="color: red; font-weight: bold;">
		<td>Other/Nothing</td>
		<? foreach($weeks as $week) { 
		?>
		<td style="">
			<? if($stock_link_sum[$week] > 0) { ?>
			<?= $stock_landing_totals[$week] - $stock_link_sum[$week] ?> (<?= sprintf("%.02f%%", ($stock_landing_totals[$week] - $stock_link_sum[$week]) / $stock_landing_totals[$week] * 100) ?>)
			<? } else { ?>
				&nbsp;
			<? } ?>
		</td>
		<? } ?>
	</tr>

	</table>


</div>
