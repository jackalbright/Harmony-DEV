<div style="z-index: 800; padding: 5px;" class="relative">
<!-- zindex in parent of popup below fixes IE layering bug -->
<? if(isset($full_intro)) { ?>
	<?= $product['Product']['main_intro']; ?>
<? } else { 
	$intro_parts = preg_split("/<hr.*>/", $product['Product']['main_intro']);
	$main_intro = $intro_parts[0];
	$main_details = count($intro_parts) > 1 ? $intro_parts[1] : $product['Product']['main_desc']; 
	$main_intro = preg_replace("/<\/p>\s*(<\/p>|<p>&nbsp;<\/p>)*\s*$/", "", $main_intro);
	$main_intro = preg_replace("/\s+$/", "", $main_intro);
?>
	<?= $main_intro; ?><? if(!empty($main_details)) { ?>...
	<div align="right">
		<a href="Javascript:void(0);" id="more_info_more_link" class="" onClick="showPopup('more_info');">Learn more...</a>
		<a href="Javascript:void(0);" id="more_info_less_link" class="hidden" onClick="hidePopup('more_info');">&nbsp;</a>
	</div>
	<? } ?>
<? } ?>

	<div class="clear"></div>

	<div class="hidden" id="more_info" style="height: 450px; overflow: scroll;">
		<a class="block right" href="Javascript:void(0);" onClick="hidePopup('more_info');">Close</a>
		<div class="clear"></div>
		<?= $main_details ?>

		<a class="block right" href="Javascript:void(0);" onClick="hidePopup('more_info');">Close</a>
	</div>

	<? if(empty($in_build)) { ?>
	<? } ?>

	<? if(empty($compare) && empty($product['Product']['is_stock_item'])) { ?>
	<div class="right">
		<a href="#included">Product Details</a> | 
		<a href="#included">Free with your order</a> 
	</div>
	<? } ?>


				

</div>
