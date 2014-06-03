<div id="charm_list">

<p>
Select a category from the list to look at related charms. Then click on a charm and click 'Buy Now' to add to cart.
</p>

<? foreach($charm_categories as $cat) { ?>
<div class="charm_category_header">
	<a href="#" onClick="displayCharmCategory('<?= $cat['CharmCategory']['charm_category_id'] ?>');">
		<?= $cat['CharmCategory']['category_name'] ?>
	</a>
</div>
<div id="charm_category_<?= $cat['CharmCategory']['charm_category_id'] ?>" class="charm_category hidden">
<? if (count($cat['Charm'])) { ?>
	<? foreach($cat['Charm'] as $charm) { ?>
		<div id='charm_<?= $charm['charm_id'] ?>' class="charm" onClick="selectCharm(this, '<?= $charm['charm_id'] ?>', '<?= $charm['name'] ?>', '<?= $charm['graphic_location'] ?>');">
		<img src="<?= $charm['graphic_location'] ?>">
		<br/>
		<?= $charm['name'] ?>
		</div>
	<? } ?>
	<div class="clear"></div>
<? } else { ?>
	No charms available.
<? } ?>
</div>
<div class="clear"></div>

<? } ?>

<div class="charm_category_header">
	<a href="#" onClick="displayCharmCategory('other');">
		Other
	</a>
</div>

<div id="charm_category_other" class="charm_category hidden">
<? if (count($other_charms)) { ?>
	<? foreach($other_charms as $charm) { ?>
		<div id='charm_<?= $charm['Charm']['charm_id'] ?>' class="charm" onClick="selectCharm(this, '<?= $charm['Charm']['charm_id'] ?>', '<?= $charm['Charm']['name'] ?>', '<?= $charm['Charm']['graphic_location'] ?>');">
		<img src="<?= $charm['Charm']['graphic_location'] ?>">
		<br/>
		<?= $charm['Charm']['name'] ?>
		</div>
	<? } ?>
<? } else { ?>
	No charms available.
<? } ?>

<div class="clear"></div>
</div>

<div class="clear"></div>

</div>
