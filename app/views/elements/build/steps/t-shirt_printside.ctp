<?
	if (isset($currentItem->parts->printSide)){
		$printSide = $currentItem->parts->printSide;
	} else {
		$printSide = "";
	};
?>
<div class="clear">
	<h2><?php echo ++$counter;?>. Choose your T-Shirt Print Side</h2>
						<p>
						Select the side where the printing will be shown.
						</p>
						<blockquote>
						<input name="printSide" type="radio" value="Front" <?php if ($printSide=="Front" || $printSide==""){ echo "checked";}; ?> />Front<br />
						<input name="printSide" type="radio" value="Back" <?php if ($printSide=="Back"){ echo "checked";}; ?> />Back
						</blockquote>
</div>
