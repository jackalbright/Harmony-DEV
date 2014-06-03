<? $option_code = 'cart'; ?>
<div id="step_<?= $option_code ?>" class="step <?= $step == $option_code ? "selected_step" : "" ?> ">
	<table id="header_part_settings_<?= $option_code ?>" width="100%" class="step_header">
	<tr>
		<th align="left">
			<a class="bold" href="Javascript:void(0)" onClick="showBuildStep('<?=$option_code?>');">STEP <span class='stepnum'><?= $i+1 ?></span>. Review &amp; Add to Cart</a>
		</th>
		<td align="right">
		</td>
	</tr>
	</table>

	<div id="step_cart" style="">
		<div id="review_container">
		<?= $this->element("build/cart"); ?>
		</div>
	</div>
</div>
