<? 
$first_border = "/borders/Double Line.gif";
?>
<div>
	<img id="border_preview" src="<?= $first_border ?>"/>
	<script>
			<? if(!empty($build['options']['borderID'])) { ?>
				changeOptionPreview('border', $('option_border').value, border_images);
			<? } ?>
	</script>
</div>

