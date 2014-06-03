<table border=0 align="left">
	<tr>
	<? if($prod == 'CH') { ?>
	<td align='left' class="bold">Select a charm:</td>
	<td align='left'>
	<select id="charmID" name="charmID" onChange="changeShippingLink();">
		<? foreach($charms as $charm) { ?>
			<option <?= !empty($charm_id) && $charm_id == $charm['Charm']['charm_id'] ? "selected='selected'"  : "" ?> value="<?= $charm['Charm']['charm_id']?>"><?= ucwords($charm['Charm']['name']) ?></option>
		<? } ?>
	</select>
	<? if(!empty($charm_id)) { ?>
	<script> $('charmID').value = '<?= $charm_id ?>'; </script>
	<? } ?>
	</td>
	<? } else if($prod == 'TA') { ?>
	<td class="bold" align='left'>Select a color:</td>
	<td align='left'>
	<select id="tasselID" name="tasselID" onChange="changeShippingLink();">
		<? foreach($tassels as $tassel) { ?>
			<option <?= !empty($tassel_id) && $tassel_id == $tassel['Tassel']['tassel_id'] ? "selected='selected'"  : "" ?> value="<?= $tassel['Tassel']['tassel_id']?>"><?= ucwords($tassel['Tassel']['color_name']) ?></option>
		<? } ?>
	</select>
	</td>
	<? } else if (!empty($compare_products) && count($compare_products) > 1) { ?>
	<td colspan=2>
	<? if(!empty($prod)) { ?>
		<input type="hidden" name="productCode" value="<?= $prod ?>"/>
	<? } else { ?>
	<div class="bold">Select a style:</div>
	<table cellpadding=0 cellspacing=0>
	<? $i = 0; foreach($compare_products as $cp) { ?>
	<tr>
		<td valign="top" align="left">
			<label><input id="productCode_<?= $cp['code'] ?>" type="radio" name="productCode" value="<?= $cp['code'] ?>" <?= ((empty($prod) && empty($i)) || $prod == $cp['code']) ? "checked='checked'" : "" ?> onClick="calculateStockSubtotal(this.value); showSampleLarge($('image_gallery_largelink1_products_<?= preg_replace("/[ -]+/", "_", $cp['prod']) ?>_0').href,$('image_gallery_largelink1_products_<?=preg_replace("/[ -]+/", "_", $cp['prod'])?>_0').href); " />
			<?= $cp['pricing_name'] ?>
			</label>
			<br/>
		</td>
	</tr>
	<? $i++; } ?>
	</table>
	<? } ?>
	</td>

	<? } else { ?>
		<input type="hidden" name="prod" value="<?= $product['Product']['code'] ?>"/>
	<? } ?>
	</tr>
	<? if(in_array($product['Product']['code'], array('PWK','DPWK','DPWK-FLC'))) { ?>
	<tr><td colspan=2 valign="top">
		<table border=0 ><tr><td valign="top">
			Qty <input id="quantity_<?= $product["Product"]['code'] ?>" name="quantity" size="3" onchange="changeShippingLink('<?= $product['Product']['code'] ?>'); return (assertMinimum(<?= $product['Product']['minimum'] ?>));// && calculateStockSubtotal('<?= $product['Product']['code']?>','<?= !empty($_REQUEST['cart_item_id']) ? $_REQUEST['cart_item_id'] : null ?>'));" value="<?= !empty($quantity) ? $quantity : $product['Product']['minimum'] ?>" onKeyPress="return disableEnter(event);"/>
			</td><td valign="top">
			x 
		</td><td valign="top">
				<?= sprintf("$%.02f", $unitPrice); ?>
		</td><td valign="top">
			=
		</td><td valign="top">
			<? if(!empty($original_subtotal) && $original_subtotal > $subtotal) { ?>
			<div style="text-decoration: line-through;"><?= sprintf("$%.02f", $original_subtotal); ?></div>
			<? } ?>
			<span style="color: #B82A2A; font-weight: bold;">
			<?= sprintf("$%.02f", $subtotal); ?>
			</span>
		</td></tr>
		</td></tr><tr><td align="left">
			<a id="calc_shipping_<?= $product['Product']['code'] ?>" class='modal' href="/products/calculator/<?= $product['Product']['code'] ?>?quantity=<?= !empty($quantity) ? $quantity : $product['Product']['minimum'] ?>&customized=<?= !empty($customized) ?><?= !empty($charm_id) ? "&charmID=$charm_id" : "" ?><?= !empty($tassel_id) ? "&tasselID=$tassel_id" : "" ?>">Calculate shipping</a>
			</td><td align="right" colspan=4>
			<a href="Javascript:void(0)" onClick="return calculateStockSubtotal('<?= $product['Product']['code']?>','<?= !empty($_REQUEST['cart_item_id']) ? $_REQUEST['cart_item_id'] : null ?>');"><img align="top" src="/images/webButtons2014/grey/small/calculate.png"/></a>
		</td></tr>
		</table>

	</td></tr>
	<? } else { ?>


		<tr>
		<td class="bold" valign="top" align="left" style="padding-right: 20px;">Quantity:</td>
		<td valign="top" align="left">
		<input id="quantity_<?= $product["Product"]['code'] ?>" name="quantity" size="3" onchange="changeShippingLink('<?= $product['Product']['code'] ?>'); return (assertMinimum(<?= $product['Product']['minimum'] ?>));// && calculateStockSubtotal('<?= $product['Product']['code']?>','<?= !empty($_REQUEST['cart_item_id']) ? $_REQUEST['cart_item_id'] : null ?>'));" value="<?= !empty($quantity) ? $quantity : $product['Product']['minimum'] ?>" onKeyPress="return disableEnter(event);"/>
		</td>
		</tr>

		<? if(!empty($unitPrice)) { ?>
		<tr>
		<td class="" align="left">
			<div class='right'> x</div>
			<b>Price ea:</b>
		</td>
		<td valign="middle" align="left" >
			<span style="border-bottom: solid 1px;">
			<? if(!empty($base_price) && $base_price > $unitPrice) { ?>
			<span style="text-decoration: line-through;"><?= sprintf("$%.02f", $base_price); ?></span>
			<? } ?>
			<span style="color: #B82A2A; font-weight: bold;">
			<?= sprintf("$%.02f", $unitPrice); ?>
			</span>
			</span>
		</td>
		</tr>
		<? } ?>


		<? if(!empty($setup)) { ?>
		<tr>
		<td align="left"> <b>Setup:</b> </td>
		<td align="left">
			<?= sprintf("$%.02f", $setup); ?></td>
		</tr>
		<? } ?>
		<? if(!empty($subtotal)) { ?>
		<tr>
		<td align="left" valign="top"> <b>Subtotal:</b> </td>
		<td align="left" valign="top">

			<div class='right'><a href="Javascript:void(0)" onClick="return calculateStockSubtotal('<?= $product['Product']['code']?>','<?= !empty($_REQUEST['cart_item_id']) ? $_REQUEST['cart_item_id'] : null ?>');"><img align="top" src="/images/webButtons2014/grey/small/calculate.png"/></a>
			</div>

			<div style="color: #B82A2A; font-weight: bold;">
				<?= sprintf("$%.02f", $subtotal); ?>
			</div>
			<? if(!empty($original_subtotal) && $original_subtotal > $subtotal) { ?>
			<div style="text-decoration: line-through;"><?= sprintf("$%.02f", $original_subtotal); ?></div>
			<? } ?>
		</td>
		</tr>
		<? } ?>

	<? } ?>

	<? if(!in_array($product['Product']['code'], array('PWK','DPWK','DPWK-FLC')) ||
		!empty($product['Product']['free_shipping'])
	) { ?>
	<tr>
		<td>&nbsp;</td>
		<td colspan=1 align="left">
			<? if(!empty($product['Product']['free_shipping'])) { ?>
			<?=$this->element("shipfree"); ?>
			<? } ?>

			<a id="calc_shipping_<?= $product['Product']['code'] ?>" class='modal' href="/products/calculator/<?= $product['Product']['code'] ?>?quantity=<?= !empty($quantity) ? $quantity : $product['Product']['minimum'] ?>&customized=<?= !empty($customized) ?><?= !empty($charm_id) ? "&charmID=$charm_id" : "" ?><?= !empty($tassel_id) ? "&tasselID=$tassel_id" : "" ?>">Calculate shipping</a>
		</td>
	</tr>
	<? } ?>
	<tr>
		<td>&nbsp;</td>
		<td colspan=1 align="left" class="atc">
			<? if(!empty($_REQUEST['cart_item_id'])) { ?>
				<input type="hidden" name="cart_item_id" value="<?= $_REQUEST['cart_item_id'] ?>"/>

				<input type="image" class="" src="/images/webButtons2014/orange/large/updateCart.png" onClick="j(this).closest('form').attr('action', '/cart/add.php').attr('target', '_self');">
			<? } else { ?>
				<input type="image" class="" src="/images/webButtons2014/orange/large/addToCart.png" onClick="var customized = j('#customized').val(); if(customized == 'logo' && !j('#file').val() && !j('#personalization_logo_id').val()) { alert('Please provide your logo'); return false; } else if (customized == 'personalization' && !j('#personalizationInput').val()) { alert('Please provide your personalization'); return false; }; j(this).closest('form').attr('action', '/cart/add.php').attr('target', '_self');">
			<? } ?>
		</td>
	</tr>
</table>

<div class="clear"></div>
