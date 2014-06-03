<table width="650" border=0>
<tr>
	<td align="left">
			<?=$this->element("shipfree"); ?>

			<? if(false && empty($customer['is_wholesale']) && !empty($settings['free_ground_shipping_minimum']) && !empty($subtotal) && $subtotal < $settings['free_ground_shipping_minimum']) { ?>
			<div class="alert2">
				Order <?= sprintf("$%.02f", $settings['free_ground_shipping_minimum'] - $subtotal) ?> more and qualify for free standard shipping!
			</div>
			<? } ?>

			<div style="">
			<img src="/images/icons/paypal-cc-wide.png"/>
			<img src="/images/icons/small/amazon-payments.gif"/>
			
			&nbsp;
			&nbsp;
			&nbsp;
			<a href="/info/privacy.php">Privacy Policy</a> |
			<a href="/info/guarantee.php">Guarantee/Returns</a> |
			<a href="/info/security.php">Security Info</a>
			</div>
	</td>
</tr>
</table>
