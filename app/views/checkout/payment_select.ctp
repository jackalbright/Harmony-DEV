<div>

<?
$url = !empty($this->data['CreditCard']['credit_card_id']) ? "/checkout/payment_edit" : "/checkout/payment_select";

?>

<?= $form->create("CreditCard", array('url'=>$url, 'onSubmit'=>'return verifyRequiredFields();', 'id'=>'CreditCardForm')); ?>

<table cellpadding=5>
	<? $i = 0; foreach($paymentMethods as $paymentMethod) { ?>
	<tr>
	<td valign="top">
		<input type="radio" name="data[CreditCard][credit_card_id]" value="<?= $paymentMethod['CreditCard']['credit_card_id']?>" <?= ((empty($payment_id) && $i++ == 0) || $payment_id == $paymentMethod['CreditCard']['credit_card_id']) ? "checked='checked'" : ""?> />
	</td>
	<td valign=top>
		<?= $paymentMethod['CreditCard']['Card_Type'] ?>
	</td>
	<td valign=top>
		Ending in -<?= substr($paymentMethod['CreditCard']['NumberPlain'], -4) ?>
	</td>
	<td valign=top>
		Exp. <?= date('m/Y', strtotime($paymentMethod["CreditCard"]["Expiration"])); ?>
	</td>
	<td valign=top>
		<b><?= $paymentMethod['CreditCard']["Cardholder"]; ?></b>
	</td>
	<td align="right">
		<div style="padding-left: 50px;">
		<a href="/checkout/payment_edit/<?= $paymentMethod['CreditCard']['credit_card_id'] ?>">Update card</a>
		&nbsp;
		<a class="alert2" onClick="return confirm('Are you sure you want to delete this payment method?');" href="/checkout/payment_delete/<?= $paymentMethod['CreditCard']['credit_card_id'] ?>">Delete card</a>
		</div>
	</td>
	</tr>
	<? } ?>
	<? if(!empty($paypal_enabled)) { ?>
	<tr>
		<td colspan=1 valign="top">
		<input id="paypal" type="radio" name="data[CreditCard][credit_card_id]" value="-1" <?= ($payment_id == -1) ? "checked='checked'" : ""?> />
		</td>
		<td valign="top">
		<b>Checkout with <img align="top" src="/images/icons/paypal-logo-small.png"/></b>
		<!--
		<label for="paypal" class="bold">Checkout with PayPal</label>
		<input type="image" align="absmiddle" src="/images/buttons/small/Checkout-Paypal.gif" onClick="$('paypal').checked = 'checked';"/>
		-->
		</td>
	</tr>
	<? } ?>

	<? if(!empty($customer['billme'])) { ?>
	<tr>
		<td colspan=1 valign="top">
			<input id="billme" type="radio" name="data[CreditCard][credit_card_id]" value="-2" <?= ($payment_id == -2) ? "checked='checked'" : ""?> />
		</td>
		<td colspan=3 valign="top">
		<label for="billme" class="bold">Bill Me Later</label>
		<!--
		<a href="Javascript:void(0)" onClick="$('billme').checked = 'checked';"><img align="absmiddle" src="/images/buttons/Billme.gif"/></a>
		-->
		Purchase Order # (optional) <input type="text" name="data[customer_po]"/>
		</td>
	</tr>
	<? } ?>


	<tr>
		<td colspan="6" align="left">
		<a href="/checkout/payment_edit">Add new card</a>
		</td>
	</tr>
</table>
	<div class="center">
		<input type="image" src="/images/buttons/Next.gif" onClick="showPleaseWait();"/>
	</div>

	<?= $this->element("cart/cart",array('checkout'=>1,'read_only_summary'=>1)); ?>

</form>

<div>
</div>

</div>
