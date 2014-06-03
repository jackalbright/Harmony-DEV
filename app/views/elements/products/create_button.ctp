<? if($product['is_stock_item']) { ?>
<? if (!isset($no_title)) { ?>
<h3><?= $hd->pluralize($product['name'],true) ?></h3>
<? } ?>
<form action="/cart/add.php" method="POST">
	<br/>
	<input type="hidden" value="<?= $product['code'] ?>" name="productCode"/>
	Quantity:
	<input type="text" size="3" value="1" name="quantity"/>
	<br/>
	<br/>
	<input class="next_step" type="submit" value="Buy Now >" name="action"/>
	<br/>
	<br/>
</form>
<? } else { ?>
<form action="/products/select/<?= $product['code'] ?>" method="get">
		<input id="next_step_primary" class="next_step" type="submit" value="Create <?= $hd->pluralize($product['name'],true) ?> >"/>
		<? if (isset($list_link)) { ?>
		<br/>
		[<a href="/products/select?new=1">Or select a different product</a>]
		<br/>
		<br/>
		<? } ?>
	</form>
<? } ?>
