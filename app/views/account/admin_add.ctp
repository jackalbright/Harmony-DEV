<div class="customer form">
<?php echo $form->create('Customer');?>
	<fieldset>
 		<legend><?php __('Add Customer');?></legend>
		<table>
		<tr>
			<td valign="top">
				<?= $form->input('First_Name'); ?>
			</td>
			<td valign="top">
				<?= $form->input('Last_Name'); ?>
			</td>
		</tr>
		<tr>
			<td valign="top">
				<?= $form->input('eMail_Address',array('div'=>array('class'=>'required input text'))); ?>
			</td>
			<td valign="top">
				<?= $form->input('Password'); ?>
			</td>
		</tr>
		<tr>
			<td valign="top">
				<?= $form->input('Company'); ?>
				<?= $form->input('billme'); ?>
			</td>
			<td valign="top">
				<?= $form->input('pricing_level',array('value'=>'1','after'=>'<br/>1 = retail, 100 = wholesale')); ?>
				<?= $form->input('is_wholesale'); ?>
			</td>
		</tr>
		</table>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Customers', true), array('action'=>'index'));?></li>
	</ul>
</div>
