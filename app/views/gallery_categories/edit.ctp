<div class="galleryCategory form">
<?php echo $form->create('GalleryCategory');?>
	<fieldset>
 		<legend><?php __('Edit GalleryCategory');?></legend>
	<?php
		echo $form->input('browse_node_id');
		echo $form->input('browse_name');
		echo $form->input('parent_node');
		echo $form->input('GalleryImage');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('GalleryCategory.browse_node_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('GalleryCategory.browse_node_id'))); ?></li>
		<li><?php echo $html->link(__('List GalleryCategory', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Gallery Categories', true), array('controller'=> 'gallery_categories', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Parent Category', true), array('controller'=> 'gallery_categories', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Gallery Images', true), array('controller'=> 'gallery_images', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Gallery Image', true), array('controller'=> 'gallery_images', 'action'=>'add')); ?> </li>
	</ul>
</div>
