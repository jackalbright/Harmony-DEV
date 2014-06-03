<div>

<h3><?= $clickSumTotal ?> total clicks, <?= $visitor_total ?> total visitors</h3>

<table width="65%">
<tr>
	<th>Link name/image</th>
	<? $previous_yearweek = null; foreach($yearweeks as $yearweek) { preg_match("/(\d{4})(\d{2})/", $yearweek, $match); $year = $match[1]; $week = $match[2] - 1; ?>
	<th>
		<?= date("m/d", strtotime("$year-01-01 +$week weeks Sunday")); ?>
		- <?= date("m/d", strtotime("$year-01-01 +$week weeks next Saturday")); ?>
		<br/>
		<?= $clickSumWeeks[$yearweek] ?> clicks<br/>
	</th>
	<? $previous_yearweek = $yearweek; } ?>
</tr>
<tr>
	<th>Visitors</th>
	<? $previous_yearweek = null; foreach($yearweeks as $yearweek) { preg_match("/(\d{4})(\d{2})/", $yearweek, $match); $year = $match[1]; $week = $match[2] - 1; ?>
	<th>
		<?= $visitors[$yearweek] ?> visitors<br/>
		<? if(!empty($previous_yearweek)) { ?>
			<?  $diff = floor(($visitors[$yearweek] - $visitors[$previous_yearweek])/$visitors[$previous_yearweek]*100); ?>
			<span style="color: <?= $diff < 0 ? "red":"green"; ?>;"><?= sprintf("%+d%%", $diff); ?></span>
		<? } ?>
	</th>
	<? $previous_yearweek = $yearweek; } ?>
</tr>
<? $i = 0; foreach($prettyStats as $name=>$stats) { ?>
<tr style="background-color: <?= $i%2 == 0 ? "#FFF" : "#DDD"; ?>; " >
	<td>
		<?
			$name = $url = null;
			# Get the first proper name/url combo.
			foreach($yearweeks as $yw)
			{
				if(!empty($stats[$yw]['TrackingLink']))
				{
					$name = $stats[$yw]['TrackingLink']['name'];
					$url = $stats[$yw]['TrackingLink']['url'];
					break;
				}
			}
		?>
		<a href="<?= $url ?>"><?= $name ?></a>
		<? if(preg_match("/custom_images/", $url)) { ?>
			<a href="/admin/custom_images">View Uploaded Images</a>
		<? } ?>
	</td>
	<? $previous_percent = null; foreach($yearweeks as $yearweek) { $stat = $stats[$yearweek]; $clickSumWeek = $clickSumWeeks[$yearweek]; ?>
	<td>
		<? $percent = $stat[0]['count'] / $clickSumWeek * 100; ?>
		<? if(empty($percent)) { ?>
			&mdash;
		<? } else { ?>
			<?= $stat[0]['count'] ?> (<?= sprintf("%.02f%%", $percent); ?>)
			<? if(!empty($previous_percent)) { ?>
				<?  $diff = ($percent - $previous_percent); 
					$font_size = 1.0;
					if(abs($diff) < 1) { $font_size = 0.8; }
					if(abs($diff) > 1) { $font_size = 1.5; }
					if(abs($diff) > 5) { $font_size = 2.0; }
					if(abs($diff) > 10) { $font_size = 3; }
				?>
				<? if(!empty($diff)) { ?> <span style="font-size: <?= $font_size ?>em; color: <?= $diff < 0 ? "red":"green"; ?>;"><?= sprintf("%+0.1f%%", $diff); ?></span><? } ?>

			<? } ?>
		<? } ?>

		<? if(!empty($stat[0]['productCode'])) { ?>
		<br/>
		<a href="Javascript:void(0)" onClick="$('prod_<?= $i ?>_<?= $yearweek ?>').toggleClassName('hidden');">Show Products</a>
		<div id="prod_<?= $i ?>_<?= $yearweek ?>" class="hidden">
			<? arsort($stat[0]['productCode']); foreach($stat[0]['productCode'] as $code => $num) { if(empty($code)) { continue; } ?>
			<?= $code ?>: <?= $num ?><br/>
			<? } ?>
		</div>
		
		<? } ?>

		<? if(!empty($stat[0]['images'])) { ?>
		<br/>
		<a href="Javascript:void(0)" onClick="$('images_<?= $i ?>').toggleClassName('hidden');">Toggle Images</a>
		<div id="images_<?= $i ?>" class="hidden">
			<? asort($stat[0]['images']); ?>
			<? $stat[0]['images'] = array_reverse($stat[0]['images']); ?>
			<? foreach($stat[0]['images'] as $img => $imgcount) { ?>
			<div class="" align="center" style="padding: 5px; border: solid #CCC 1px; margin: 5px;">
				<?= $img ?>
				<br/>
				<?= $imgcount ?>
			</div>
			<? } ?>
		</div>
		<? } ?>
	</td>
	<? $previous_percent = $percent; } ?>
</tr>
<? $i++; } ?>
</table>

<hr/>

</div>