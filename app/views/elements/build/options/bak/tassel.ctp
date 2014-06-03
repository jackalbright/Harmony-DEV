<?
			$default = true;
?>

<div class="right">
<div class="" align="right" > <a href="Javascript:void(0);" onClick="updateBuildImage();"><img src="/images/buttons/small/Preview.gif"/> </div>
<a href="/build/option_select/<?= $build['Product']['code'] ?>/tassel" rel="shadowbox;width=600;height=400">View All Tassels</a>
</div>

<div class="clear">
		<script>
			var tassel_images = new Array();
			<?  foreach($tassels as $tassel) { ?>
				tassel_images[<?= $tassel->tassel_id ?>] = '/tassels/thumbs/<?= preg_replace("/ /", "-", $tassel->color_name); ?>.gif';
			<? } ?>

			function check_charm()
			{
				var tassel = $('option_tassel');
				var charm = $('option_charm');
				var tassel_id = tassel.value;
				if (tassel.value == '-1' && charm.value != '')
				{
					// Maybe someday put in inline notification of?
					charm.value = '';
					charm.onchange();
					return true;
				}
				return false;
			}
		</script>
		<select id="option_tassel" name="data[options][tasselID]" onChange="changeOptionPreview('tassel', this.value, tassel_images); if(!check_charm()){ update_build_pricing(); updateBuildImage(); } ">
			<option value="-1">None</option>
			<? $img_tassels = $image->listTassels();
				$i = 0;
				$first_tassel = "black";
				$existing_tassels = array();
				if(!empty($img_tassels))
				{
					foreach($img_tassels as $tassel)
					{
						$existing_tassels[$tassel->id] = true;
						?>
							<option value="<?= $tassel->id ?>" <?= ($first_tassel == $tassel->name && !isset($build['options']['tasselID'])) ? "selected='selected'" : "" ?> ><?= ucwords($tassel->name) ?></option>
						<?
					}

				}
				foreach ($tassels as $tassel)
				{
					if(!empty($existing_tassels[$tassel->tassel_id])) { continue; }
					?>
						<option value="<?= $tassel->tassel_id ?>" <?= ($first_tassel == $tassel->color_name  && !isset($build['options']['tasselID'])) ? "selected='selected'" : "" ?> ><?= ucwords($tassel->color_name) ?></option>
					<?
				}
			?>
		</select>
		<b>(optional)</b>
		<script>
			<? if(!empty($build['options']['tasselID'])) { ?>
				$('option_tassel').value = '<?= $build['options']['tasselID'] ?>'; 
			<? } ?>
		</script>
</div>

<div class="clear"></div>
