<div>
	<h2>Creating Search index</h2>
	<b><?= count($records) ?> records, <?= count($products) ?> products, <?= !empty($stamps) ? count($stamps) : 0 ?> stamps</b>
	<hr/>
	<ol>
	<? foreach($records as $r) { ?>
		<li>
			<?= $r['name'] ?>
		</li>
	<? } ?>
	</ol>

	<hr/>

	<?= $html->link("Run Search", "/search"); ?>
</div>
