<div class="templateRequests form">
<?php echo $form->create('TemplateRequest');?>
	<fieldset>
 		<legend><?php __('Add TemplateRequest');?></legend>
	<?php
		echo $form->input('product_id');
		echo $form->input('comments');
		echo $form->input('name');
		echo $form->input('organization');
		echo $form->input('email');
		echo $form->input('phone');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List TemplateRequests', true), array('action' => 'index'));?></li>
	</ul>
</div>
