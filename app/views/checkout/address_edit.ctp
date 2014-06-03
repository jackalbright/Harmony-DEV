<div>

<?
if (empty($type)) { $type = 'shipping'; } # or 'billing'
$url = "/checkout/{$type}_edit";
$current_id = ($type == 'billing') ? $billing_id : $shipping_id;
?>

<?= $form->create("ContactInfo", array('url'=>$url, 'onSubmit'=>'return verifyRequiredFields();', 'id'=>'ContactInfoForm')); ?>
<table width="75%">
<tr>
<td>
	<?= $form->hidden("Contact_ID"); ?>
	<?= $form->input("ContactInfo.Name.0", array('label'=>'First Name','type'=>'text','size'=>15)); ?>
	<?= $form->input("ContactInfo.Name.1", array('label'=>'Last Name','type'=>'text','size'=>15)); ?>
	<?= $form->input("Company", array('label'=>'Company (optional)','type'=>'text','size'=>15)); ?>
	<?= $form->input("Address_1", array('label'=>'Address','size'=>15)); ?>
	<?= $form->input("Address_2", array('label'=>'Address 2','size'=>15)); ?>
	<?= $form->input("is_po_box", array('label'=>'This is a PO Box (cannot ship via FedEx)')); ?>
</td>
<td>
	<?= $form->input("City", array('size'=>15)); ?>
	<?= $form->input("State", array('size'=>4)); ?>
	<?= $form->input("Zip_Code", array('size'=>6)); ?>
	<?
			$countries_map = array();
			foreach($countries as $c)
			{
				$countries_map[$c['Country']['iso_code']] = $c['Country']['name'];
			}
			asort($countries_map);
	?>
	<?= $form->input("Country", array('options'=>$countries_map,'style'=>'width: 250px;','selected'=>(!empty($country)?$country:'US'))); ?>
	<? 
	if($type == 'shipping') { #list page
	?>
		<input type="checkbox" name="data[billing_same]" value="1" <?= $shipping_id != '' && $shipping_id == $billing_id ? "checked='checked'" : "" ?> />Use same address for billing
	<? } ?>

	<div class="center">
		<input type="image" src="/images/buttons/Next.gif" onClick="showPleaseWait();"/>
	</div>
</td>
</tr>
</table>

	<?= $this->element("cart/cart",array('checkout'=>1,'read_only_summary'=>1)); ?>

</form>

<div>
</div>

</div>
