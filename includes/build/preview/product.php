<div class="border top_margin">

<table width="100%" class="border_bottom small_bottom_margin"><tr>
<tr>
	<td valign="top">
		<h3 class="">Product:</h3>
	</td>
	<td valign=top align=right>
		<? if (!isset($build['Product'])) { ?>
			[<a href="/products/select?new=1">Select a product</a>]
		<? } else { ?>
			[<a href="/products/select?new=1">Change product</a>]
		<? } ?>
	</td>
</tr>

</table>
<div class="padded">
<? if (!isset($build['Product'])) { ?>
	<br/>
	<b>(No product selected)</b>
	<br/>
	<br/>
<? } else { ?>
	<h4> <?= $build['Product']['name'] ?> </h2>
	<img src="/images/products/diagram/<?= $build['Product']['code'] ?>.jpg">
	<br/>
	<div> <? include(dirname(__FILE__)."/product_pricing.php"); ?> </div>
<? } ?>

</div>


</div>
