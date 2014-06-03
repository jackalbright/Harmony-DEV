<?
$address_id = !empty($address['ContactInfo']['Contact_ID']) ? $address["ContactInfo"]['Contact_ID'] : null;
if(empty($address_id))
{
	echo $this->element("../checkout/form_address_edit",array('address_type'=>$address_type)); 
} else { 
?>
<div class="form_address_view">
<?
$modelClass = Inflector::classify("{$address_type}_address");
$other_address_type = ($address_type == 'shipping') ? 'billing' : 'shipping';
$otherModelClass = Inflector::classify("{$other_address_type}_address");
?>
<div>

<?= $form->hidden("$modelClass.Contact_ID",array('value'=>$address_id)); ?>
<p><?= !empty($address['ContactInfo']['Company']) ? $address['ContactInfo']['Company'] : null ?>
<? if(!empty($address['ContactInfo']['In_Care_Of'])) { ?>
<p><?= $address['ContactInfo']['In_Care_Of'] ?>
<? } else if (!empty($address['ContactInfo']['Name'])) { ?>
<p><?= join(" ", $address['ContactInfo']['Name']); ?>
<? } ?>
<p><?= !empty($address['ContactInfo']['Address_1']) ? $address['ContactInfo']['Address_1'] : null ?> <?= !empty($address['ContactInfo']['Address_2']) ? $address['ContactInfo']['Address_2'] : null ?>
<p><?= !empty($address['ContactInfo']['City']) ? $address['ContactInfo']['City'] : null ?>, <?= !empty($address['ContactInfo']['State']) ? $address['ContactInfo']['State'] : null ?> <?= !empty($address['ContactInfo']['Zip_Code']) ? $address['ContactInfo']['Zip_Code'] : null ?> 
<p><?= !empty($address['ContactInfo']['Country']) ? $address['ContactInfo']['Country'] : null ?>

<?= $form->hidden("$modelClass.ZipCode", array('value'=>$address['ContactInfo']['Zip_Code'])); ?>
<?= $form->hidden("$modelClass.Country", array('value'=>$address['ContactInfo']['Country'])); ?>

<br/>
<br/>

<?= $ajax->link("Change/Add new address", array('action'=>'form_address_select',$address_type), array('update'=>"{$address_type}_info")); ?>

</div>
<? if($address_type == 'shipping') { ?>
<script>
j(document).ready(function() {
	loadShipping();
	<? if(!empty($edited)) { ?>
		refreshAddress('<?= $other_address_type ?>','<?= $address_id ?>');
	<? } ?>
	if(j('#ShippingAddressContactID').size()) { j('#billingSame').show(); } else { j('#billingSame').hide(); } // hide 'same' if shipping not selected yet. (ie at list page)
});
</script>
<? } ?>
</div>
<? } ?>
