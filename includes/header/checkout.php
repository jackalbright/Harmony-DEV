				<table border=0 id="steps" cellpadding=0 cellspacing=0 border=1>
				<tr>
					<td class="step1 step <?= $checkout_step == 1 ? 'selected_step' : 'previous_step' ?>" valign="top">
						<a href="/checkout/shipping_select">Address</a>
					</td>
					<td class="step2 step <?= $checkout_step == 2 ? 'selected_step' : ($checkout_step > 2 ? 'previous_step' : "") ?>" valign="top">
						<a href="/checkout/shipping_method">Shipping</a>
					</td>
					<td class="step3 step <?= $checkout_step == 3 ? 'selected_step' : ($checkout_step > 3 ? 'previous_step' : "") ?>" valign="top">
						<a href="/checkout/payment_select">Payment</a>
					</td>
					<td class="step4 step <?= $checkout_step == 4 ? 'selected_step' : "" ?>" valign="top">
						<a href="/checkout/review">Review</a>
					</td>
				</tr>
				</table>

