<div class="staticPages form">
<?php echo $form->create('StaticPage');?>
	<fieldset>
 		<legend><?php __('Edit StaticPage');?></legend>
	<?php
		echo $form->input('static_page_id');
		echo $form->input('page_name');
		echo $form->input('folder_id', array('options'=>$folder_options));
		echo $form->input('page_title');
		echo $form->input('body_title');
		echo $form->input('meta_desc');
		echo $form->input('meta_keywords');
		echo $form->input('full_width');
		echo $form->input('content');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('StaticPage.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('StaticPage.id'))); ?></li>
		<li><?php echo $html->link(__('List StaticPages', true), array('action'=>'index'));?></li>
	</ul>
</div>
