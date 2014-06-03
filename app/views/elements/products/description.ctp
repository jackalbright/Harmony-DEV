<? if(!(trim(strip_tags($product["Product"]['description']))) && empty($product['ProductDescription'])) { return; } ?>
<?#= $hd->product_element("products/intro", $product['Product']['prod'],array('no_more'=>1,'compare'=>1,'full_intro'=>1)); ?>
<?#= $this->element("products/details_free"); ?>


<table width="100%" cellpadding=10>
<tr>
<td valign="top" width="50%" style="border-right: solid #CCC 1px;" >
	<?= $product['Product']['description'] ?>

	<? for($i = 0; $i < count($product['ProductDescription']); $i +=2) { $desc = $product["ProductDescription"][$i]; ?>
	<div style="margin-top: 25px;">
		<? if(!empty($desc['title'])) { ?><h4><strong><?= $desc['title'] ?></strong></h4><? } ?>
		<?= $desc['content'] ?>
	</div>
	<? } ?>
</td>
<td valign="top" width="50%">
	<?= $product['Product']['free_with_your_order'] ?>

	<? for($i = 1; $i < count($product['ProductDescription']); $i +=2) { $desc = $product["ProductDescription"][$i]; ?>
	<div style="margin-top: 25px;">
		<? if(!empty($desc['title'])) { ?><h4><strong><?= $desc['title'] ?></strong></h4><? } ?>
		<?= $desc['content'] ?>
	</div>
	<? } ?>
</td>
</tr>
</table>
