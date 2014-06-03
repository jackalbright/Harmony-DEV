<script>
var zipChangeId = 0;
</script>
<?
$payment_method = !empty($this->data['payment_method']) ? $this->data['payment_method'] : (!empty($this->data['Customer']['payment_profile_id']) ? $this->data['Customer']['payment_profile_id'] : 'card');
?>
<div class="right">
	<?= $this->element('checkout/links'); ?>
</div>
<? if((empty($customer) || !empty($customer['guest']))) { ?>
	<span style="font-size: 16px;" class="bold">Have an account?</span>
	<a href="/account/login?goto=/<?= $this->params['url']['url'] ?>"><img align="top" src="/images/webButtons2014/orange/small/signIn.png"/></a>

	<span style="padding: 0px 10px; ">- OR -</span>
	<? if(empty($wholesale_site)) { ?>
	<span style="font-size: 16px;" class="bold">Checkout as a guest below</span>
	<?  } else { ?>
	<span style="font-size: 16px;" class="bold">Checkout and create an account below</span>
	<? } ?>
<? } ?>
<div class="clear"></div>
<div class="form">
<strong>line: <?php echo __line__?> /views/checkout/form.ctp<br></strong>
	<?= $form->create('Purchase', array('url'=>$this->here,'id'=>'checkoutForm','onSubmit'=>"if(validateForm(this)) { j('place_order').addClass('hidden'); j('processing').removeClass('hidden'); showPleaseWait(); } else { return false; }")); ?>
	<table border=0 width="100%">
	<tr>
		<td width="60%" valign="top">
			<h3 style="background-color: #AAA; padding: 5px;">Shipping Address</h3>
			<div id="shipping_info" style="padding: 10px;">
				<? if(empty($customer_id) || empty($this->data['ShippingAddress']) || empty($this->data['ShippingAddress']['Zip_Code']) || empty($this->data['ShippingAddress']['Address_1'])) { ?>
					<?= $this->element("../checkout/form_address_edit", array('address_type'=>'shipping')); ?>
				<? } else { ?>
					<?= $this->element("../checkout/form_address_view", array('address_type'=>'shipping','address_id'=>$shipping_id,'address'=>array('ContactInfo'=>$this->data['ShippingAddress']))); ?>
				<? } ?>
				<?#= $this->requestAction("/checkout/form_address_view/shipping",array('return')); ?>
			</div>
		</td>
		<td valign="top">
			<h3 style="background-color: #AAA; padding: 5px;">Billing Address</h3>
			<div id="billing_info" style="padding: 10px; <?##=  $shipping_id != '' && $shipping_id == $billing_id ? "display: none;" :""?>">
				<? if(empty($customer_id) || empty($this->data['BillingAddress']) || empty($this->data['BillingAddress']['Zip_Code'])) { ?>
					<?= $this->element("../checkout/form_address_edit", array('address_type'=>'billing')); ?>
				<? } else { ?>
					<?= $this->element("../checkout/form_address_view", array('address_type'=>'billing','address_id'=>$billing_id,'address'=>array('ContactInfo'=>$this->data['BillingAddress']))); ?>
				<? } ?>
				<?#= $this->requestAction("/checkout/form_address_view/billing",array('return')); ?>
			</div>
	</td>
	</tr>
	<tr>
		<td valign="top">
			<h3 style="background-color: #AAA; padding: 5px;">Shipping Options</h3>
			<div id="shipping_method" style="">

				<?
					$zipCode = !empty($this->data['ShippingAddress']['Zip_Code']) ? $this->data['ShippingAddress']['Zip_Code'] : null;
					$country = !empty($this->data['ShippingAddress']['Country']) ? $this->data['ShippingAddress']['Country'] : "US";
				?>
				<? if(!empty($zipCode)) { ?>
					<?= $this->requestAction("/checkout/shipping_options/zipCode:$zipCode/country:$country",array('return')); ?>
				<? } else { ?>
					Enter your postal code above to see shipping options
				<? } ?>
			</div>
		</td>
		<td valign="top">
		<h3 style="background-color: #AAA; padding: 5px;">Payment Information</h3>
		<div style="padding: 10px;">

			<? 
				$authnet_cards = !empty($authnet_profile) ? $authnet_profile->xpath("paymentProfiles") : array();
				#print_r($authnet_cards);
				$cardNumber = null;
				$payment_id = null;
				foreach($authnet_cards as $card)
				{
					$payment_id = (string)$card->customerPaymentProfileId;
					$cardNumber = (string) $card->payment->creditCard->cardNumber;
					if(!empty($payment_id) && !empty($cardNumber))
					{
						$cards[$payment_id] = "Card ending in ".$cardNumber;
						break;
					}
				}
				#print_r($cards);
			?>
			<div class=''>
			</div>
			<? if(!empty($cardNumber)) { ?>
			<div style="">
				<label style="" for="paymentExistingCard" class="normal">
				<input type="radio" name="data[payment_method]" value="<?= $payment_id ?>" id="paymentExistingCard" <?= is_numeric($payment_method) ? "checked='checked'":"" ?> onClick="selectPaymentMethod(this.value);"/>
Pay with credit card <span id="card_ending_in"><?= !empty($cardNumber) ? "ending in {$cardNumber}": null ?></span>
				</b>
				</label>
			</div>
			<? } ?>
			<div style="">
				<br/>
				<label for="paymentCard" class="normal">
<input type="radio" name="data[payment_method]" value="card" id="paymentCard" <?= empty($cards) || $payment_method == 'card' ? "checked='checked'":"" ?> onClick="selectPaymentMethod(this.value);"/> <?= !empty($payment_id) ? "Update/Add new credit card":"Pay with credit card"?>
				&nbsp;
				&nbsp;
				&nbsp;
				&nbsp;
				&nbsp;
				<img align="absmiddle" src="/images/icons/cc-wide.png"/>
				</label>
			</div>
			<? /* ?>
			<div id="card">
			<? if(false !empty($cards)) { ?>
				<?= $form->input("payment_profile_id", array('options'=>$cards, 'empty'=>'','label'=>'Choose an existing credit card','onChange'=>'selectCard(this.value);')); ?>

				<br/>
			<? } ?>
			<?= $form->hidden("credit_card_id",array('id'=>'credit_card_id')); ?>
			<script>
			</script>
			<? */ ?>
			<? /* ?>
			<div id="new_card_link" style="padding: 10px 30px; <?= empty($cards) ? "display: none;":null ?>">
				<a href="javascript:void(0)" onClick="selectCard();">Update/Add new credit card</a>
			</div>
			<? */ ?>
			<div id="card" style="margin: 5px 5px 5px 35px; padding: 5px; float: left; background-color: #DDD; border: solid 1px #BBB; <?= !empty($cards)  && $payment_method != 'card' ? "display:none;":""?>" class="inline_label">
				<?= $form->input("CreditCard.Cardholder", array('size'=>20,'label'=>"Name on Card",'onChange'=>'selectCard();')); ?>
				<br/>

				<?= $form->input("CreditCard.NumberPlain", array('size'=>20,'label'=>"Card Number",'onKeyUp'=>'filterInvalidCardDigits();','onChange'=>'selectCard()')); ?>
				<br/>
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
				<?	 
				$months = array();
				for($i = 1; $i <= 12; $i++)
				{
					$monthname = date("M", mktime(0,0,0, $i, 1, 2011));
					$months[$i] = sprintf("$monthname - %02u", $i);
				}
				echo $form->select("CreditCard.Expiration.month",$months, $default_month,array('empty'=>false));
				$years = array();
				$current = date("Y");
				for($i = 0; $i < 10; $i++)
				{
					$years[$current+$i] = $current+$i;
				};
				echo $form->select("CreditCard.Expiration.year", $years,$default_year,array('empty'=>false));
				#echo $form->year("Expiration",date("Y")+10,date("Y"),null,null,false);
			?>
			</div>
			<div class="clear"></div>

			<div>
			<br/>
			<table cellpadding=0 cellspacing=0>
			<tr><td valign="top">
			<label for="paymentAmazon" class="normal">
			<input class='' type="radio" name="data[payment_method]" value="amazon" id="paymentAmazon" <?= $payment_method == 'amazon' ? "checked='checked'":"" ?> onClick="selectPaymentMethod(this.value);"/> Checkout with
				&nbsp;
				<img style="vertical-align: top;" src="/images/icons/amazon-payments.gif" onClick="selectPaymentMethod('amazon');"/>
			</label>
			</td><td valign="top" style="padding-left: 10px;">
				Pay with your existing</br>Amazon.com account
			</td></tr></table>
			<div class="clear"></div>
			</div>

			
			<div>
			<br/>
			<label for="paymentPaypal" class="normal">
			<input class='' type="radio" name="data[payment_method]" value="paypal" id="paymentPaypal" <?= $payment_method == 'paypal' ? "checked='checked'":"" ?> onClick="selectPaymentMethod(this.value);"/> Checkout with
				<img style="vertical-align: top;" src="/images/icons/paypal-logo-small.png"/>
			</label>
			<div class="clear"></div>
			</div>


			<? if(!empty($this->malysoft) || !empty($customer['billme'])) { ?>
			<br/>
			<div>
				<label>
				<input type="radio" name="data[payment_method]" value="billme" id="paymentBillme" <?= $payment_method == 'billme' ? "checked='checked'":"" ?> onClick="selectPaymentMethod(this.value);"/>
				<b>Bill Me Later</b>
				</label>
				<div id="billme" style="<?= $payment_method != 'billme' ? "display:none;" :"" ?>">
				<?= $form->input("Purchase.customer_po",array('label'=>'Purchase Order # (optional)')); ?>
				</div>
			</div>
			<? } else if(!empty($wholesale_site)) { ?>
			<br/>
			<div style="margin-left: 25px;">
				For "Bill Me Later" (For museums/historic sites only), please call 888.293.1109

			</div>
			<? } ?>
		</div>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<h3 style="background-color: #AAA; padding: 5px;"><?= !empty($wholesale_site) ? "Your Account Information" : "Contact Information &mdash; For shipping-related questions" ?></h3>
			<table><tr>
				<td valign="top"> <?= $form->input("Customer.eMail_Address", array('label'=>'Email','class'=>'required')); ?> </td>
				<td valign="top"> <?= $form->input("Customer.Phone", array('class'=>'required','after'=>'<br/><i>Required for delivery questions</i>')); ?> </td>
			<? if(!empty($wholesale_site)) { ?>
			<td valign="top">
			<?= $form->hidden("Customer.is_wholesale", array('value'=>1)); ?>
			<?= $form->hidden("Customer.pricing_level", array('value'=>100)); ?>
			<?#= $form->input("Customer.resale_number", array('class'=>'required')); ?>
			</td>
			<? } ?>
			</tr></table>

			<? if(empty($customer) || !empty($customer['guest'])) { 
				$guest = !empty($wholesale_site) ? 0 : (isset($this->data['Customer']['guest']) ? $this->data['Customer']['guest'] : 1);
			?>
			<?= $form->hidden("Customer.guest", array('value'=>$guest)); ?>
			<? if(empty($wholesale_site)) { ?>
			<?= $form->input("Customer.create_account", array('label'=>'Create an account','type'=>'checkbox','onClick'=>"j('#password').toggle(); j('#CustomerGuest').val(this.checked?0:1);")); ?>
			<div style="font-size: 11px; padding-left: 25px;">
			With an account you will be able to retrieve past orders, reorder, update your account and check out in two clicks.
			</div>
			<? } ?>
			<div id="password" style="<?= !empty($guest) ? "display:none;" : "" ?>">
			<table><tr>
				<td valign="top"><?= $form->input("Customer.Password", array('type'=>'password','label'=>'Create a password','class'=>!empty($wholesale_site)?"required":"")); ?></td>
				<td valign="top"><?= $form->input("Customer.Password2", array('type'=>'password','label'=>'Enter password again','class'=>!empty($wholesale_site)?"required":"")); ?></td>
			</tr></table>
			</div>
			<div><i>You'll be able to sign in, reorder, save your art and designs using your email and password</i></div>
			<br/>
			<br/>
			<? } ?>
		</td>
		<td valign="top">
			<h3 style="background-color: #AAA; padding: 5px;">Comments or Questions About Your Order</h3>
			<textarea name="orderComment" style='width: 98%;' rows=5></textarea>
		</td>
	</tr>
	</table>
<?= $this->element("cart/cart",array('checkout'=>1,'review'=>1,'read_only_summary'=>1,'receipt'=>1)); ?>

	<?= $form->end(); ?>

</div>


<script>
function validateForm(form)
{
	if(!verifyRequiredFields(form)) // Basic 'required' class checks.
	{
		return false;
	}

	if(j('#shipping_info .form_address_select').size() > 0 && !j('#ShippingAddressContactID').size())
	{
		alert("Please choose a shipping address");
		return false;
	}

	if(j('#billing_info .form_address_select').size() > 0 && !j('#BillingAddressContactID').size())
	{
		alert("Please choose a billing address");
		return false;
	}

	// Check credit card or profile id.
	if(j('#paymentCard').prop('checked'))
	{
		// Must use card.
		// CHECK CARD!
		if(!verifyField(form, j('#CreditCardNumberPlain').get(0))) { return false; }
		if(!verifyField(form, j('#CreditCardCardholder').get(0))) { return false; }
		if(!j('#CreditCardCardholder').val().match(/\w\s\w/)) {
			j('#CreditCardCardholder').formerror('Missing first or last name');
			alert("Please include both a first and last name for the cardholder");
			return false; 
		}

		var cardnum = j('#CreditCardNumberPlain').val();
		if(cardnum.length < 13 || cardnum.length > 16)
		{
			j('#CreditCardNumberPlain').formerror("Invalid credit card number. Must be between 13 and 16 digits");
			//return false;
		}

		var expyear = parseInt(j('#CreditCardExpirationYear').val());
		var expmonth = parseInt(j('#CreditCardExpirationMonth').val());
		var thisyear = parseInt("<?= date('Y'); ?>");
		var thismonth = parseInt("<?= date('n'); ?>");

		//console.log("EY="+expyear+" < "+thisyear+"; EM="+expmonth+" < "+thismonth);

		if(expyear < thisyear || (expyear == thisyear && expmonth < thismonth))
		{
			// TODO FIX?
			j('#CreditCardExpirationYear').formerror("Invalid expiration date for credit card");
			//return false;
		}
	}

	<? if(empty($customer)) { ?>
	var pass1 = j('#CustomerPassword');
	var pass2 = j('#CustomerPassword2');
	var guest = parseInt(j('#CustomerGuest').val());
	if(!guest)
	{
		if(!pass1.val())
		{
			j('#CustomerPassword').formerror("Password cannot be left blank");
		} else if(!pass2.val())
		{
			j('#CustomerPassword2').formerror("Please verify your password");
		} else if(pass1.val() != pass2.val())
		{
			j('#CustomerPassword2').formerror("Passwords do not match");
			//pass1.focus();
			//return false;
		} else if(pass1.val().length < 6) {
			j('#CustomerPassword').formerror("Password is too short. Must be 6 or more characters.");
			//pass1.focus();
			//return false;
		}
	}
	<? } ?>

	//console.log(j('.formerror:visible'));

	var errors = j('.formerror:visible');
	if(errors.size())
	{
		j(window).scrollTo(errors[0], { offset: -50 });
		return false;
	}

	return true;
}



function billingSameAsShipping()
{
	if(!j('#ShippingAddressName0').length)
	{
		var shipping_id = j('#ShippingAddressContactID').val();
		j('#billing_info').load('/checkout/form_address_view/billing/'+shipping_id);
	} else {

		if(!j('#BillingAddressContactID').size())
		{
			// If Billing is not on the form page, load it and fill it in...
			var shipping_id = j('#ShippingAddressContactID').val();
			j('#billing_info').load('/checkout/form_address_edit/billing/'+shipping_id);
		}

		j('#shipping_info input, #shipping_info select').each(function(index, value) {
			//console.log(j(this).attr('id'));
			var shipping_field_id = j(this).attr('id');
			if(!shipping_field_id) { return; }
			var billing_field_id = shipping_field_id.replace(/ShippingAddress/, "BillingAddress");
	
			j('#'+billing_field_id).val(j('#'+shipping_field_id).val());
		});
	}
}

function populateBilling(datastring)
{
	var data = j.parseJSON(datastring);
	for(key in data)
	{
		var pkey = key.replace(/_/,"");
		j('#BillingAddress'+pkey).val(data[key]);
	}
	var names = data["In_Care_Of"].split(" ");
	if(names.length >= 2)
	{
		j('#BillingAddressName0').val(names[0]);
		j('#BillingAddressName1').val(names[names.length-1]);
	}
}

function populateShipping(datastring)
{
	var data = j.parseJSON(datastring);
	for(key in data)
	{
		var pkey = key.replace(/_/,"");
		//console.log("SETTGING #SHIPingAddress"+pkey);
		j('#ShippingAddress'+pkey).val(data[key]);
	}
	var names = data["In_Care_Of"].split(" ");
	if(names.length >= 2)
	{
		j('#ShippingAddressName0').val(names[0]);
		j('#ShippingAddressName1').val(names[names.length-1]);
	}
	// Re-calc shipping options.
	loadShipping(j('#ShippingAddressZipCode').val(), j('#ShippingAddressCountry').val());
}

function clearCreditCard()
{
	j('#CreditCardCardholder').val();
	j('#CreditCardNumberPlain').val();
}

function selectCard(id)
{
	if(id && id != '')
	{
		j('#PurchasePaymentProfileId').val(id);
		j('#new_card').hide();
		j('#new_card_link').show();
	} else {
		j('#PurchasePaymentProfileId').val('');
		j('#new_card').show();
		j('#new_card_link').hide();
	}
}
function filterInvalidCardDigits()
{
	$('CreditCardNumberPlain').value = $('CreditCardNumberPlain').value.replace(/\D/, "");
}

function selectPaymentMethod(type)
{
	if(type == 'card')
	{
		j('#card').show();
	} else {
		j('#card').hide();
		clearCreditCard();
	}
	if(type == 'amazon') {
		// Create form and post to their site....
		// XXX need to know what info is required to be passed....

		// need to sync amazon form with content on page.
		// Only thing that changes is  everything! including email , which never will get saved, etc.
		// Form MUST be sent to server FIRST, then passed to amazon.
		// can we redirect to a post url?
	}
	if (type == 'paypal') {
	} else {
	}
	if (type == 'billme') { 
		j('#billme').show();
	} else {
		j('#billme').hide();
	}
}
function refreshAddress(address_type, address_id)
{
	var modelClass = (address_type == 'shipping') ? "BillingAddress" : "ShippingAddress";
	var otherID = j('#'+modelClass+'ContactID').val();

	var otherdiv = j('#'+address_type+'_info');
	if(otherdiv.find('div.form_address_edit').length && otherID == address_id)
	{
		// Could have changed details, refresh.
		otherdiv.load("/checkout/form_address_edit/"+address_type+"/"+otherID);
	} else if(otherdiv.find('div.form_address_view').length && otherID == address_id) {
		// Could have changed details, refresh.
		otherdiv.load("/checkout/form_address_view/"+address_type+"/"+otherID);
	} else if(otherdiv.find('div.form_address_select').length) {
		// Could have changed details, refresh.
		otherdiv.load("/checkout/form_address_select/"+address_type);
	}
}
function loadShipping()
{
	j('#ShippingAddressZipCode').val(
		j('#ShippingAddressZipCode').val().replace(/\W+/g, "")
	);
	var zipCode = j('#ShippingAddressZipCode').val();
	var country = j('#ShippingAddressCountry').val();
	clearTimeout(zipChangeId);
	j('#shipping_method').html('<b>Please wait...</b>');
	
	/*
	if(!zipCode) { 
		j('#shipping_method').html('Enter your postal code above to see shipping options'); //Clear
		return;
	}
	*/

	j('#shipping_method').load("/checkout/shipping_options/zipCode:"+zipCode+"/country:"+country);
}
var zipChangeId = 0;
function startZip()
{
	clearTimeout(zipChangeId);
}
function endZip()
{
	clearTimeout(zipChangeId);
	zipChangeId = setTimeout("loadShipping();", 3000);
}

j(document).ready(function()
{
	j.getJSON("/checkout/form_data", function(data) { 
		if(data)
		{
			for(field in data)
			{
				if(typeof data[field] == 'object')
				{
					for(of in data[field])
					{
						if (data[field][of] instanceof Array)
						{
							for(var i = 0; i < data[field][of].length; i++)
							{
								//console.log(field+"/"+of+"/"+i+"="+data[field][of][i]);
								var id = (field+of+i).camelize().replace(/_/, "");
								var name = "data\\["+field+"\\]\\["+of+"\\]\\["+i+"\\]";
								if(data[field][of][i])
								{
									j('*[name='+name+']').val([data[field][of][i]]);
								}
							}
						} else { 
							//console.log(field+"/"+of+"="+data[field][of]);
							// need to camelize field name, since underscored...
							var name = "data\\["+field+"\\]\\["+of+"\\]";
							if(data[field][of])
							{
								j('*[name='+name+']').val([data[field][of]]);
							}
						}
					}
					// since id's not always there, may need to set via 'name' field (radios)
				} else {
					// radios should check which one matches, not set all....
					// XXX TODO

					var name = "data\\["+field+"\\]";
					//console.log(field+"="+data[field]);
					if(data[field])
					{
						j('*[name='+name+']').val([data[field]]);
						//console.log(j('*[name='+name+']'));
	
						if(field == 'payment_method' && data[field] == 'paypal')
						{
							j('#billme').hide();
							j('#card').hide();
						} 
						else if(field == 'payment_method' && data[field] == 'billme')
						{
							j('#billme').show();
							j('#card').hide();
						} 
					}
				}
			}
		}
	});
});
</script>
