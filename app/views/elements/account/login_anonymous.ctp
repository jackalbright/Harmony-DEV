<? if(empty($goto)) { $goto = ""; }
?>
<div>
		<h4 class="alert2">Checkout as a guest</h4>
		<p>
		Before submitting your order, we will ask you for your email and phone so we can contact you if we have any questions about your order.
		</p>
		<?php echo $form->create('Customer',array('url'=>array('controller'=>'account','action'=>'signup_anonymous')));?>
			<input type="hidden" name="goto" value="<?= $goto ?>"/>
			<input type="image" src="/images/buttons/Checkout.gif" onClick="<?= !empty($checkout) ? "track('checkout','guest');" : "" ?>"/>
		</form>

</div>
