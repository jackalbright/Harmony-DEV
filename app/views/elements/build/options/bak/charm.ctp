<?
$defaultCharmID = $currentItem->parts->charmID;
			$default = true;
#print_r($currentItem->parts);

?>
<div class="right">

<div align="right"> <a href="Javascript:void(0);" onClick="updateBuildImage();"><img src="/images/buttons/small/Preview.gif"/> </div>

<a href="/build/option_select/<?= $build['Product']['code'] ?>/charm" rel="shadowbox;width=600;height=400">View All Charms</a>
</div>

<div class="clear">
		<script>
			var charm_images = new Array();
			charm_images[''] = "/charms/no-charm.jpg";
			<? foreach($charms as $charm) { ?>
				charm_images[<?= $charm->charm_id ?>] = '<?= $charm->graphic_location ?>';
			<? } ?>

			function check_tassel()
			{
				var charm = $('option_charm');
				var tassel = $('option_tassel');
				if (charm.value != '' && tassel.value == '-1')
				{
					tassel.value = 41; // Force a tassel if we want a charm!
					tassel.onchange();
					return true;
				}
				return false;
			}
		</script>
		<select id="option_charm" name="data[options][charmID]" onChange="changeOptionPreview('charm', this.value, charm_images); if(!check_tassel()){ update_build_pricing(); updateBuildImage(); } ">
			<option value="">No Charm</option>
		<? $img_charms = $image->listCharms();
			$i = 0;
			$first_charm = null;

			if(!empty($img_charms)) { 
				foreach($img_charms as $charm)
				{
					if($i++ == 0) { $first_charm = "/charms/".$charm->name.".jpg"; }
					?>
						<option value="<?= $charm->id ?>"><?= ucwords($charm->name); ?></option>
					<?
				}
			}
			foreach($charms as $charm)
			{
					if($i++ == 0) { $first_charm = "/charms/".$charm->name.".jpg"; }
					?>
						<option value="<?= $charm->charm_id ?>"><?= ucwords($charm->name); ?></option>
					<?
			}
		?>
		</select>
		<script>
			<? if(!empty($build['options']['charmID'])) { ?>
				$('option_charm').value = '<?= $build['options']['charmID'] ?>'; 
				changeOptionPreview('charm', $('option_charm').value, charm_images);
			<? } ?>
		</script>
		<br/>

		<? if($build['Product']['code'] == 'PW') { ?>
			<p class="note">Please Note: The small ring shown on the charms is removed before placement in your paperweight.</p>
		<? } ?>
</div>
