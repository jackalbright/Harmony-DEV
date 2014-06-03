<div class="form" style="width: 600px;">
	<div class="bold">
		<?= $this->Html->link("< My Account", "/account"); ?> |
		<?= $this->Html->link("My Addresses", "/account/address_select"); ?>
	</div>

	<br/>

<?= $form->create("ContactInfo", array('url'=>$url, 'onSubmit'=>'return verifyRequiredFields();', 'id'=>'ContactInfoForm','onSubmit'=>'return verifyRequiredFields(this);')); ?>
<div class="grey_header_top"><span></span></div>
<table class="form greybg" style="width: 100%;">
<tr>
<td valign="top">
	<?  $url = "/account/address_edit"; ?>
	
	
	<?= $form->hidden("Contact_ID"); ?>
	<?= $form->input("ContactInfo.Name.0", array('label'=>'First Name','type'=>'text','size'=>15,'class'=>'required')); ?>
	<?= $form->input("ContactInfo.Name.1", array('label'=>'Last Name','type'=>'text','size'=>15,'class'=>'required')); ?>
	<?= $form->input("Company", array('label'=>'Company (optional)','type'=>'text','size'=>15)); ?>
	<?= $form->input("Address_1", array('label'=>'Address','size'=>15,'class'=>'required')); ?>
	<?= $form->input("Address_2", array('label'=>false,'size'=>15)); ?>
	<?= $form->input("is_po_box", array('label'=>'This is a PO Box (cannot ship via FedEx)')); ?>
</td>
<td valign="top">
	<?= $form->input("City", array('size'=>15,'class'=>'required')); ?>
	<?= $form->input("State", array('size'=>4,'class'=>'required')); ?>
	<?= $form->input("Zip_Code", array('size'=>6,'class'=>'required')); ?>
	<?
			$countries_map = array();
			foreach($countries as $country)
			{
				$countries_map[$country['Country']['iso_code']] = $country['Country']['name'];
			}
			asort($countries_map);
	?>
	<?= $form->input("Country", array('options'=>$countries_map,'style'=>'width: 250px;','default'=>'US')); ?>
</td>
</tr></table>
	<div class="grey_header_bottom"><span></span></div>


	<div class="center">
		<input type="image" src="/images/buttons/Save-grey.gif"/>
	</div>

</form>

</div>
