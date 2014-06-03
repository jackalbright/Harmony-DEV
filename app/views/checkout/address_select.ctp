<div>

<?
if (empty($type)) { $type = 'shipping'; } # or 'billing'
$url = !empty($this->data['ContactInfo']['Contact_ID']) ? "/checkout/{$type}_edit" : "/checkout/{$type}_select";
$current_id = ($type == 'billing') ? $billing_id : $shipping_id;
?>

<?= $form->create("ContactInfo", array('url'=>$url, 'onSubmit'=>'return verifyRequiredFields();', 'id'=>'ContactInfoForm')); ?>

	<table cellspacing=0 cellpadding=5>
	<? $i = 0; foreach($addresses as $address) { ?>
	<tr class="<?= $i % 2 == 0 ? "odd" : "even" ?>">
	<td>
	<div style="padding: 10px;">
		<label>
		<input type="radio" name="data[ContactInfo][Contact_ID]" <?= ($preferredAddress == $address['ContactInfo']['Contact_ID'] || ($i == 0 && !$preferredAddress)) ? "checked='checked'" : "" ?> value="<?= $address['ContactInfo']['Contact_ID']?>"/> 
		<?= !empty($address['ContactInfo']['In_Care_Of']) ? (!empty($address['ContactInfo']['Company']) ? "ATTN: " : "").$address['ContactInfo']['In_Care_Of'] : "<i>No name specified</i>" ?>,
		<?= !empty($address['ContactInfo']['Company']) ? $address['ContactInfo']['Company'].", " : "" ?>
		<?= $address['ContactInfo']['Address_1'] ?><? if(!empty($address['ContactInfo']['Address_2'])) { ?>
			<?= $address['ContactInfo']['Address_2'] ?>
		<? } ?>, 
		<?= $address['ContactInfo']['City'] ?>,
		<?= $address['ContactInfo']['State'] ?>
		<?= $address['ContactInfo']['Zip_Code'] ?>
		<?= $address['ContactInfo']['Country'] ?>
		</label>
	</div>
	</td>
	<td align="right">
		<div style="padding-left: 50px;">
			<a href="/checkout/<?=$type?>_edit/<?= $address['ContactInfo']['Contact_ID'] ?>">Update address</a>
			&nbsp;
			<a class="alert2" onClick="return confirm('Are you sure you want to delete this address?');" href="/checkout/<?=$type?>_delete/<?= $address['ContactInfo']['Contact_ID'] ?>">Delete address</a>
		</div>
	</td>
	</tr>
	<? $i++; } ?>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left" colspan=2> <a href="/checkout/<?=$type?>_edit">Add new address</a> </td>
	</tr>
	</table>
	<br/>
	<? 
	if($type == 'shipping' && isset($addresses)) { #list page
	?>
	<br/>
		<input type="checkbox" name="data[billing_same]" value="1" <?= $shipping_id != '' && $shipping_id == $billing_id ? "checked='checked'" : "" ?> />Use same address for billing
	<? } ?>

	<div class="center">
		<input type="image" src="/images/buttons/Next.gif" onClick="showPleaseWait();"/>
	</div>

	<?= $this->element("cart/cart",array('checkout'=>1,'read_only_summary'=>1)); ?>

</form>

<div>
</div>

</div>
