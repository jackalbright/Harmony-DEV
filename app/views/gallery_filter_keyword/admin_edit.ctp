<div class="galleryFilterKeyword form">
<?php echo $form->create('GalleryFilterKeyword');?>
	<fieldset>
 		<legend><?php __('Edit GalleryFilterKeyword');?></legend>
	<?php
		echo $form->input('filter_id');
		echo $form->input('path');
		echo $form->input('name');
		echo $form->input('parent_url');
		echo $form->input('parent_title');
		echo $form->input('description');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('GalleryFilterKeyword.filter_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('GalleryFilterKeyword.filter_id'))); ?></li>
		<li><?php echo $html->link(__('List GalleryFilterKeyword', true), array('action'=>'index'));?></li>
	</ul>
</div>
