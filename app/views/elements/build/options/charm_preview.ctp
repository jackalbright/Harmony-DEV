<?
$defaultCharmID = $currentItem->parts->charmID;
			$default = true;
#print_r($currentItem->parts);

?>

<div class="clear">
		<? $img_charms = $image->listCharms();
			$i = 0;
			$first_charm = "/charms/no-charm.jpg";


			if(!empty($img_charms)) { 
				foreach($img_charms as $charm)
				{
					#if($i++ == 0) { $first_charm = $charm->graphic_location; }
				}
			}
			foreach($charms as $charm)
			{
					#if($i++ == 0) { $first_charm = $charm->graphic_location; }
			}
		?>

		<div id="">
			<img id="charm_preview" height="50" src="<?= $first_charm ?>"/>
		</div>
		<script>
			<? if(!empty($build['options']['charmID'])) { ?>
				changeOptionPreview('charm', $('option_charm').value, charm_images);
			<? } ?>
		</script>
</div>

