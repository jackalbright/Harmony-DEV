<table width="100%">
<tr>
<td width="50%" valign="top">

				<table>
					<?= $this->element("cart/shipping_select",array('checkout'=>1)); ?>
				</table>

</td>
<td valign="top">
	<div style="padding-left: 125px;">
	<?= $this->element("checkout/order_summary"); ?>
	</div>
</td>
</tr>
</table>

