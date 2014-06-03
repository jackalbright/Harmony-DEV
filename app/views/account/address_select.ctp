<div>
	<div class="bold">
		<?= $this->Html->link("< Back to My Account", "/account"); ?>
	</div>
	<br/>

	<div align="left"> <a href="/account/address_edit">Add new address</a> </div>

	<? if(empty($addresses)) { ?>
		<i>There are no addresses listed on file.</i>
	<? } else { ?>
		<? $i = 0; foreach($addresses as $address) { ?>
		<div style="padding: 10px; width: 250px;">
			<?= !empty($address['ContactInfo']['In_Care_Of']) ? $address['ContactInfo']['In_Care_Of'] : "<i>No name specified</i>" ?><br/>
			<?= $address['ContactInfo']['Address_1'] ?><? if(!empty($address['ContactInfo']['Address_2'])) { ?>
				<?= $address['ContactInfo']['Address_2'] ?>
			<? } ?><br/>
			<?= $address['ContactInfo']['City'] ?>, <?= $address['ContactInfo']['State'] ?> <?= $address['ContactInfo']['Zip_Code'] ?><br/>
			<?= $address['ContactInfo']['Country'] ?>
	
			<div>
			<a href="/account/address_edit/<?= $address['ContactInfo']['Contact_ID'] ?>">Update</a> |
			<a class="alert2" onClick="return confirm('Are you sure you want to delete this address?');" href="/account/address_delete/<?= $address['ContactInfo']['Contact_ID'] ?>">Delete</a>
			</div>
		</div>
		<? } ?>
	<? } ?>
</div>
