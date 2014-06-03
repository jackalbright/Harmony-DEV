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
	<select name="data[options][handles]" id="option_handles" onChange="changeHandles(this.value);" onChangeX="changeOptionPreview('handle', this.value, handle_images); updateBuildImage();">
		<? foreach($handle_images as $color=>$img) { ?>
		<option value="<?= $color ?>"><?= ucwords($color); ?></option>
		<? } ?>
	</select>
		<script>
			function changeHandles(handle)
			{
				setPart('handles', "/images/products/blanks/handles/medium/"+handle.toLowerCase()+".gif");
			}

			changeHandles('<?= !empty($build['options']['handles']) ? $build['options']['handles'] : 'black' ?>');
		</script>
</div>
