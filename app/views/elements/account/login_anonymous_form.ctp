<? if(empty($goto)) { $goto = ""; }
?>
<div>
		<h3 class="alert2">Checkout without creating an account</h3>
		<p>
		All we need is your contact information to contact you after the order.
		</p>
		<?php echo $form->create('Customer',array('url'=>array('controller'=>'account','action'=>'signup_anonymous')));?>
			<input type="hidden" name="goto" value="<?= $goto ?>"/>
			<?= $form->input('eMail_Address', array('label'=>'Email:','after'=>'<br/>A confirmation email/receipt is sent to you after you order.<br/><br/>')); ?>
			<?= $form->input('Phone', array('type'=>'text','after'=>'<br/>A phone number lets us contact you regarding order details and shipping questions.<br/><br/<br/>')); ?>
			<input type="image" src="/images/buttons/Checkout.gif"/>
		</form>

</div>
