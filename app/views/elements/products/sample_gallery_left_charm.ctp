<b>Click on a charm to select or to view larger:</b>

<div class="grey_border_top"><span></span></div>
<div class="grey_border_sides" style="height: 450px; overflow-y: scroll; position: relative;">
	<?
			foreach ($charms as $charm) {
					if (isset($charm["Charm"]))
					{
						$charm = $charm['Charm'];
					}
				?>
				<div class="left padded center" style="float: left;">

					<a rel="shadowbox" title="<?= ucwords($charm['name']) ?>" href="/charms/large/<?= basename($charm['graphic_location']); ?>" onClick="selectCharm(this, '<?= $charm['charm_id'] ?>'); return false;"><img id="charm_<?= $charm['charm_id'] ?>" class="charm" border="0" altsrc="<?= $charm['graphic_location'] ?>" id="" height="50"/></a>
					<script>
					Event.observe(window, 'load', function() { $('charm_<?= $charm['charm_id'] ?>').src = '<?= $charm['graphic_location'] ?>'; });
					</script>
					<br/>
					<a rel="shadowbox" title="<?= ucwords($charm['name']) ?>" href="/charms/large/<?= basename($charm['graphic_location']); ?>" onClick="selectCharm(this, '<?= $charm['charm_id'] ?>'); return false;"><?= $charm['name'] ?></a>

				</div>
				<?
			}
		?>
<div class="clear"></div>
</div>
<div class="grey_border_bottom"><span></span></div>

