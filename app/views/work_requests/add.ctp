<div class="">
<?
	$pass = !empty($this->params['pass']) ? join("/", $this->params['pass']) : "";
?>

	<div class="center_block" style="width: 75%;">

	<?= $form->create("WorkRequest",array('url'=>"/work_requests/add/$pass",
		'type'=>'file','onSubmit'=>'if(verifyRequiredFields(this)) { if (!$("agree").checked) { alert("You must agree to the policy to continue"); $("agree").focus(); return false; }; return true; }; return false;')); ?>
	<?= $form->hidden("wholesale", array('value'=>$wholesale)); ?>


<table border=0> 
	<tr>
		<td valign="top" width="50%">
			<div>Please fill out this form so we can begin work on your project.</div>
			<br/>
			<div class="bold green">
				Required fields are in green.
			</div>
			<br/>
			<div class="hidden">
				<p>To order with an existing account, or signup to save your information for future orders, <a href="/account/login?goto=/workrequest">click here</a>.
			</div>
		</td>
		<td valign="top">
			<table>
			<tr>
				<td valign="top">
					<SCRIPT LANGUAGE="JavaScript"  TYPE="text/javascript" SRC="//smarticon.geotrust.com/si.js"></SCRIPT>
				</td>
				<td valign="top">
					We provide a secure environment for your personal data and transactions. Click on the logo to verify
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
	<td valign="top">

		<h3>Contact Information:</h3>
		<table>
			<tr class="required required_green">
				<th align="left">
					<label for="WorkRequestName">Name</label>
				</th>
				<td>
					<?= $form->text("name"); ?>
				</td>
			</tr>
			<tr class="required required_green">
				<th align="left">
					<label for="WorkRequestEmail">Email</label>
				</th>
				<td>
					<?= $form->text("email"); ?>
				</td>
			</tr>
			<tr class="required required_green">
				<th align="left">
					<label for="WorkRequestPhone">Phone</label>
				</th>
				<td>
					<?= $form->text("phone"); ?>
				</td>
			</tr>
			<tr>
				<th valign="top">
					<br/>
					<label for="">Ship To</label>
				</th>
				<td valign="top">
					<br/>
							<div class="required required_green">
								<div>
									<label for="ShippingAddress">Address:</label>
									<?= $form->text("Shipping.Address_1"); ?>
								</div>
								<div>
									<label for="ShippingCity">City:</label>
									<?= $form->text("Shipping.City"); ?>
								</div>
								<div>
									<label for="ShippingState">State:</label>
									<?= $form->text("Shipping.State"); ?>
								</div>
								<div>
									<label for="ShippingZip">Zip:</label>
									<?= $form->text("Shipping.Zip_Code"); ?>
								</div>
							</div>
				</td>
			</tr>
		</table>
	</td>
	<td valign="top">
		<h3>Payment Information:</h3>
			You will not be charged until we confirm all details of your project.
		<table>
			<tr class="required required_green">
				<th align="left">
					<label>Payment Type</label>
				</th>
				<td valign="top">
					<?
						$cardTypes = array(
							'Visa'=>
							'Visa',
							'American Express'=>
							'American Express',
							'Discover'=>
							'Discover',
							'MasterCard'=>
							'MasterCard',
							'Paypal'=>
							'Paypal',
						);
					?>
					<?= $form->input("CreditCard.Card_Type", array('options'=>$cardTypes, 'empty'=>'[Select a payment type]', 'label'=>false, 'onChange'=>"if(this.value != '' && this.value != 'Paypal') { $('credit_card_info').removeClassName('hidden'); $('paypal_info').addClassName('hidden'); } else { $('credit_card_info').addClassName('hidden'); if (this.value == 'Paypal') { $('paypal_info').removeClassName('hidden'); }}")); ?>
				</td>
			</tr>

			<tbody id="paypal_info" class="<?= !empty($this->data['CreditCard']['Card_Type']) && $this->data['CreditCard']['Card_Type'] == 'Paypal' ? "" : "hidden" ?> ">
			<tr>
				<td colspan=2>
				We will send your invoice through your PayPal account specified by your email on the left
				</td>
			</tr>
			</tbody>

			<tbody id="credit_card_info" class="<?= !empty($this->data['CreditCard']['Card_Type']) && $this->data['CreditCard']['Card_Type'] != 'Paypal' ? "" : "hidden" ?> ">
			<tr class="required required_green">
				<th align="left">
					<label for="CreditCardNumberPlain">Card #</label>
				</th>
				<td>
					<?= $form->text("CreditCard.NumberPlain"); ?>
				</td>
			</tr>
			<tr class="">
				<th align="left">
							<label for="">Expiration</label>
				</th>
				<td>
							<input type="hidden" name="data[CreditCard][Expiration][day]" value="1"/>
								<select name="data[CreditCard][Expiration][month]">
									<option value="01">01 - January</option>
									<option value="02">02 - February</option>
									<option value="03">03 - March</option>
									<option value="04">04 - April</option>
									<option value="05">05 - May</option>
									<option value="06">06 - June</option>
									<option value="07">07 - July</option>
									<option value="08">08 - August</option>
									<option value="09">09 - September</option>
									<option value="10">10 - October</option>
									<option value="11">11 - November</option>
									<option value="12">12 - December</option>
								</select>

								<select name="data[CreditCard][Expiration][year]">
									<? for($i = 0; $i < 20; $i++) { $year = date('Y') + $i; ?>
										<option value="<?= $year ?>"><?= $year ?></option>
									<? } ?>
								</select>
				</td>
			</tr>
			<tr>
				<th valign="top">
					<br/>
					<label for="cardnum" class="bold">Billing Address</label>
				</th>
				<td valign="top">
					<br/>
					<input type="checkbox" value="1" onClick="if(this.checked) { 
						$('BillingAddress1').value = $('ShippingAddress1').value;
						$('BillingCity').value = $('ShippingCity').value;
						$('BillingState').value = $('ShippingState').value;
						$('BillingZipCode').value = $('ShippingZipCode').value;
						}
						"> Same as shipping

							<div class="required required_green">
								<div>
									<label for="BillingAddress">Address:</label>
									<?= $form->text("Billing.Address_1"); ?>
								</div>
								<div>
									<label for="BillingCity">City:</label>
									<?= $form->text("Billing.City"); ?>
								</div>
								<div>
									<label for="BillingState">State:</label>
									<?= $form->text("Billing.State"); ?>
								</div>
								<div>
									<label for="BillingZip">Zip:</label>
									<?= $form->text("Billing.Zip_Code"); ?>
								</div>
							</div>
				</td>
			</tr>
			</tbody>

		</table>
	</td>
</tr>
<? if($mode != 'nodetails') { ?>
<tr>
	<td colspan=2>
	<h3>Product Details:</h3>
	</td>
</tr>
<tr>
	<td colspan=1 valign="top">

				<script>
					var minimums = new Array();
					<? foreach($product_minimums as $pid => $min) { ?>
					minimums[<?= $pid ?>] = <?=$min?>;
					<? } ?>

					var stock_items = new Array();
					<? foreach($stock_items as $pid) { ?>
					stock_items[<?= $pid ?>] = true;
					<? } ?>

					function requireMinimum(notify)
					{
						var qty = $('WorkRequestQuantity');
						var prod = $('WorkRequestProductTypeId');
						var pid = prod.value;
						var minimum = minimums[pid];
						if (qty.value == "") { return; }  // OK to omit.
						if (qty.value < minimum)
						{
							qty.value = minimum;
							if (notify)
							{
								alert('Minimum quantity for this product is '+minimum);
							}
						}
					}

					function updateProduct(pid)
					{
						if(stock_items[pid])
						{
							$('proof_policy').addClassName('hidden');
							$("agree").checked = 'checked'; // So we dont require anymore....
							$("art").addClassName("hidden");
						} else {
							$('proof_policy').removeClassName('hidden');
							$("agree").checked = false; // So we dont require anymore....
							$("art").removeClassName("hidden");
						}
					}
				</script>

	<table width="100%">
	<tr>
		<td valign="top">
			<label class="bold required required_green">Product</label>
			<div>
				<?= $form->select("product_type_id", $product_map,null, array('onChange'=>'requireMinimum(true); updateProduct(this.value);'), false); ?>
			</div>
		</td>
		<td valign="top">
			<label class="bold">Quantity</label>
			<div>
				<?= $form->text("quantity", array('size'=>4, 'onChange'=>'requireMinimum(true); calculateWorkRequestPricing($("WorkRequestAddForm"));')); ?>
				<script>
				Event.observe(window, 'load', function() { requireMinimum(); });
				</script>
			</div>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">
		</td>
		<td valign="top">
			<div id="work_request_pricing">
				<?= $this->element("work_requests/pricing",array('price'=>0)); ?>
			</div>
		</td>
	</tr>
	<tr>
		<td valign="top">
		</td>
		<td>
		</td>
	</tr>
	</table>

	</td>
	<td valign="top">
		<? if($mode != 'noart') { ?>
		<div id="art">
			<? if(!empty($custom_image)) { ?>
				<label class="bold">Your Art</label>
				<div>
					<?= $this->element("build/preview", array('cart_item_id'=>$cart_item_id,'build'=>array('Product'=>$product, 'CustomImage'=>$customImage,'GalleryImage'=>$galleryImage,'cart'=>1,'template'=>$template,'options'=>$options))); ?>
				</div>
			<? } else { ?>
				<label class="bold">Provide Your Art (optional)</label>
				<div>
					<?= $form->file("file"); ?>
					<div style="" class="alert2">Skip this step if we already have your art</div>
					<br/>
					<div>
					Up to 2 MB (full-screen size) accepted.<br/>
					File formats allowed: .gif, .jpg, .png, .tif, .psd, .eps
					</div>
					<br/>
				</div>
			<? } ?>
		</div>
		<? } ?>
	</td>
</tr>
<? } ?>
</table>

<br/>

		<div id="proof_policy">

		<h4>Harmony Designs Production and Proof Policy <span style="font-size: 12px;">(Please read carefully and agree to terms below):</h4>
<div style="border: solid #CCC 1px; background-color: #EEE;" class="padded">

	<ul class="padded_list">
	<li> If you would like an email proof without ordering, the cost is $25 each. Email proofs are free when an order is placed.
	
	<li> With your order you receive:  One free email proof plus one free email revision. Further proofs are charged at the rate of $60/ hour in 15 minute ($15) increments.  It is unusual for customers to require more than one proof plus one free revision if care is taken to think through the details in advance.
	
	<li> Work involved for email proofing includes typesetting, layout and design, placement in our template and slight color adjustment.
	
	<li> Any additional research, color correction or design will be charged at the rate of $60/hour billed in 15 minute ($15) increments. 
	
	<li> Your email proof may be watermarked.  The watermark, of course, will not appear on the actual printed product.

	<li> A pre-production sample is available for $49 (plus shipping).

	<li> A random sample is available at no charge.
	
	<li> Your images are never used for any purpose other than to create products. Your images remain your intellectual property.   We will ask for your permission if we would like to feature your products on our website. 
	
	</ul>
</div>
	<input id="agree" type="checkbox" name="agree" value="1"/> I have read and agree to the terms of the Harmony Designs Production and Proof Policy
	<br/>
	<br/>

	<table width="100%">
	<tr>
	<td valign="top">

		<input type="radio" name="data[WorkRequest][proof_only]" value="2" checked='checked'/> No email proof <br/>
		<input type="radio" name="data[WorkRequest][proof_only]" value="0"/> Email proof with your order - FREE<br/>
		<input type="radio" name="data[WorkRequest][proof_only]" value="1"/> Email proof without order - $25.00<br/>
		<br/>
		<input type="checkbox" name="data[WorkRequest][pre_production]" value="1"/> Pre-production sample - $49.00 + shipping<br/>
		<br/>
		<input type="checkbox" name="data[WorkRequest][random_sample]" value="1"/> Random sample sent by mail - FREE<br/>
	</td>
	<td valign="top">
			<label class="bold">Comments/Details</label>
			<div>
				<?= $form->textarea('comments', array('style'=>'width: 90%;','rows'=>4)); ?>
			</div>
		
	</td>
</tr>
	</td>
	</table>

</div>


		<div class="">
			<input type="image" src="/images/buttons/Send-grey.gif"/>
			<br/>
			After you send your information to our secure server, we are notified by email and can proceeed with your order.
		</div>

		</form>
	</div>
