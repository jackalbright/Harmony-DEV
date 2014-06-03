<div class="stamps form">
<?php echo $form->create('Stamp');?>
	<fieldset>
 		<legend><?php __('Add Stamp');?></legend>
	<?php
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
		echo $form->input('old_catalog_number');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Stamps', true), array('action' => 'index'));?></li>
	</ul>
</div>
