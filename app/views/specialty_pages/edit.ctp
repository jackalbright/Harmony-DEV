<div class="specialtyPage form">
<?php echo $form->create('SpecialtyPage');?>
	<fieldset>
 		<legend><?php __('Edit SpecialtyPage');?></legend>
	<?php
		echo $form->input('specialty_page_id');
		echo $form->input('page_title');
		echo $form->input('body_title');
		echo $form->input('meta_keywords');
		echo $form->input('meta_desc');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('SpecialtyPage.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('SpecialtyPage.id'))); ?></li>
		<li><?php echo $html->link(__('List SpecialtyPage', true), array('action'=>'index'));?></li>
	</ul>
</div>
