<?
if(!isset($position) || $position != 'top') { $position = 'bottom'; }

?><div style="">
	<table width="100%">
	<tr>
		<td align=center valign=top>
			<h3><?= $hd->pluralize($product['Product']['name'],true); ?>:</h3>
			<a rel="shadowbox" href="/new-images/product-diagrams/<?= $product['Product']['code']?>-large.jpg">
				<img src="/new-images/product-diagrams/<?= $product['Product']['code']?>.jpg"/>
				<br/>+ View Larger</a>
			<br/>
			<? echo $hd->product_element("products/create_button", $product['Product']['prod'], array('product'=>$product['Product'],'no_title'=>1)); ?>
			<? $i = 1; ?>
		</td>


	<?
	$subProducts = $product['RelatedProducts'];
	if(isset($subProducts) && count($subProducts)) {
		foreach($subProducts as $subProduct) {
			if ($i++ % 2 == 0 || $position == 'bottom') { ?> </tr><tr> <? } ?>
			<td align=center valign=top>
				<h3><?= $hd->pluralize($subProduct['name'],true); ?>:</h3>
				<a rel="shadowbox" href="/new-images/product-diagrams/<?= $subProduct['code']?>-large.jpg">
					<img src="/new-images/product-diagrams/<?= $subProduct['code']?>.jpg"/>
					<br/>+ View Larger</a>
				<br/>
				<?  echo $this->element("products/create_button", array('product'=>$subProduct,'no_title'=>1)); ?>
				</td>
			<?
		}
	} ?>
	</tr>
	</table>

</div>

