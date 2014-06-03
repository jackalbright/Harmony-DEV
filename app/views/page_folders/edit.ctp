<div class="pageFolders form">
<?php echo $form->create('PageFolder');?>
	<fieldset>
 		<legend><?php __('Edit PageFolder');?></legend>
	<?php
		echo $form->input('folder_id');
		echo $form->input('folder_url');
		echo $form->input('folder_name');
		echo $form->input('parent_folder_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('PageFolder.folder_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('PageFolder.folder_id'))); ?></li>
		<li><?php echo $html->link(__('List PageFolders', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Page Folders', true), array('controller'=> 'page_folders', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Parent Folder', true), array('controller'=> 'page_folders', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Static Pages', true), array('controller'=> 'static_pages', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Pages', true), array('controller'=> 'static_pages', 'action'=>'add')); ?> </li>
	</ul>
</div>
