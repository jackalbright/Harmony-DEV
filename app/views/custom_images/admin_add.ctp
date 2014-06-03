<div class="customImage form">
<?php echo $form->create('CustomImage');?>
	<fieldset>
 		<legend><?php __('Add CustomImage');?></legend>
	<?php
		echo $form->input('Image_Location');
		echo $form->input('display_location');
		echo $form->input('thumbnail_location');
		echo $form->input('Approved');
		echo $form->input('approval_notes');
		echo $form->input('Customer_ID');
		echo $form->input('Title');
		echo $form->input('Submission_Date');
		echo $form->input('Approval_Date');
		echo $form->input('format');
		echo $form->input('Notes');
		echo $form->input('Description');
		echo $form->input('Show_Field');
		echo $form->input('send_email');
		echo $form->input('session_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List CustomImage', true), array('action'=>'index'));?></li>
	</ul>
</div>
