<div class="gallery form">
<?php echo $form->create('GalleryCategory');?>
	<fieldset>
 		<legend><?php __('Add Gallery');?></legend>
	<?php
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Gallery', true), array('action'=>'index'));?></li>
	</ul>
</div>
