<div class="customer form">
<?php echo $form->create('Customer');?>
	<fieldset>
 		<legend><?php __('Edit Customer');?></legend>
	<?php
		echo $form->input('First_Name');
		echo $form->input('Last_Name');
		echo $form->input('eMail_Address');
		echo $form->input('Username');
		echo $form->input('Password');
		echo $form->input('Password_Question');
		echo $form->input('Password_Answer');
		echo $form->input('Company');
		echo $form->input('Phone');
		echo $form->input('Mail_List');
		echo $form->input('customer_id');
		echo $form->input('billing_id_pref');
		echo $form->input('shipping_id_pref');
		echo $form->input('testAccount');
		echo $form->input('dateAdded');
		echo $form->input('idHash');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Customer.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Customer.id'))); ?></li>
		<li><?php echo $html->link(__('List Customer', true), array('action'=>'index'));?></li>
	</ul>
</div>
