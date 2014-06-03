<div class="galleryImage form">
<?php echo $form->create('GalleryImage');?>
	<fieldset>
 		<legend><?php __('Edit GalleryImage');?></legend>
	<?php
		echo $form->input('stampID');
		echo $form->input('catalog_number');
		echo $form->input('face_value');
		echo $form->input('issue_date');
		echo $form->input('series');
		echo $form->input('stamp_name');
		echo $form->input('long_description');
		echo $form->input('short_description');
		echo $form->input('keywords');
		echo $form->input('HTML_Keywords');
		echo $form->input('image_location');
		echo $form->input('available');
		echo $form->input('thumbnail_location');
		echo $form->input('country');
		echo $form->input('trivia');
		echo $form->input('filedUnder');
		echo $form->input('notes');
		echo $form->input('reproducible');
		echo $form->input('entry_date');
		echo $form->input('GalleryCategories');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('GalleryImage.stampID')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('GalleryImage.stampID'))); ?></li>
		<li><?php echo $html->link(__('List GalleryImage', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Gallery Categories', true), array('controller'=> 'gallery_categories', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Gallery Categories', true), array('controller'=> 'gallery_categories', 'action'=>'add')); ?> </li>
	</ul>
</div>
