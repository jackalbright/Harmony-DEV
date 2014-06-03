<div class="clear">
	<?
		$pinstyles = array(
			'Bar'=>"/new-images/pinback.jpg",
			"Tie Tack"=>"/new-images/tietacback.jpg",
		);

	?>
	<script>
		var pinstyles = new Array();
		<? foreach($pinstyles as $style=>$img) { ?>
			pinstyles['<?=$style?>'] = '<?=$img?>';
		<? } ?>
	</script>
	<select id="option_pinback" name="data[options][pinStyle]" onChange="updateBuild('<?=$i?>');" onChangeX="changeOptionPreview('pinback', this.value, pinstyles);">
		<? foreach($pinstyles as $style=>$img) { ?>
			<option value="<?= $style ?>"><?= ucwords($style) ?></option>
		<? } ?>
	</select>
		<script>
			<? if(!empty($build['options']['pinStyle'])) { ?>
				$('option_pinback').value = '<?= $build['options']['pinStyle'] ?>'; 
				changeOptionPreview('pinback', $('option_pinback').value, pinstyles);
			<? } ?>
		</script>
</div>
