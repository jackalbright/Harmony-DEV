<div>
	<h2>Searched for: <i><?= $this->data['SearchIndex']['keywords'] ?></i></h2>

	<? if(!empty($this->data)) { ?>
	<?= empty($results) ? 0 : count($results) ?> results.
	<? } ?>

	<? if(!empty($results)) { ?>
	<table width="100%" cellpadding=5 cellspacing=0>
		<? $i = 0; foreach($results as $result) { ?>
		<tr style="background-color: <?= $i++ % 2 == 0 ? "#FFF":"#DDD" ?>;">
			<td valign="top" align="center">
				<? if(!empty($result['SearchIndex']['img'])) { ?>
				<a href="<?= $result['SearchIndex']['url'] ?>">
					<img class="<?= preg_match("/gallery/", $result['SearchIndex']['url']) ? "stamp_thumbnail":"" ?>" src="<?= $result['SearchIndex']['img'] ?>"/>
				</a>
				<? } ?>
			</td>
			<td valign="top">
				<?= $html->link($result['SearchIndex']['name'], $result['SearchIndex']['url'], array('escape'=>false)); ?>
				<?= $result['SearchIndex']['score'] ?>: 
				<div class="indent">
					<?= strlen($result['SearchIndex']['description']) > 300 ? substr($result['SearchIndex']['description'], 0, 300)."..." : $result['SearchIndex']['description'] ?>
				</div>
			</td>
		</tr>
		<? } ?>
	</table>
	<? } ?>
</div>
