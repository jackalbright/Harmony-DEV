<div class="" align="right">
<?
if(!empty($checkout_step)) {
?>
<table class="" cellpadding=3 cellspacing=0>
<tr>
	<td valign="bottom" align="right">
	<table class="hidden checkout_progress" cellpadding=0 cellspacing=0><tr>
	<td class="checkout_step_first checkout_step <?= $checkout_step >= 1 ? "checkout_step_complete" : "" ?>">
		<div class="checkout_step_num">1.</div>
		Address
	</td>
	<td class="checkout_step <?= $checkout_step >= 2 ? "checkout_step_complete" : "" ?>">
		<div class="checkout_step_num">2.</div>
		Shipping 
	</td>
	<td class="checkout_step <?= $checkout_step >= 3 ? "checkout_step_complete" : "" ?>">
		<div class="checkout_step_num">3.</div>
		Payment
	</td>
	<td class="checkout_step <?= $checkout_step >= 4 ? "checkout_step_complete" : "" ?>">
		<div class="checkout_step_num">4.</div>
		Review
	</td>
	</tr></table>
	</td>
	</tr>
	<tr>

	<td colspan=1 class="" align="right" valign="bottom">
	<?= $this->element("checkout/links"); ?>
		
	</td>
</tr>

</table>
<? } ?>
</div>
