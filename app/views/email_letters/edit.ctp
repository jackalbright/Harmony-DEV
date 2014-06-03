<div class="emailLetters form">
<?php echo $form->create('EmailLetter');?>
	<fieldset>
 		<legend><?php __('Edit EmailLetter');?></legend>
	<?php
		echo $form->input('email_letter_id');
		echo $form->input('letter_name');
		echo $form->input('email_template_id');
		echo $form->input('subject');
		echo $form->input('catalog_number');
		echo $form->input('image_id');
		echo $form->input('customQuote');
		echo $form->input('personalizationInput');
		echo $form->input('border_id');
		echo $form->input('charm_id');
		echo $form->input('tassel_id');
		echo $form->input('ribbon_id');
		echo $form->input('layout');
		echo $form->input('custom_message');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('EmailLetter.email_letter_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('EmailLetter.email_letter_id'))); ?></li>
		<li><?php echo $html->link(__('List EmailLetters', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Email Templates', true), array('controller'=> 'email_templates', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Email Template', true), array('controller'=> 'email_templates', 'action'=>'add')); ?> </li>
	</ul>
</div>
