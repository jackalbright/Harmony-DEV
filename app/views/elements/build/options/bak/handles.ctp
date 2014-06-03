<div align="right" class="right"> <a href="Javascript:void(0);" onClick="updateBuildImage();"><img src="/images/buttons/small/Preview.gif"/> </div>
<div class="clear">
	<?
		$handle_images = array(
			"Black"=>'/images/blacktotehandles_verysm.jpg',
			"Navy"=> '/images/navy-blue-tote-handles-small.jpg',
			"Red"=> '/images/red-tote-handles-small.jpg'
		);
	?>
	<script>
		var handle_images = new Array();
		<? foreach($handle_images as $color=>$img) { ?>
			handle_images['<?= $color ?>'] = '<?=$img?>';
		<? } ?>
	</script>
	<select name="data[options][handleColor]" id="option_handles" onChange="changeOptionPreview('handle', this.value, handle_images); updateBuildImage();">
		<? foreach($handle_images as $color=>$img) { ?>
		<option value="<?= $color ?>"><?= ucwords($color); ?></option>
		<? } ?>
	</select>
		<script>
			<? if(!empty($build['options']['handleColor'])) { ?>
				$('option_handles').value = '<?= $build['options']['charmID'] ?>'; 
				changeOptionPreview('handle', $('option_handles').value, handle_images);
			<? } ?>
		</script>
</div>
