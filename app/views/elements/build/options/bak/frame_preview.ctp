<div>
		<? 
			foreach($frames as $frame)
			{
					if(empty($first_frame)) { $first_frame = $frame->graphic_location; }
			}
		?>
	<img id="frame_preview" src="<?= $first_frame ?>"/>
	<script>
			<? if(!empty($build['options']['frameID'])) { ?>
				changeOptionPreview('frame', $('option_frame').value, frame_images);
			<? } ?>
	</script>
</div>

