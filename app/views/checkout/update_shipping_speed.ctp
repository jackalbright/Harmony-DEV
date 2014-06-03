<table width="100%">
<tr>
<td width="50%" valign="top">

				<table width="100%">
					<?= $this->element("cart/shipping_select",array('checkout'=>1)); ?>
				</table>

</td>
<td valign="top">
	<div style="float: right;" id="order_summary">
	<?= $this->element("checkout/order_summary"); ?>
	</div>
	<? $free_shipping_items = Set::extract("/Product[free_shipping=1]", $shoppingCart); ?>
	<? $paid_shipping_items = Set::extract("/Product[free_shipping=0]", $shoppingCart); ?>

	<? if(empty($customer['is_wholesale']) && !empty($free_shipping_items) && !empty($config['free_ground_shipping_minimum']) && $subtotal > $config['free_ground_shipping_minimum']) { ?>
	<div class="clear"></div>
	<div align="right" class="right" style="margin-top: 5px; color: #0369A7;">
		<? if(empty($paid_shipping_items)) { ?>
			Your items qualify<br/>for free shipping
		<? } else { ?>
			Some of your items<br/>qualify for free shipping
		<? } ?>
	</div>
	<? } ?>
	<div class="clear"></div>

	<? #if(!$this->Session->read("coupon")) { ?>
	<div class='right'>
		<? if(!empty($invalid_coupon)) { ?>
		<div class='error'><?= $invalid_coupon !== true ? $invalid_coupon : "That promo code is not valid." ?></div>
		<? } ?>
		<div align="right">
			<?= $this->Form->input("coupon", array('id'=>'coupon', 'label'=>'Promo Code','size'=>8,'value'=>$this->Session->read("coupon"))); ?>
			<a href="javascript:void(0)" id='coupon_apply'><img src="/images/buttons/small/Apply.gif"/></a>
		</div>
	<script>
		j('#coupon_apply').click(function() {
			coupon = j('#coupon').val();
			var data = { coupon: coupon };
			showPleaseWait();
			j.post("/checkout/redeem_coupon", data,function(response) {
				j('#shipping_speed_review').html(response);
				hidePleaseWait();
			});
		});
	</script>
	</div>
	<div class='clear'></div>
	<? #} ?>
</td>
</tr>
</table>
<script>
j(document).ready(function() {
	if(j('#order_summary2'))
	{
		j('#order_summary2').html('');
		j('#order_summary').clone().contents().appendTo('#order_summary2');
	}
});
</script>
