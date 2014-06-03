<?
$goalstyle = array(
	'upload'=>'1.0',
	'build'=>'1.3',
	'cart'=>'1.8',
	'checkout'=>'2.0',
	'order'=>'3.0',
);
?>
<div>

<h1>Search Traffic Results</h1>

<h3><?= $landing_visit_total ?> total visits</h3>

<a href="Javascript:void(0)" onClick="$$('.failed_search').each(function(s){s.toggleClassName('hidden');});">Hide/Show Failed Searches/Visits</a>

<table width="100%">
<tr>
	<th>Landing Page</th>
	<? $previous_yearweek = null; foreach($yearweeks as $yearweek) { preg_match("/(\d{4})(\d{2})/", $yearweek, $match); $year = $match[1]; $week = $match[2] - 1; ?>
	<th>
		<?= date("m/d", strtotime("$year-01-01 +$week weeks Sunday")); ?>
		- <?= date("m/d", strtotime("$year-01-01 +$week weeks next Saturday")); ?>
		<br/>
		<?= $landing_visit_yearweek[$yearweek] ?> visits
		<? if(!empty($previous_yearweek)) { ?>
			<?  $diff = floor(($landing_visit_yearweek[$yearweek] - $landing_visit_yearweek[$previous_yearweek])/$landing_visit_yearweek[$previous_yearweek]*100); ?>
			<span style="color: <?= $diff < 0 ? "red":"green"; ?>;"><?= sprintf("%+d%%", $diff); ?></span>
		<? } ?>
	</th>
	<? $previous_yearweek = $yearweek; } ?>
</tr>
<tr>
	<th>Top Searches</th>
	<? $previous_yearweek = null; foreach($yearweeks as $yearweek) { preg_match("/(\d{4})(\d{2})/", $yearweek, $match); $year = $match[1]; $week = $match[2] - 1;  ?>
	<td>
		<? 
			$weeksearches = $yearweek_topsearches[$yearweek];
			arsort($weeksearches);
		?>
		<? $i = 0; foreach($weeksearches as $search => $count) { if($i >= 10) { break; } ?>
			<?= $search ?>: <b><?= $count ?></b> (<?= sprintf("%.01f%%", $count / $landing_visit_yearweek[$yearweek] * 100); ?>)<br/>
		<? $i++; } ?>
		<a href="Javascript:void(0)" onClick="$('yearweek_topsearches_<?= $yearweek ?>').toggleClassName('hidden');">View all</a><br/>
		<div id="yearweek_topsearches_<?= $yearweek ?>" class="hidden">
		<? $i = 0; foreach($weeksearches as $search => $count) { if($i++ < 10) { continue; } if ($count <= 2) { break; } if($i > 100) { break; } ?>
			<?= $search ?>: <b><?= $count ?></b> (<?= sprintf("%.01f%%", $count / $landing_visit_yearweek[$yearweek] * 100); ?>)<br/>
		<? } ?>
		</div>
	</td>
	<? $previous_yearweek = $yearweek; } ?>
</tr>
<tr style="background-color: #DDD;">
	<th>Conversions</th>
	<? $previous_conversion = array(); $previous_yearweek = null; foreach($yearweeks as $yearweek) { preg_match("/(\d{4})(\d{2})/", $yearweek, $match); $year = $match[1]; $week = $match[2] - 1; 
		$goals = $yearweek_goals[$yearweek];
	?>
		<td>
				<? foreach($goalorder as $goal) { 
					$goalsessions = !empty($goals[$goal]) ? $goals[$goal] : 0;
					$conversion = count($goalsessions) / $landing_visit_yearweek[$yearweek] * 100;
				?>
				 	<span style=""><?= $goal ?>: <a href="Javascript:void(0)" onClick="$('single_search_<?= $yearweek ?>_<?=$goal ?>').toggleClassName('hidden');"><?= count($goalsessions); ?></a></span>
					(<?= sprintf("%.02f%%", $conversion); ?>) 
					<? if(!empty($previous_conversion[$goal])) { ?>
						<?  $diff = ($conversion - $previous_conversion[$goal]); 
							$font_size = 1.0;
							if(abs($diff) < 1) { $font_size = 0.8; }
							if(abs($diff) > 5) { $font_size = 1.5; }
							if(abs($diff) > 10) { $font_size = 2.0; }
							if(abs($diff) > 20) { $font_size = 3; }
						?>
					<? } else if (!empty($previous_yearweek)) { $diff = 100; } else { $diff = null; } ?>
					<? if(!empty($diff) && abs($diff) > 1) { ?> <span style="font-size: <?= $font_size ?>em; color: <?= $diff < 0 ? "red":"green"; ?>;"><?= sprintf("%+0.1f%%", $diff); ?></span><? } ?>

					<br/>
					<div style="padding-left: 5px;" id="single_search_<?= $yearweek ?>_<?=$goal ?>" class="hidden">
						<? foreach($goalsessions as $goalsess => $bool) { 
							$gotfurther = false; foreach($latergoals[$goal] as $go) { if(!empty($goals[$go][$goalsess])) { $gotfurther = true; break; } };
						?>
						<a style="color: <?= $gotfurther ? "green":"red" ?>;" href="/admin/tracking_requests/session/<?= $goalsess ?>"><?= $goalsess ?></a>
						<? } ?>
					</div>
				<? $previous_conversion[$goal] = $conversion; } ?>
		</td>

	<? $previous_yearweek = $yearweek; } ?>
</tr>
<? $i = 0; foreach($prettyStats as $landingurl=>$stats) { ?>
<tr style="background-color: <?= $i%2 == 0 ? "#FFF" : "#DDD"; ?>; " >
	<td>
		<a href="<?= $landingurl ?>"><?= !empty($page_names[$landingurl]) ? $page_names[$landingurl] : $landingurl ?></a>
	</td>
	<? $previous_percent = null; foreach($yearweeks as $yearweek) { $searches = !empty($stats[$yearweek]) ? $stats[$yearweek] : null; $sumweek = $landing_visit_yearweek[$yearweek]; ?>
	<td width="<?= intval(100/(count($yearweeks)+0.5)) ?>%">
		<? $count = empty($searches) ? 0 : array_sum($searches); ?>
		<? $percent = $count / $sumweek * 100; ?>
		<? if(empty($percent)) { ?>
			&mdash;
		<? } else { ?>
			<!-- way to mark (COLORS) really good keywords from mediocre from worthless ones... -->
			<!-- based on # of words ? 1 = bad, etc... -->

			<b><?= $count ?> (<?= sprintf("%.02f%%", $percent); ?>)</b>

			<? if(!empty($previous_count)) { ?>
				<?  $diff = ($count - $previous_count); 
					$font_size = 1.0;
					if(abs($diff) < 1) { $font_size = 0.8; }
					if(abs($diff) > 10) { $font_size = 1.5; }
					if(abs($diff) > 50) { $font_size = 2.0; }
					if(abs($diff) > 100) { $font_size = 3; }
				?>
				<? if(!empty($diff)) { ?> <span style="font-size: <?= $font_size ?>em; color: <?= $diff < 0 ? "red":"green"; ?>;"><?= sprintf("%+0.1f%%", $diff); ?></span><? } ?>
			<? } ?>
			<br/>
			<br/>

			<div>
				<? 
					arsort($searches); 
					$top_searches = array(); # Anything with more than 1.
					$single_searches = array();
					$failed_single_searches = array();
					foreach($searches as $search => $searchcount)
					{
						$goals = $landing_visits_goals[$landingurl][$yearweek][$search]; 
						if($searchcount > 1) { 
							$top_searches[$search] = $searchcount;
						} else if (empty($goals)) {
							$failed_single_searches[$search] = $searchcount;
						} else {
							$single_searches[$search] = $searchcount;
						}
					}
				?>
				<!-- # TODO analyze words for potential (color and size?) -->
				<? foreach($top_searches as $search => $searchcount) { 
					$goals = $landing_visits_goals[$landingurl][$yearweek][$search]; 
					arsort($goals); 
					$searchsessions = $landing_visits_sessions[$landingurl][$yearweek][$search]; 
				?>
					<div style="" class="<?= empty($goals) ? "failed_search" : "" ?>">
						<?= $search ?>: <a href="Javascript:void(0)" onClick="$('single_search_<?= $landingurl ?>_<?= $yearweek ?>_<?=$search ?>').toggleClassName('hidden');"><?= $searchcount ?></a>
						<div style="padding-left: 30px;" id="single_search_<?= $landingurl ?>_<?= $yearweek ?>_<?=$search ?>" class="hidden">
							<? foreach($searchsessions as $searchsess) { ?>
								<a target="_new" href="/admin/tracking_requests/session/<?= $searchsess ?>"><?= $searchsess ?></a>
							<? } ?>
						</div>
					</div>
					<? if(!empty($goals)) { ?>
					<div style="padding-left: 20px; color: green;">
						<? foreach($goals as $goal => $goalsessions) { ?>
							 <span style="font-size: <?= $goalstyle[$goal] ?>em;"><?= $goal ?>: <a href="Javascript:void(0)" onClick="$('single_search_<?= $landingurl ?>_<?= $yearweek ?>_<?=$search ?>_<?=$goal ?>').toggleClassName('hidden');"><?= count($goalsessions); ?></a></span>
							(<?= sprintf("%.01f%%", count($goalsessions) / count($searchsessions) * 100); ?>)
							<br/>
							<div style="padding-left: 5px;" id="single_search_<?= $landingurl ?>_<?= $yearweek ?>_<?=$search ?>_<?=$goal ?>" class="hidden">
								<? foreach($goalsessions as $goalsess => $bool) { 
									$gotfurther = false; foreach($latergoals[$goal] as $go) { if(!empty($goals[$go][$goalsess])) { $gotfurther = true; break; } };
								?>
								<a target="_new" style="color: <?= $gotfurther ? "green":"red" ?>;" href="/admin/tracking_requests/session/<?= $goalsess ?>"><?= $goalsess ?></a>
								<? } ?>
							</div>
						<? } ?>
					</div>
					<? } ?>
				<? } ?>
				<div id="single_search_<?= $landingurl ?>_<?= $yearweek ?>" class="<?= !empty($top_searches) ? "Xhidden":"" ?>">
					<? foreach($single_searches as $search => $searchcount) { $goals = $landing_visits_goals[$landingurl][$yearweek][$search]; 
						$goals = $landing_visits_goals[$landingurl][$yearweek][$search]; 
						arsort($goals); 
						$searchsessions = $landing_visits_sessions[$landingurl][$yearweek][$search]; 
					
					?>
						<div style="" class="<?= empty($goals) ? "failed_search" : "" ?> single_search <?= empty($goals) ? "hidden":"" ?>">
							<?= $search ?>: <a href="Javascript:void(0)" onClick="$('single_search_<?= $landingurl ?>_<?= $yearweek ?>_<?=$search ?>').toggleClassName('hidden');"><?= $searchcount ?></a>
							<div style="padding-left: 30px;" id="single_search_<?= $landingurl ?>_<?= $yearweek ?>_<?=$search ?>" class="hidden">
								<? foreach($searchsessions as $searchsess) { ?>
									<a href="/admin/tracking_requests/session/<?= $searchsess ?>"><?= $searchsess ?></a>
								<? } ?>
							</div>
						</div>
						<? if(!empty($goals)) { ?>
						<div style="padding-left: 20px; color: green;">
							<? foreach($goals as $goal => $goalsessions) { ?>
							 	<span style="font-size: <?= $goalstyle[$goal] ?>em;"><?= $goal ?>: <a href="Javascript:void(0)" onClick="$('single_search_<?= $landingurl ?>_<?= $yearweek ?>_<?=$search ?>_<?=$goal ?>').toggleClassName('hidden');"><?= count($goalsessions); ?></a></span>
								(<?= sprintf("%.01f%%", count($goalsessions) / count($searchsessions) * 100); ?>)
								<br/>
								<div style="padding-left: 5px;" id="single_search_<?= $landingurl ?>_<?= $yearweek ?>_<?=$search ?>_<?=$goal ?>" class="hidden">
									<? foreach($goalsessions as $goalsess => $bool) { 
										$gotfurther = false; foreach($latergoals[$goal] as $go) { if(!empty($goals[$go][$goalsess])) { $gotfurther = true; break; } };
									?>
									<a target="_new" style="color: <?= $gotfurther ? "green":"red" ?>;" href="/admin/tracking_requests/session/<?= $goalsess ?>"><?= $goalsess ?></a>
									<? } ?>
								</div>
							<? } ?>
						</div>
						<? } ?>
					<? } ?>
				</div>

				<? if((!empty($top_searches) || !empty($single_searches)) && !empty($failed_single_searches)) { ?>
				<br/>
				<a href="Javascript:void(0)" onClick="$('failed_single_search_<?= $landingurl ?>_<?= $yearweek ?>').toggleClassName('hidden');">Show others (<?= count($failed_single_searches) ?>)</a>
				<? } ?>
				<div id="failed_single_search_<?= $landingurl ?>_<?= $yearweek ?>" class="<?= !empty($top_searches) ? "hidden":"" ?>">
					<? foreach($failed_single_searches as $search => $searchcount) { $goals = $landing_visits_goals[$landingurl][$yearweek][$search]; 
						$goals = $landing_visits_goals[$landingurl][$yearweek][$search]; 
						arsort($goals); 
						$searchsessions = $landing_visits_sessions[$landingurl][$yearweek][$search]; 
					
					?>
						<div style="" class="<?= empty($goals) ? "failed_search" : "" ?> failed_single_search">
							<?= $search ?>: <a href="Javascript:void(0)" onClick="$('failed_single_search_<?= $landingurl ?>_<?= $yearweek ?>_<?=$search ?>').toggleClassName('hidden');"><?= $searchcount ?></a>
							<div style="padding-left: 30px;" id="failed_single_search_<?= $landingurl ?>_<?= $yearweek ?>_<?=$search ?>" class="hidden">
								<? foreach($searchsessions as $searchsess) { ?>
									<a href="/admin/tracking_requests/session/<?= $searchsess ?>"><?= $searchsess ?></a>
								<? } ?>
							</div>
						</div>
						<? if(!empty($goals)) { ?>
						<div style="padding-left: 20px; color: green;">
							<? foreach($goals as $goal => $goalsessions) { ?>
							 	<span style="font-size: <?= $goalstyle[$goal] ?>em;"><?= $goal ?>: <a href="Javascript:void(0)" onClick="$('failed_single_search_<?= $landingurl ?>_<?= $yearweek ?>_<?=$search ?>_<?=$goal ?>').toggleClassName('hidden');"><?= count($goalsessions); ?></a></span>
								(<?= sprintf("%.01f%%", count($goalsessions) / count($searchsessions) * 100); ?>)
								<br/>
								<div style="padding-left: 5px;" id="failed_single_search_<?= $landingurl ?>_<?= $yearweek ?>_<?=$search ?>_<?=$goal ?>" class="hidden">
									<? foreach($goalsessions as $goalsess => $bool) { 
										$gotfurther = false; foreach($latergoals[$goal] as $go) { if(!empty($goals[$go][$goalsess])) { $gotfurther = true; break; } };
									?>
									<a target="_new" style="color: <?= $gotfurther ? "green":"red" ?>;" href="/admin/tracking_requests/session/<?= $goalsess ?>"><?= $goalsess ?></a>
									<? } ?>
								</div>
							<? } ?>
						</div>
						<? } ?>
					<? } ?>
				</div>
			</div>
		<? } ?>

	</td>
	<? $previous_count = $count; } ?>
</tr>
<? $i++; } ?>
</table>

<hr/>

</div>
