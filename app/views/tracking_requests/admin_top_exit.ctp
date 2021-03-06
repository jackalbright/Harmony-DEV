<?= $this->element("admin/tracking_requests/header"); ?>
<div>
<h3>Top Exit pages:</h3>
<p>Total Exits: <?= $total_exits ?> <!--of <?= $total_visits ?> visitors-->
	<table border=1>
	<tr>
		<th>%</th>
		<th>#</th>
		<th>Section</th>
		<th>Page</th>
		<th>&nbsp;</th>
	</tr>
	<? arsort($last_page_section_count); foreach($last_page_section_count as $section => $seccount) { 
		$sectionid = preg_replace("/\//", "_", $section);
	?>
		<tr style="background-color: #C0C0C0;">
			<th>
				<b>
					<?= sprintf("%u%%", $seccount / $total_exits * 100); ?>
				</b>
			</th>
			<th>
				<b>
					<?= $seccount ?>
				</b>
			</th>
			<th>
				<b>
					<a href="Javascript:void(0)" onClick="$('<?= $sectionid ?>').toggleClassName('hidden');">
					<?= $section ?>
					</a>
				</b>
			</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	<tbody id="<?= $sectionid ?>" class="hidden">

	<? $i = 0; arsort($last_page_sections[$section]); foreach($last_page_sections[$section] as $page => $pcount) { 
		$url = "$section$page";
	?>
	<tr class="<?= $i++ % 2 ? "even" : "odd" ?> <?= $sectionid ?>">
		<td align=right>
			<?= sprintf("%u%%", $pcount / $total_exits * 100); ?>
		</td>
		<td align=right>
			<?= $pcount ?>
		</td>
		<td>&nbsp;</td>
		<td align=left>
			<?= $url ?>
			<? if(!empty($last_pages_qs[$url])) { foreach($last_pages_qs[$url] as $qs => $qscount) { if ($qs) { ?>
			<br/>
				<?= $qs ?> (<?= $qscount ?>)
			<? } } } ?>
		</td>
		<td>
			<a href="/admin/tracking_requests/trail?path=<?= $url ?>">Pages Viewed</a>
		</td>
	</tr>
	<? } ?>
	</tbody>
	<? } ?>
	</table>
</div>
