<div class="clients form">
<?php echo $form->create('Client',array('type'=>'file'));
		echo $form->input('client_id');
?>
	<fieldset>
 		<legend><?php __('Edit Client');?></legend>
		<table>
		<tr>
			<td>
				<?= $form->input('company'); ?>
				<?= $form->input('name'); ?>
				<?= $form->input('sort_index'); ?>
				<?= $form->input('image',array('type'=>'file')); ?>
				<?= $form->input('SpecialtyPages.SpecialtyPages',array('label'=>__('Specialty Pages',true), 'type'=>'select', 'multiple'=>'checkbox','options'=>$specialtyPages)); ?>
			</td>
			<td>
				<img src="/images/clients/<?= $this->data['Client']['client_id'] ?>.jpg" width="150"/>
			</td>
		</tr>
		<tr>
			<td colspan=2>
				<?= $form->input('comments'); ?>
			</td>
		</tr>
		</table>
	<?php
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Client.client_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Client.client_id'))); ?></li>
		<li><?php echo $html->link(__('List Clients', true), array('action'=>'index'));?></li>
	</ul>
</div>
