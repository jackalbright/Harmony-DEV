<div class="staticPages form">
<?php echo $form->create('StaticPage');?>
	<fieldset>
 		<legend><?php __('Add StaticPage');?></legend>
	<?php
		echo $form->input('static_page_id');
		echo $form->input('page_name');
		echo $form->input('folder_id', array('options'=>$folder_options));
		echo $form->input('page_title');
		echo $form->input('body_title');
		echo $form->input('meta_desc');
		echo $form->input('meta_keywords');
		echo $form->input('full_width');
		echo $form->input('style');
		echo $form->input('content');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List StaticPages', true), array('action'=>'index'));?></li>
	</ul>
</div>
