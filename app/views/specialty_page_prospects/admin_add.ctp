<div class="specialtyPageProspects form">
<?php echo $form->create('SpecialtyPageProspect');?>
	<fieldset>
 		<legend><?php __('Add SpecialtyPageProspect');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('organization');
		echo $form->input('email');
		echo $form->input('phone');
		echo $form->input('address1');
		echo $form->input('address2');
		echo $form->input('city');
		echo $form->input('state');
		echo $form->input('zipcode');
		echo $form->input('sample1');
		echo $form->input('sample2');
		echo $form->input('sample3');
		echo $form->input('project_details');
		echo $form->input('want_quote');
		echo $form->input('want_catalog');
		echo $form->input('want_consultation');
		echo $form->input('want_sample');
		echo $form->input('specialty_page_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List SpecialtyPageProspects', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Specialty Pages', true), array('controller'=> 'specialty_pages', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Specialty Page', true), array('controller'=> 'specialty_pages', 'action'=>'add')); ?> </li>
	</ul>
</div>
