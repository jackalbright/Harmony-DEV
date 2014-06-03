<div>

<table cellpadding=5>
	<? $i = 0; foreach($paymentMethods as $paymentMethod) { ?>
	<tr>
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
		<a href="/account/payment_edit/<?= $paymentMethod['CreditCard']['credit_card_id'] ?>">Update card</a>
		|
		<a class="alert2" href="/account/payment_delete/<?= $paymentMethod['CreditCard']['credit_card_id'] ?>" onClick="return confirm('Are you sure you want to remove this card?');">Remove card</a>
	</td>
	</tr>
	<? } ?>

	<tr>
		<td colspan="6" align="right">
		<a href="/checkout/payment_edit">Add new card</a>
		</td>
	</tr>
</table>

</div>
