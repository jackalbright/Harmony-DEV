<div class="charmCategory form">
<?php echo $form->create('CharmCategory');?>
	<fieldset>
 		<legend><?php __('Add CharmCategory');?></legend>
	<?php
		echo $form->input('charm_category_id');
		echo $form->input('category_name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List CharmCategory', true), array('action'=>'index'));?></li>
	</ul>
</div>
