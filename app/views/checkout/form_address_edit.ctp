<?
$other_address_type = ($address_type == 'shipping') ? 'billing' : 'shipping';
?>
<div class="form_address_edit">

<?
$key = Inflector::classify("{$address_type}_address");
$id = !empty($this->data[$key]['Contact_ID']) ? $this->data[$key]['Contact_ID'] : null;
?>
<?= $form->hidden("$key.Contact_ID"); ?>
<style>
table.address td
{
	vertical-align: top;
}
</style>

<div style="height: 20px;">
	<? if($address_type == 'billing') { ?>
	<input type="checkbox" name="data[billing_same]" <?= (!empty($this->data['billing_same']) || ($shipping_id != '' && $shipping_id == $billing_id)) ? "checked='checked'":"" ?> value="1" onClick="if(this.checked) { billingSameAsShipping(); }"/> Shipping &amp; billing address are the same
	<? } ?>
</div>

<table class="address">
<tr>
<td width="40%"> <?= $form->input("$key.Name.0", array('label'=>"First Name",'class'=>'required','type'=>'text','size'=>20)); ?></td>
<td colspan=2> <?= $form->input("$key.Name.1", array('label'=>"Last Name",'class'=>'required','type'=>'text','size'=>20)); ?></td>
</tr>
<tr>
<td colspan=2> <?= $form->input("$key.Company", array('label'=>(!empty($wholesale_site)?"Company/Museum/Organization":'Company (optional)'),'type'=>'text','size'=>20,'class'=>(!empty($wholesale_site)?"required":""))); ?></td>
</tr>
<tr>
<td valign="top"> <?= $form->input("$key.Address_1", array('label'=>'Address','class'=>'required','size'=>20,'after'=>'<br/><i>Street address</i>')); ?></td>
<td colspan=2 valign="top"> <?= $form->input("$key.Address_2", array('label'=>'Address 2','size'=>20,'after'=>'<br/><i>Suite, Apt, Unit, Floor, etc.</i>')); ?></td>
</tr>
<? if($address_type == 'shipping') { ?>
<tr>
<td colspan=2> <?= $form->input("$key.is_po_box", array('label'=>'This is a PO Box &bull; Ships via USPS','type'=>'checkbox')); ?></td>
</tr>
<? } ?>
<tr>
<td> <?= $form->input("$key.City", array('label'=>'City','class'=>'required','size'=>20)); ?></td>
<td> <?= $form->input("$key.State", array('label'=>'State','class'=>'','size'=>4)); # Not required, since intl may not have... ?></td>
<td> 
<?
$zipChange = $address_type == 'shipping' ? "loadShipping();" : null;
$zipChangeKeyUp = $address_type == 'shipping' ? "endZip();" : null;
$zipChangeKeyUpNow = $address_type == 'shipping' ? "endZip(5);" : null;
$zipChangeKeyDown = $address_type == 'shipping' ? "startZip();" : null;
?>

<?= $form->input("$key.Zip_Code", array('class'=>'required','label'=>'Zip/Postal Code','size'=>6,'onChange'=>$zipChangeKeyUpNow,'onKeyUp'=>$zipChangeKeyUp,'onKeyDown'=>$zipChangeKeyDown)); ?>
</tr>
<tr>
<td colspan=1 style="vertical-align: bottom;">
<?
		$countries_map = array();
		foreach($countries as $c)
		{
			$countries_map[$c['Country']['iso_code']] = $c['Country']['name'];
		}
		asort($countries_map);
		
		$country = !empty($this->data[$key]['Country']) ? $this->data[$key]['Country'] : 'US';
?>
<?= $form->input("$key.Country", array('options'=>$countries_map,'style'=>'width: 250px;','selected'=>$country,'onChange'=>$zipChange)); ?>
</td>
<td colspan=2 style="vertical-align: bottom;">

	<? if(!empty($customer_id) && empty($customer['guest'])) { ?>
	<?= $ajax->submit('Save address',array('url'=>array('action'=>'form_address_edit',$address_type,$id),'update'=>"{$address_type}_info")); ?>
	<? } ?>
</td>
</tr>
</table>
<? if(!empty($addresses) && count($addresses) > 1) { ?>
<br/>
<?= $ajax->link("Choose/Add new address", array('action'=>'form_address_select',$address_type), array('update'=>"{$address_type}_info")); ?>
<? } ?>
</div>
<script>
	if(j('#ShippingAddressContactID').size()) { j('#billingSame').show(); } else { j('#billingSame').hide(); } // hide 'same' if shipping not selected yet. (ie at list page)
</script>
