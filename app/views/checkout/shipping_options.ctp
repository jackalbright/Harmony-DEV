<? if(empty($zipCode)) { ?>
Enter your postal code above to see shipping options.
<? } else { ?>
<div id="shipping_speed_review">
	<?= $this->requestAction("/checkout/update_shipping_speed", array('return')); ?>
</div>
<? } ?>
