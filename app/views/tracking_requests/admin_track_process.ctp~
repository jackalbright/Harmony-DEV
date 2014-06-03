<?= $this->element("admin/tracking_requests/header"); ?>
<div>
<h4>Process Tracking:</h4>

<table border=1>
<tr>
	<th>Hits</th>
	<th>Page</th>
	<th>Previous Pages</th>
	<th>Next Pages</th>
	<th>Eventual Milestone Pages</th>
</tr>
	<? foreach($urls as $url) { 
		$record = !empty($pages[$url]) ? $pages[$url] : null;
		$record_count = $record ? $record['count'] : 0;
	?>

	<tr>
		<td>
			<?= $record_count ?>
		</td>
		<td>
			<?= $url ?>
			<br/>
			<a href="/admin/tracking_requests/trail?path=<?= $url ?>">View Pages They Viewed</a>
		</td>
		<? if ($record) { ?>
		<td>
			<table border=1>
			<? arsort($record['prev_pages']); foreach($record['prev_pages'] as $prev_page => $prev_count) { ?>
			<tr>
				<td><?= sprintf("%2u%%", $prev_count / $record['count'] * 100); ?></td>
				<td><?= $prev_count ?></td>
				<td><?= $prev_page ?></td>
			</tr>
			<? } ?>
			</table>
		</td>
		<td>
			<table border=1>
			<? 
				$remainder = $record['count'];
				arsort($record['next_pages']); 
				foreach($record['next_pages'] as $next_page => $next_count) { ?>
			<tr>
				<td><?= sprintf("%u%%", $next_count / $record['count'] * 100); ?></td>
				<td><?= $next_count ?></td>
				<td><?= $next_page ?></td>
			</tr>
			<? 
				$remainder -= $next_count;
			} ?>
			<tr>
				<td>
					<?= sprintf("%u%%", $remainder / $record['count'] * 100); ?>
				</td>
				<td>
					<?= $remainder ?>
				</td>
				<td>
					Bounces (people leaving site)
				</td>
			</tr>
			</table>
		</td>
		<td>
			<table border=1>
			<? $important_remainder = $record['count']; foreach($important_pages as $important_page) { ?>
			<tr>
				<td>
					<? $important_count = !empty($record['important_pages'][$important_page]) ? $record['important_pages'][$important_page] : 0; ?>
					<?= sprintf("%2u%%", $important_count / $record['count'] * 100); ?>
				</td>
				<td>
					<?= $important_count ?>
				</td>
				<td>
					<?= $important_page ?>
				</td>
			</tr>
			<? 
				$important_remainder -= $important_count;
			} ?>
			<tr>
				<td>
					<?= sprintf("%2u%%", $important_remainder / $record['count'] * 100); ?>
				</td>
				<td>
					<?= $important_remainder ?>
				</td>
				<td>
					Critical Bounces (people leaving site)
				</td>
			</tr>
			</table>
		</td>
		<? } ?>
	</tr>
	<? } ?>
</table>
</div>
