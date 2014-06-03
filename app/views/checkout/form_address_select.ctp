<?
$other_address_type = ($address_type == 'shipping') ? 'billing' : 'shipping';
$key = Inflector::classify("{$address_type}_address");
?>
<div class="form_address_select">
<div style="height: 20px;">
<? if($address_type == 'billing') { ?>
<div id="billingSame" style="display:none;">
<input type="checkbox" name="data[billing_same]" value="1" onClick="if(this.checked) { billingSameAsShipping(); }"/> Shipping &amp; billing address are the same
</div>
<? } ?>
</div>
<script>
	if(j('#ShippingAddressContactID').size()) { j('#billingSame').show(); } else { j('#billingSame').hide(); } // hide 'same' if shipping not selected yet. (ie at list page)
</script>
<div class="clear"></div>
<br/>
<?= $ajax->link("Add a new address", array('action'=>"form_address_edit",$address_type), array('update'=>"{$address_type}_info",'class'=>'bold')); ?>
<br/>
<br/>

<? $cols = $address_type == 'shipping' ? 3 : 2; ?>

<table width="100%">
<? $i = 0; foreach($addresses as $add) { ?>
<?= $i++ % $cols == 0 ? "<tr>":""?>
<td valign="top" style="padding-bottom: 15px;">
<? if(count($addresses) == 1) { ?>
<?= $form->hidden("$key.Contact_ID",array('value'=>$add['ContactInfo']['Contact_ID'])); ?>
<? } ?>
<?= $ajax->link("Choose this address", array('action'=>"form_address_view",$address_type,$add['ContactInfo']['Contact_ID']), array('update'=>"{$address_type}_info",'class'=>'bold')); ?> 
<p><?= $add['ContactInfo']['Company'] ?>
<p><?= $add['ContactInfo']['In_Care_Of'] ?>
<p><?= $add['ContactInfo']['Address_1'] ?> <?= $add['ContactInfo']['Address_2'] ?>
<p><?= $add['ContactInfo']['City'] ?>, <?= $add['ContactInfo']['State'] ?> <?= $add['ContactInfo']['Zip_Code'] ?>
<p><?= $add['ContactInfo']['Country'] ?>
<div style="">
	<?= $ajax->link("Edit", array('action'=>"form_address_edit",$address_type,$add['ContactInfo']['Contact_ID']), array('update'=>"{$address_type}_info")); ?> |
	<?= $ajax->link("Delete", array('action'=>"form_address_delete",$address_type,$add['ContactInfo']['Contact_ID']), array('update'=>"{$address_type}_info",'confirm'=>'Are you sure you want to delete this address?')); ?>
</div>
</td>
<?= $i % $cols == 0 || $i == count($addresses) ? "</tr>":""?>
<? } ?>
</table>

<div class="clear"></div>
</div>
<script>
	<? if(!empty($edited)) { ?>
		refreshAddress('<?= $other_address_type ?>');
	<? } ?>
</script>
