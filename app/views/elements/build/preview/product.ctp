<div class="border top_margin">

<table width="100%" class="border_bottom small_bottom_margin"><tr>
<tr>
	<td valign="top">
		<h3 class="">Product:</h3>
	</td>
	<td valign=top align=right>
		<? if (!isset($build['Product'])) { ?>
			<a href="/products/select">All Products</a>
		<? } else { ?>
			[<a href="/products/select">Change product</a>]
		<? } ?>
	</td>
</tr></table>
<div class="padded">
<? if (!isset($build['Product'])) { ?>
	<br/>
	<b>(No product selected)</b>
	<br/>
	<br/>
<? } else { ?>
	<h4> <?= $build['Product']['name'] ?> </h2>
	<img src="/new-images/product-diagrams/<?= $build['Product']['code'] ?>.jpg">
	<br/>
<? } ?>

</div>

</div>
