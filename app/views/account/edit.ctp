<div style="width: 400px;" class="customer form">
	<div class="bold">
		<?= $this->Html->link("< Back to My Account", "/account"); ?>
	</div>
	<br/>
<?php echo $form->create("Customer", array('url'=>array('controller'=>'account','action'=>'edit'),'onSubmit'=>'return verifyRequiredFields(this);'));  ?>
<div class="grey_header_top"><span></span></div>
<div class="greybg">
	<?php
		echo $form->input('First_Name',array('class'=>'required'));
		echo $form->input('Last_Name',array('class'=>'required'));
		echo $form->input('eMail_Address',array('class'=>'required'));
		#echo $form->input('Username');
		#echo $form->input('Password');
		#echo $form->input('Password_Question');
		#echo $form->input('Password_Answer');
		echo $form->input('Company',array('label'=>'Organization (optional)'));
		echo $form->input('Phone');
		?><br/><a href="/custserv/addressList.php">Manage Shipping/Billing Addresses</a><br/><br/><?
		echo $form->input('Mail_List',array('type'=>'checkbox','label'=>'Mailing list subscription (optional)','after'=>'<br/>Join our mailing list to be contacted with new promotions, offers, products and additions to our catalog.'));
		#echo $form->input('customer_id');
		#echo $form->input('billing_id_pref');
		#echo $form->input('shipping_id_pref');
		#echo $form->input('testAccount');
		#echo $form->input('dateAdded');
		#echo $form->input('idHash');
	?>
</div>
<div class="grey_header_bottom"><span></span></div>
	<input type="image" src="/images/buttons/Save-grey.gif"/>
</div>
</form>
