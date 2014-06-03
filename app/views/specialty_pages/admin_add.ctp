<div class="specialtyPage form">
<?php echo $form->create('SpecialtyPage');?>
	<fieldset>
 		<legend><?php __('Add SpecialtyPage');?></legend>
		<table>
	<?php
		echo $form->input('specialty_page_id');
		echo $html->tableCells(array(
			array(
				$form->input('page_title'),
				$form->input('body_title'),
				$form->input('page_url',array('after'=>'<br/>harmonydesigns.com/specialties/NAME')),
			),
			array(
				$form->input('meta_keywords'),
				$form->input('meta_desc'),
			),
		));
	?>
		</table>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List SpecialtyPage', true), array('action'=>'index'));?></li>
	</ul>
</div>
