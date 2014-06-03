<div class="gallery form">
<?php echo $form->create('GalleryCategory');?>
	<fieldset>
 		<legend><?php __('Edit Gallery');?></legend>
	<?php
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('GalleryCategory.')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('GalleryCategory.'))); ?></li>
		<li><?php echo $html->link(__('List Gallery', true), array('action'=>'index'));?></li>
	</ul>
</div>
