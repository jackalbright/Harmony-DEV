<div>
<h3>Cart:</h3>

<ul>
	<li>
		<a href="/cart">View Items in Your Cart</a>
	</li>
</ul>
<? if(count($_SESSION['shoppingCart']) > 0) { ?>
<?= $this->element("button", array("url"=>'/checkout', 'label'=>'Checkout')); ?>
<? } ?>

</div>
