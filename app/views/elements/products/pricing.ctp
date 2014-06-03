<table cellpadding=10 width="100%">
<tr>
<td valign="top" style="padding-top: 10px;">
	<?= $this->element("products/pricing_comparison"); ?>
</td>
</tr>
<tr>
<td valign="top">
	<div id="pricing_calculator_holder">
		<?= $this->requestAction("/products/calculator/".$product['Product']['code'], array('return')); ?>
	</div>
</td>
</tr>
</table>
