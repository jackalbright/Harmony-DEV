<div class="cart">

<? #print_r($cart_items); ?>

<table width="100%" border=0 cellpadding=5>
<tr>
<td width="600" valign=top>
	<form action="/cart/update.php" method="POST">
	<table width="100%" border=1 id="cartDisplay">
	<tr>
		<th>Quantity</th>
		<th>Preview</th>
		<th>Details</th>
		<th>Unit Price</th>
		<th>Total</th>
	</tr>
	<? $i = 0; foreach($shoppingCart as $cartItem) { 
		$quantity = $cartItem['quantity'];
		$unitPrice = $cartItem['unitPrice'];
		$productCode = $cartItem['productCode'];
		$product = $cartItem['Product'];
		$customImage = $cartItem['CustomImage'];
		$galleryImage = $cartItem['GalleryImage'];

		$product = $product_map[$productCode];
	?>
	<tr>
		<td valign=top>
			<input type="text" size=4 name="quantity_<?= $i ?>" value="<?=$quantity?>"/>
			<br/>
			<br/>
			<a href="">Remove</a>
		</td>
		<td valign=top>
			<?= $this->element("build/preview", array('build'=>array('Product'=>$product, 'CustomImage'=>$customImage,'GalleryImage'=>$galleryImage,'grid'=>1))); ?>
		</td>
		<td valign=top>
			<?= $this->element("cart/item_description", array('cart_item'=>$cartItem)); ?>
		</td>
		<td valign=top>
			<?= sprintf("$%.02f", $unitPrice); ?>
		</td>
		<td valign=top>
			<?= sprintf("$%.02f", $unitPrice*$quantity); ?>
		</td>
	</tr>
	<? $i++; } ?>
	</table>
	</form>
</td>
<td valign=top style="background-color: #EEEEEE; border: solid #CCC 1px;">
	<h4>You might also like:</h4>

	<table width="100%" cellpadding="3">
	<?
	$items_per_row = 2;
	$total_items = 8;
	for($i = 0; $i < count($products) && $i < $total_items; $i++)
	{
		if ($i % $items_per_row == 0 && $i > 0) { ?> </tr> <? }
		if ($i % $items_per_row == 0) { ?> <tr> <? }
		?> <td align=center valign="top"> <?
		$product = $products[$i];
		$lastCartItem = $shoppingCart[count($shoppingCart)-1];
		$customImage = $lastCartItem['CustomImage'];
		$galleryImage = $lastCartItem['GalleryImage'];
		$image_name = "Custom";
		$imageID = $customImage ? $customImage['ImageID'] : null;
		$catalog_number = $galleryImage ? $galleryImage['catalog_number'] : null;
		if ($customImage) { $image_name = $customImage['title']; }
		if ($galleryImage) { $image_name = $galleryImage['stamp_name']; }

		?>
			<a href="/build/step?catalogNumber=<?= $catalog_number ?>&imageID=<?= $imageID ?>&prod=<?= $product['Product']['code'] ?>">
		<?

		echo $this->element("build/preview", array('build'=>array('Product'=>$product['Product'], 'CustomImage'=>$customImage,'GalleryImage'=>$galleryImage,'grid'=>1)));
		?>
		</a>
			<a href="/build/step?catalogNumber=<?= $catalog_number ?>&imageID=<?= $imageID ?>&prod=<?= $product['Product']['code'] ?>">"<?= $image_name ?>" <?= $product['Product']['name'] ?></a>
				<? if(count($product['ProductPricing'])) { ?>
				<?
					$minimum_price = $base_price = $product['Product']['base_price'];
					$ix = 0;
					while($product['ProductPricing'][$ix]['price'] > 0 && $ix++ < count($product['ProductPricing'])-1)
					{
						$minimum_price = $base_price * $product['ProductPricing'][$ix]['percent_discount'] / 100;
						#$minimum_price = $product['ProductPricing'][$ix]['price'];
					}
				?>
				<? if($minimum_price > 0) { ?>
				<div class="aslowas">As low as <?= sprintf("$%.02f", $minimum_price) ?> each</a></div>
				<? } ?>
				<? } ?>
			<br/>
		</td> <?
	}
	?>
	<tr>
		<td align="right" colspan="<?= $items_per_row?>" style="font-weight: bold;">
			<? if($customImage) { ?>
				<a href="/custom_images/edit/<?= $customImage['Image_ID'] ?>">View all products...</a>
			<? } else if ($galleryImage) { ?>
				<a href="/gallery/view/<?= $galleryImage['catalog_number'] ?>">View all products...</a>
			<? } ?>
		</td>
	</tr>
	</table>
</td>
</tr>
</table>



</div>

