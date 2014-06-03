<?= $this->element("admin/tracking_requests/header"); ?>
<div>
<h2>Landing Page Information:</h2>

<!--
 # x% come from site A, y% from site B, z% directly.
                 # x% search for keyword A, y% keyword B, z% no keywords ...
		                 # x% go to landing page section A, y% to section B, ...
-->

<?= $total ?> total visits

<h3>Where People Come From (Referer):</h3>
<? arsort($sources); ?>
<table border=1>
<tr>
	<th>%</th>
	<th>#</th>
	<th>Source</th>
</tr>
<? $i = 0; foreach($sources as $refname => $refcount) { ?>
<tr class="<?= $i++ % 2 ? "even" : "odd" ?>">
	<td><?= sprintf("%u%%", $refcount / $total * 100); ?></td>
	<td><?= $refcount ?></td>
	<td>
		<a href="<?=$refname?>"><?= $refname ?></a>
	</td>
</tr>
<? } ?>
</table>

<h3>Search Phrases</h3>
<? arsort($phrases); ?>
<table border=1>
<tr>
	<th>%</th>
	<th>#</th>
	<th>Search Phrase</th>
</tr>
<? $i = 0; foreach($phrases as $keyword => $kwcount) { ?>
<tr class="<?= $i++ % 2 ? "even" : "odd" ?>">
	<td><?= sprintf("%u%%", $kwcount / $total * 100); ?></td>
	<td><?= $kwcount ?></td>
	<td><?= $keyword ?></td>
</tr>
<? } ?>
</table>

<h3>Landing Pages</h3>
<? arsort($pages) ?>
<table border=1>
<tr>
	<th>%</th>
	<th>#</th>
	<th>Page</th>
</tr>
	<? $i = 0; foreach($pages as $page => $seccount) { ?>
	<tr class="<?= $i++ % 2 ? "even" : "odd" ?>">
		<td>
			<b><?= sprintf("%u%%", $seccount / $total * 100); ?></b>
		</td>
		<td>
			<b><?= $seccount ?></b>
		</td>
		<td>
			<b>
			<a href="/admin/tracking_requests/trail?path_prefix=<?=$page?>&landing=1">
			<?= $page ?>
			</a>
			</b>
		</td>
	</tr>
	<? } ?>

</table>

</div>
