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
			echo $this->element("products/pricing_grid", array('product_pricings'=>$product_pricing,'title'=>$hd->pluralize($product['Product']['short_name']),'wholesale'=>1,'url'=>false));
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

