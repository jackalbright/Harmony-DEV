<div class="right_align">
<input type="image" name="action" src="/images/buttons/Create-Gifts.gif" value="Create Gifts"/>
<!--<input type="submit" name="action" value="Select Quantity"/>-->
</div>
<div id="build_intro_sidebar">
<?
$minimum = $build['Product']['minimum'];
$quantity = isset($build['quantity']) ? $build['quantity'] : $minimum;
if ($quantity < $minimum) { $quantity = $minimum; }

$base_price = $build['Product']['base_price'];
# XXX ADD OPTIONS...

$subtotal = $base_price * $quantity;

?>

<p>
<div class="aslowas">
	As low as <?= sprintf("$%.02f", $minimum_price); ?> ea.
</div>
<!--<a href="/details/<?= $build['Product']['prod'] ?>.php">Pricing Information</a>-->
<a href="/build/quantity">Pricing Information</a>
</p>

<p class="minimum bold">
	Minimum: <?= $minimum ?>
</p>
<p>
	No setup or design charges.
</p>
<p class="font14">
	Made in USA.
</p>
</div>
