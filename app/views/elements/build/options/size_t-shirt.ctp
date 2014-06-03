<div class="clear">
		<select id="option_shirt_size" name="data[options][shirtSize]" onChange="completeBuildStep('<?=$i?>');">
			<option value="S">Adult Small</option>
			<option value="M">Adult Medium</option>
			<option value="L" selected="selected">Adult Large</option>
			<option value="XL">Adult X-Large</option>
			<option value="XXL">Adult XX-Large</option>
			<option value="YS">Youth Small</option>
			<option value="YM">Youth Medium</option>
			<option value="YL">Youth Large</option>
			<option value="YXL">Youth X-Large</option>
		</select>

		<script>
			<? if(!empty($build['options']['shirtSize'])) { ?>
				$('option_shirt_size').value = '<?= $build['options']['shirtSize'] ?>'; 
			<? } ?>
		</script>
</div>

