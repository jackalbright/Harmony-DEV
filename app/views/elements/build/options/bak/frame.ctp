<div align="right" class="right"> <a href="Javascript:void(0);" onClick="updateBuildImage();"><img src="/images/buttons/small/Preview.gif"/> </div>
<?
?>
<div class="clear">
		<script>
			var frame_images = new Array();
			<? foreach($frames as $frame) { ?>
				frame_images[<?= $frame->frame_id ?>] = '<?= $frame->graphic_location ?>';
			<? } ?>
		</script>
		<select id="option_frame" name="data[options][frameID]" onChange="changeOptionPreview('frame', this.value, frame_images); updateBuildImage();">
		<? 
			foreach($frames as $frame)
			{
				if(empty($first_frame)) { $first_frame = $frame->graphic_location; }
				?>
					<option value="<?= $frame->frame_id ?>" ><?= ucwords($frame->name); ?></option>
				<?
			}
		?>
		</select>
		<script>
			<? if(!empty($build['options']['frameID'])) { ?>
				//Event.observe('window', 'load', function (event) { alert("BOR"); $('option_frame').value = '<?= $build['options']['frameID'] ?>'; $('option_frame').onchange(); });
				$('option_frame').value = '<?= $build['options']['frameID'] ?>'; 
				changeOptionPreview('frame', $('option_frame').value, frame_images);
			<? } ?>
		</script>
</div>
