<div class="customer form">
<?php echo $form->create('Customer',array('url'=>"/admin/account/edit")); ?>
	<fieldset>
 		<legend><?php __(!empty($this->data['Customer']['is_wholesale']) ? 'Edit Wholesale Customer' : 'Edit Customer');?></legend>
	<?php
		echo $form->input('customer_id');
		echo $form->input('First_Name');
		echo $form->input('Last_Name');
		echo $form->input('eMail_Address');
		#echo $form->input('is_admin',array('after'=>'<br/>WARNING: This allows the user to access HD Administrative functions.'));
		#echo $form->input('Username');
		?>
		<? echo $form->input('Password'); ?>
		<? if(empty($this->data['Customer']['Password'])) { ?>
			<div class="alert2">
				This customer's account is disabled and needs a password set. Once it is set, an email will be sent to the customer to sign in.
			</div>
		<? } ?>
		<?
		#echo $form->input('Password_Question');
		#echo $form->input('Password_Answer');
		echo $form->input('Company');
		echo $form->input('is_wholesale',array('label'=>' Enable wholesale account (no free shipping)'));
		echo $form->input('billme');
		echo $form->input('pricing_level',array('after'=>' Pricing Discount '));
		echo $form->input('Phone');
		echo $form->input('guest',array('label'=>'Guest Account (deselect so customer can log in)'));
		echo "<br/><br/><hr/>";
		echo $form->input('is_admin',array('label'=>'Is Harmony Designs administrator (can access orders)','class'=>'warn'));

		#echo $form->input('Mail_List');
		#echo $form->input('customer_id');
		#echo $form->input('billing_id_pref');
		#echo $form->input('shipping_id_pref');
		#echo $form->input('testAccount');
		#echo $form->input('dateAdded');
		#echo $form->input('idHash');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Customer.customer_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Customer.customer_id'))); ?></li>
		<li><?php echo $html->link(__('List Customers', true), array('action'=>'index'));?></li>
	</ul>
</div>
