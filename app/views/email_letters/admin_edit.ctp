<div class="emailLetters form">
<?php echo $form->create('EmailLetter');?>
	<fieldset>
 		<legend><?php __('Edit EmailLetter');?></legend>
		<table width="100%" border=1>
		<tr>
		<td valign="top">
			<?= $form->input('email_letter_id'); ?>
			<?= $form->input('letter_name'); ?>
			<?= $form->input('email_template_id'); ?>
		</td>
		<td valign="top">
			<?= $form->input('catalog_number'); ?>
			<?= $form->input('image_id'); ?>
			<?= $form->input('template',array('label'=>'Layout','options'=>array('standard'=>'standard','imageonly'=>'imageonly','fullbleed'=>'fullbleed'))); ?>
			<?= $form->input('customQuote',array('class'=>'no_editor')); ?>
			<?= $form->input('personalizationInput'); ?>
		</td>
		<td valign="top">
			<?= $form->input('ribbon_id',array('default'=>16)); ?>
			<?= $form->input('tassel_id',array('default'=>41)); ?>
			<?= $form->input('charm_id',array('default'=>157)); ?>
			<?= $form->input('border_id',array('default'=>2)); ?>
		</td>
		<td valign="top">
			<?= $form->input('subject',array('style'=>'width: 98%;')); ?>
			<?= $form->input('custom_message'); ?>
		</td>
		</tr>
		</table>

	</fieldset>
<?php echo $form->end('Save');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List EmailLetters', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Email Templates', true), array('controller'=> 'email_templates', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Email Template', true), array('controller'=> 'email_templates', 'action'=>'add')); ?> </li>
	</ul>
</div>
