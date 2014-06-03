<? $found = array(); ?>
<div>
	<h2><?= $part['Part']['part_name'] ?>:</h2>

	<p>
		<?= $part['Part']['part_description'] ?>
	</p>

	<div>

	<? if ($partcode == 'tassel') { ?>
		<? foreach($tassels as $tassel) { ?>
			<div class="left padded" align="center">
				<img height="50" src="/tassels/thumbs/<?= preg_replace("/\s+/", "-", $tassel['Tassel']['color_name']); ?>.gif"><br/>
				<?= ucwords($tassel['Tassel']['color_name']) ?>
			</div>
		<? } ?>
	<? } else if ($partcode == 'charm') { ?>
		<? foreach($charms as $charm) { ?>
			<div class="left padded" align="center">
				<img height="50" src="<?= $charm['Charm']['graphic_location'] ?>"><br/>
				<?= ucwords($charm['Charm']['name']) ?>
			</div>
		<? } ?>
	<? } else if ($partcode == 'border') { ?>
		<? foreach($borders as $border) { ?>
			<div class="left padded" align="center">
				<img src="<?= $border['Border']['location'] ?>"><br/>
				<?= ucwords($border['Border']['name']) ?>
			</div>
		<? } ?>
	<? } else if ($partcode == 'ribbon') { ?>
		<? foreach($ribbons as $ribbon) { ?>
			<div class="left padded" align="center">
				<img height="50" src="/ribbons/<?= preg_replace("/\s+/", "-", $ribbon['Ribbon']['color_name']); ?>.png"><br/>
				<?= ucwords($ribbon['Ribbon']['color_name']) ?>
			</div>
		<? } ?>
	<? } ?>

	</div>
	<div class="clear"></div>

</div>
