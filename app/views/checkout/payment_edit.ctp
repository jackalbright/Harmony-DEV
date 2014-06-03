<div>

<?= $form->create("CreditCard", array('url'=>"/checkout/payment_edit", 'onSubmit'=>"if ($('CreditCardCreditCardId').checked) { return verifyRequiredFields(); }", 'id'=>'CreditCardForm')); ?>

<?= $form->hidden("credit_card_id",array('id'=>'credit_card_id')); ?>
<? 
	#DISALBED$form->input("Card_Type", array('options'=>array('Visa'=>'Visa','Mastercard'=>'Mastercard','Discover'=>'Discover','American Express'=>'American Express'))); 
?>
<table>
<tr>
	<td valign="top">
		<input id="CreditCardCreditCardId" type="radio" name="data[CreditCard][credit_card_id]" value="<?= !empty($this->data['CreditCard']['credit_card_id']) ? $this->data['CreditCard']['credit_card_id'] : null; ?>" checked='checked'/>
	</td>
	<td valign="top">
		<script>
		function filterInvalidCardDigits()
		{
			$('CreditCardNumberPlain').value = $('CreditCardNumberPlain').value.replace(/\D/, "");
		}
		</script>
		<?= $form->input("NumberPlain", array('size'=>20,'label'=>"Card Number",'onChange'=>"$('CreditCardCreditCardId').checked = 'checked';",'onKeyUp'=>'filterInvalidCardDigits();')); ?>
		<div>
		<label>Expiration</label>
		<?
			$default_month = null;#date("m");
			$default_year = date("Y");
			if(!empty($this->data['CreditCard']['Expiration']))
			{
				if(is_array($this->data['CreditCard']['Expiration']))
				{
					$default_month = $this->data['CreditCard']['Expiration']['month'];
					$default_year = $this->data['CreditCard']['Expiration']['year'];
				} else {
					$default_month = date('m', strtotime($this->data['CreditCard']['Expiration']));
					$default_year = date('Y', strtotime($this->data['CreditCard']['Expiration']));
				}
			}
		?>
		<? echo $form->month("Expiration",$default_month,array('monthNames'=>false),false);
			$years = array();
			$current = date("Y");
			for($i = 0; $i < 10; $i++)
			{
				$years[$current+$i] = $current+$i;
			};
			echo $form->select("Expiration.year", $years,$default_year,array(),false);
			#echo $form->year("Expiration",date("Y")+10,date("Y"),null,null,false);
		?>
		</div>
		<?= $form->input("Cardholder", array('size'=>20,'label'=>"Name on Card",'onChange'=>"$('CreditCardCreditCardId').checked;")); ?>
	<br/>
	</td>
</tr>

<? if(!empty($paypal_enabled)) { ?>
<tr>
<td valign="top">
	<input type="radio" name="data[CreditCard][credit_card_id]" value="-1" id="CreditCardCreditCardId_1"/>
</td>
<td valign="top">
<b>Checkout with <img align="top" src="/images/icons/paypal-logo-small.png"/></b>
<!--
<input align="middle" type="image" src="/images/buttons/small/Checkout-Paypal.gif" onClick="$('CreditCardCreditCardId_1').checked = 'checked';"/>
-->
	<br/>
</td>
</tr>
<? } ?>

<? if(!empty($customer['billme'])) { ?>
<tr>
<td valign="top">
	<input type="radio" name="data[CreditCard][credit_card_id]" value="-2" id="CreditCardCreditCardId_2"/>
</td>
<td valign="top">
<!--
<b>OR</b>
<a href="Javascript:void(0)" onClick="$('CreditCardCreditCardId_2').checked = 'checked';"> <img align="absmiddle" src="/images/buttons/Billme.gif"/></a>
-->
<label for="CreditCardCreditCardId_2" class="bold">Bill Me Later</label>
<br/>Purchase Order # (optional)<br/><input type="text" name="data[customer_po]"/>
</td>
</tr>
<? } ?>

</table>


	<div class="center">
		<input type="image" src="/images/buttons/Next.gif" onClick="showPleaseWait();"/>
	</div>

	<?= $this->element("cart/cart",array('checkout'=>1,'read_only_summary'=>1)); ?>

</form>

<div>
</div>

</div>
