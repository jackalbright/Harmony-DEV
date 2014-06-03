<? $this->set("page_title", "Product Pricing"); ?>
<? $this->set("enable_tracking", "pricing"); ?>
<div>
<?
$custom_products = array();
$stock_products = array();
foreach($products as $product) { 
	if(!empty($product['Product']['parent_product_type_id'])) { continue; } 
	$code = $product['Product']['code'];
	$name = $hd->pluralize(preg_replace("/^Custom /", "", $product['Product']['short_name']));

	if(!empty($product['Product']['is_stock_item'])) { 
		$stock_products[$code] = $name;
	} else {
		$custom_products[$code] = $name;
	}
}
asort($stock_products);
asort($custom_products);
?>
	<b>See pricing for:</b>
	<select id='prod' name="prod" onChange="trackEvent(event, 'change product TO '+this.options[this.selectedIndex].innerHTML, 'pricing'); if(!this.value) { $$('.product').each(function(d){ d.removeClassName('hidden'); }); } else { $$('.product').each(function(d){ d.addClassName('hidden'); }); $('product_'+this.value).removeClassName('hidden'); }">
		<option value="">All products</option>
		<optgroup label="Custom" style="font-style: normal; font-weight: bold;">
		<? foreach($custom_products as $code=>$name) { ?>
			<option <?= !empty($prod) && $prod == $code ? "selected='selected'":"" ?> value="<?= $code ?>">
				&nbsp;	
				<?= $name; ?>
			</option>
		<? } ?>
		</optgroup>
		<optgroup label="Stock" style="font-style: normal; font-weight: bold;">
		<? foreach($stock_products as $code=>$name) { ?>
			<option <?= !empty($prod) && $prod == $code ? "selected='selected'":"" ?> value="<?= $code ?>">
				&nbsp;	
				<?= $name; ?>
			</option>
		<? } ?>
		</optgroup>
	</select>

<div style="padding-left: 100px;">

	<? foreach($products as $product)
	{
		$code = $product['Product']['code'];
		$product_pricing = $product_pricings[$code];
		if (empty($product['Product']['parent_product_type_id']))
		{
			?>
			<div id="product_<?= $code ?>" class="product <?= !empty($prod) && $prod != $code ? "hidden" : "" ?>" >
			<table>
			<tr>
			<td valign="top">
			<?
			echo $this->element("products/pricing_grid", array('product'=>$product,'product_pricings'=>$product_pricing,'title'=>$hd->pluralize($product['Product']['short_name']),'url'=>"/details/".$product['Product']['prod'].".php"));
			?>
			</td>
			<td valign="top" align="left" style="padding-left: 50px;">
			<!--	<a class="bold" style="color: #555; font-size: 1.2em;" href="/details/<?= $product['Product']['prod'] ?>.php">Order <?= $hd->pluralize($product['Product']['short_name']) ?> &raquo;</a>
			-->
			</td>
			</table>
				<br/>
				<br/>
			</div>
			<?
		}
		?>
		
		<?
	} ?>
</div>

</div>
