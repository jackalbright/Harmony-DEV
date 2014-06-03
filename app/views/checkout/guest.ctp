<div>
	<a href="/checkout?reset=1">Checkout with an existing account</a>
	<br/>
	<br/>
</div>
<div>

<style>
#CheckoutForm
{
	margin: 15px;
}
#CheckoutForm h3
{
	background-color: #CCC;
	padding: 5px;
	font-size: 16px;
	font-weight: bold;
	margin: 0 0 5px 0px;
}
#CheckoutForm table
{
	border-collapse: collapse;
	margin-bottom: 10px;
}
#CheckoutForm div.padded
{
	padding: 5px;
}
#CheckoutForm td
{
	vertical-align: top;
	text-align: left;
}
#CheckoutForm div.input
{
	clear: both;
	margin: 7px;
}
#CheckoutForm .inline_label > div label
{
	float: left;
	width: 100px;
	padding-right: 0px;
}
#CheckoutForm .inline_label > div input
{
}
#CheckoutForm input, #CheckoutForm textarea
{
	clear: none;
}
#CheckoutForm div.input input[type=text], #CheckoutForm div.input textarea, #CheckoutForm div.select select
{
	width: 200px;
}
</style>

<script>
function calculateShipping(zip, country)
{
	new Ajax.Updater("shippingOptions", "/checkout/calculateShipping/"+zip+"/"+country,  { method: 'POST', evalScripts: true, asynchronous: true });
}

function fillBilling(same)
{
	// fill when same, or hide when not?
	$('BillingContactInfoName0').value = $('ShippingContactInfoName0').value ;
	$('BillingContactInfoName1').value = $('ShippingContactInfoName1').value ;
	$('BillingContactInfoCompany').value = $('ShippingContactInfoCompany').value ;
	$('BillingContactInfoAddress1').value = $('ShippingContactInfoAddress1').value ;
	$('BillingContactInfoAddress2').value = $('ShippingContactInfoAddress2').value ;
	$('BillingContactInfoCity').value = $('ShippingContactInfoCity').value ;
	$('BillingContactInfoState').value = $('ShippingContactInfoState').value ;
	$('BillingContactInfoCountry').value = $('ShippingContactInfoCountry').value ;
	$('BillingContactInfoZipCode').value = $('ShippingContactInfoZipCode').value ;
}
</script>

<?= $form->create(null, array('url'=>$this->here, 'onSubmit'=>'return verifyRequiredFields();', 'id'=>'CheckoutForm')); ?>

	<?
			$countries_map = array();
			foreach($countries as $c)
			{
				$countries_map[$c['Country']['iso_code']] = $c['Country']['name'];
			}
			asort($countries_map);
	?>


<table width="100%" border=1 cellpadding=0 cellspacing=0>
<tr>
	<td width="25%">
		<h3>Shipping Information</h3>
		<div class="padded">
		<div class="Xinline_label">
			<br/>
			<?= $form->input("Shipping.ContactInfo.Name.0", array('label'=>'First Name','type'=>'text','size'=>15)); ?>
			<?= $form->input("Shipping.ContactInfo.Name.1", array('label'=>'Last Name','type'=>'text','size'=>15)); ?>
			<?= $form->input("Shipping.ContactInfo.Company", array('label'=>'Company (optional)','type'=>'text','size'=>15)); ?>
			<?= $form->input("Shipping.ContactInfo.Address_1", array('label'=>'Address','size'=>15)); ?>
			<?= $form->input("Shipping.ContactInfo.Address_2", array('label'=>'Address 2','size'=>15)); ?>
			<?= $form->input("Shipping.ContactInfo.City", array('size'=>15)); ?>
			<?= $form->input("Shipping.ContactInfo.State", array('size'=>4)); ?>
			<?= $form->input("Shipping.ContactInfo.Country", array('options'=>$countries_map,'selected'=>(!empty($country)?$country:'US'))); ?>
			<?= $form->input("Shipping.ContactInfo.Zip_Code", array('size'=>6,'onChange'=>"calculateShipping(this.value, $('ShippingContactInfoCountry').value)")); ?>
		</div>
		<?= $form->input("Shipping.ContactInfo.is_po_box", array('type'=>'checkbox','label'=>'This is a PO Box (cannot ship via FedEx)')); ?>
		</div>
	</td>
	<td width="25%">
		<h3>Billing Information</h3>
		<div class="padded Xinline_label">
			<input type="checkbox" name="data[billing_same]" value="1" onClick="fillBilling(this.checked);"/> Same as shipping
			<div id="billing_form">
				<?= $form->input("Billing.ContactInfo.Name.0", array('label'=>'First Name','type'=>'text','size'=>15)); ?>
				<?= $form->input("Billing.ContactInfo.Name.1", array('label'=>'Last Name','type'=>'text','size'=>15)); ?>
				<?= $form->input("Billing.ContactInfo.Company", array('label'=>'Company (optional)','type'=>'text','size'=>15)); ?>
				<?= $form->input("Billing.ContactInfo.Address_1", array('label'=>'Address','size'=>15)); ?>
				<?= $form->input("Billing.ContactInfo.Address_2", array('label'=>'Address 2','size'=>15)); ?>
				<?= $form->input("Billing.ContactInfo.City", array('size'=>15)); ?>
				<?= $form->input("Billing.ContactInfo.State", array('size'=>4)); ?>
				<?= $form->input("Billing.ContactInfo.Country", array('options'=>$countries_map,'selected'=>(!empty($country)?$country:'US'))); ?>
				<?= $form->input("Billing.ContactInfo.Zip_Code", array('size'=>6)); ?>
			</div>
		</div>
	</td>
	<!--
</tr>
<tr>
	-->
	<td width="25%">
		<h3>Shipping Options</h3>
		<div class="padded" id="shippinOptions">
		Fill in your shipping address to see shipping options.
		</div>
	</td>
	<td><h3>Payment Method</h3>
		<div class="padded">
			<input type="radio" checked='checked' name="data[CreditCard][credit_card_id]" value="" id="CreditCardCreditCardId" onClick="$('CreditCardDetails').show();"/> <b>Pay by credit card</b>
			<div id="CreditCardDetails">
				<?= $form->input("CreditCard.NumberPlain", array('size'=>20,'label'=>"Card Number")); ?>
				<div class="input">
				<label>Expiration</label>
				<?
					$default_month = date("m");
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
				<? echo $form->month("CreditCard.Expiration",$default_month,array('monthNames'=>false),false);
					$years = array();
					$current = date("Y");
					for($i = 0; $i < 10; $i++)
					{
						$years[$current+$i] = $current+$i;
					};
					echo $form->select("CreditCard.Expiration.year", $years,$default_year,null,false);
					#echo $form->year("Expiration",date("Y")+10,date("Y"),null,null,false);
				?>
				</div>
				<?= $form->input("CreditCard.Cardholder", array('size'=>20,'label'=>"Name on Card")); ?>
			</div>
			<br/>
			<br/>
			<br/>

			<input type="radio" name="data[CreditCard][credit_card_id]" value="-1" id="CreditCardCreditCardId_1" onClick="$('CreditCardDetails').hide();"/>
			<b>Checkout with <img align="top" src="/images/icons/paypal-logo-small.png"/></b>

		</div>
	</td>
</tr>
</table>

<div align="center">
	<input type="image" src="/images/buttons/Place-Your-Order.gif" onClick="$('place_order').addClassName('hidden'); $('processing').removeClassName('hidden'); showPleaseWait();"/>
</div>

<?= $form->end(); ?>

<?= $this->element("cart/cart",array('checkout'=>1,'read_only_summary'=>1)); ?>

<hr/>

</div>
