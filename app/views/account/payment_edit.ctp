<div class="" style="width: 600px;">
	<div class="bold">
		<?= $this->Html->link("< Back to My Account", "/account"); ?>
	</div>

	<br/>
	<br/>

	<? if(empty($paymentProfile->payment->creditCard)) { ?>
	<div class="italic">
		No credit card is on file.
	</div>
	<? } else { ?>
	<div>
		<h3>Card on file: ends in <?= $paymentProfile->payment->creditCard->cardNumber ?></h3>

	</div>
	<? } ?>

<?= $form->create("CreditCard", array('url'=>"/account/payment_edit", 'onSubmit'=>'return verifyRequiredFields(this);', 'id'=>'CreditCardForm')); ?>

<div id="new_card">
	<div class="grey_header_top"><span></span></div>
	<table class="form greybg" style="width: 100%;">
	<tr>
		<th colspan=2>
			<h3 class="bold">Update payment information:</h3>
		</th>
	</tr>
	<tr>
	<td valign="top">
		<?= $form->hidden("credit_card_id"); ?>
		<?= $form->input("Card_Type", array('options'=>array('Visa'=>'Visa','Mastercard'=>'Mastercard','Discover'=>'Discover','American Express'=>'American Express'))); ?>
		<?= $form->input("NumberPlain", array('size'=>20,'label'=>"Card Number",'class'=>'required')); ?>
		<div>
		<label>Expiration</label>
		<?
			$months = array();
			for($i = 1; $i <= 12; $i++) { $months[$i] = sprintf("%02u - %s", $i, date("M", strtotime("2011-$i-01"))); }
			for($i = 0; $i < 10; $i++) { $year = date("Y", strtotime("+$i years")); $years[$year] = $year; }
		?>
		<?= $form->select("CreditCard.Expiration.month",$months, null, array('class'=>'required')); ?>
		<?= $form->select("CreditCard.Expiration.year",$years, null, array('class'=>'required'));?>
		</div>
	
		<?= $form->input("Cardholder", array('size'=>20,'label'=>"Name on Card",'class'=>'required')); ?>
	</td>
	<td valign="top">
		<h3>Billing Address</h3>
		<?= $form->hidden("ContactInfo.Contact_ID"); ?>
		<?= $form->input("ContactInfo.Address_1", array('label'=>'Address','class'=>'required')); ?>
		<?= $form->input("ContactInfo.Address_2", array('label'=>false)); ?>
		<?= $form->input("ContactInfo.City", array('class'=>'required'));?>
		<?= $form->input("ContactInfo.State", array('class'=>'required'));?>
		<?= $form->input("ContactInfo.Zip_Code", array('class'=>'required'));?>
		<?= $form->input("ContactInfo.Country");?>
	</td>
	</tr></table>
	<div class="grey_header_bottom"><span></span></div>


	<div class="center">
		<table width="100%"><tr>
			<td width="50%" valign="middle" align="right">
				<input valign="middle" type="image" src="/images/buttons/Save-grey.gif"/>
			</td>
			<td valign="middle" align="left">
			<? if(!empty($paymentProfile->payment->creditCard)) { ?>
				or 
				&nbsp;
				&nbsp;
				<?= $this->Html->link("Cancel", "/account", array('style'=>'color: #FF0000;')); ?>
			<? } ?>
			</td>
		</tr></table>
	</div>

</div>

</form>

</div>
