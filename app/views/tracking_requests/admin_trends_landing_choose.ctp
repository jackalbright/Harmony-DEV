<div>

	<h3><a href="/gallery">Choose Image Page</a> Effectiveness</h3>
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
			<?= $choose_image_totals[$week] ?> visits<br/>
			Clicks / %
		</th>
		<? } ?>
	</tr>
	<? $i = 0; $choose_image_link_sum = array(); foreach($choose_image_links_count as $link_url => $link_data) { ?>
	<tr style="background-color: <?= $i % 2 == 0 ? "#FFF":"#DDD"; ?>;" >
		<td><a target="_new" href="<?= $link_url ?>"><?= !empty($choose_image_links[$link_url]) ? $choose_image_links[$link_url] : $link_url ?></a></td>
		<? foreach($weeks as $week) { 
			$link_count = $link_data[$week];
		?>
		<td align="center">
			<? if($link_count > 0) { ?>
			<div style="<?= $link_count > 0 ? "font-weight: bold; color: #009900;" : ""; ?>">
			<?= empty($link_count) ? "0" : $link_count ?> (<?= sprintf("%.02f%%", $link_count/$choose_image_totals[$week] * 100); ?>)
			</div>
			<? } else { ?>
				&mdash;
			<? } ?>
		</td>
		<? $choose_image_link_sum[$week] += $link_count; } ?>
	</tr>
	<? $i++; } ?>
	<tr style="color: red; font-weight: bold;">
		<td>Other/Nothing</td>
		<? foreach($weeks as $week) { 
		?>
		<td style="">
			<? if($choose_image_link_sum[$week] > 0) { ?>
			<?= $choose_images_totals[$week] - $choose_image_link_sum[$week] ?> (<?= sprintf("%.02f%%", ($choose_image_totals[$week] - $choose_image_link_sum[$week]) / $choose_image_totals[$week] * 100) ?>)
			<? } else { ?>
				&nbsp;
			<? } ?>
		</td>
		<? } ?>
	</tr>

	</table>

</div>
