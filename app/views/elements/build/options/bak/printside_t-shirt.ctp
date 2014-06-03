<div align="right" class="right hidden"> <a href="Javascript:void(0);" onClick="updateBuildImage();"><img src="/images/buttons/small/Preview.gif"/> </div>
<?
	if (isset($currentItem->parts->printSide)){
		$printSide = $currentItem->parts->printSide;
	} else {
		$printSide = "";
	};
?>
<div class="clear">
	<!--<h2><?php echo $counter;?>. Choose your T-Shirt Print Side</h2>-->
						<p>
						Select the side where the printing will be shown.
						</p>
						<input id="printside_front" name="data[options][printSide]" type="radio" value="Front" checked='checked'/> Front
						<input id="printside_back" name="data[options][printSide]" type="radio" value="Back"/> Back

		<br/>
		<br/>
		<script>
			<? if(!empty($build['options']['printSide'])) { 
				$id = ($build['options']['printSide'] == 'Back') ? "prinside_back" : "prinside_front";
			?>
				$('<?$id?>').checked = 'checked';
			<? } ?>
		</script>
</div>
