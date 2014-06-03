<?= $form->create("ShippingMethod", array('url'=>"/checkout/shipping_method", 'onSubmit'=>'return verifyRequiredFields();', 'id'=>'shippingMethodForm')); ?>
<div>
<div id="shipping_speed_review">
	<?= $this->requestAction("/checkout/update_shipping_speed", array('return')); ?>
</div>

</div>


	<div class="center">
		<input type="image" src="/images/buttons/Next.gif" onClick="showPleaseWait();"/>
	</div>

	<?= $this->element("cart/cart",array('checkout'=>1,'read_only_summary'=>1)); ?>

</div>
</form>
