<?
	$printSide = !empty($build['options']['printSide']) ? $build['options']['printSide'] : null;
?>
<div class="clear">
	<!--<h2><?php echo $counter;?>. Choose your T-Shirt Print Side</h2>-->
						<p>
						Select the side where the printing will be shown.
						</p>
						<input id="printside_front" name="data[options][printSide]" type="radio" value="Front" checked='checked' onClick="completeBuildStep('<?=$i?>');"/> Front
						<input id="printside_back" name="data[options][printSide]" type="radio" value="Back" onClick="completeBuildStep('<?=$i?>');"/> Back

		<br/>
		<br/>
		<script>
			<? if(!empty($build['options']['printSide'])) { 
				$id = ($build['options']['printSide'] == 'Back') ? "printside_back" : "printside_front";
			?>
				$('<?= $id?>').checked = 'checked';
			<? } ?>
		</script>
</div>
