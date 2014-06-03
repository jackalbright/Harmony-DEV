<div class="completedProjects index">
	<h2><?php __('Completed Projects');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('full_name');?></th>
			<th><?php echo $this->Paginator->sort('email');?></th>
			<th><?php echo $this->Paginator->sort('phone');?></th>
			<th><?php echo $this->Paginator->sort('zip_code');?></th>
			<th><?php echo $this->Paginator->sort('company');?></th>
			<th><?php echo $this->Paginator->sort('product_type_id');?></th>
			<th><?php echo $this->Paginator->sort('quantity');?></th>
			<th><?php echo $this->Paginator->sort('needed_by');?></th>
			<th><?php echo $this->Paginator->sort('needed_by_strict');?></th>
			<th><?php echo $this->Paginator->sort('comments');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($completedProjects as $completedProject):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $completedProject['CompletedProject']['id']; ?>&nbsp;</td>
		<td><?php echo $completedProject['CompletedProject']['full_name']; ?>&nbsp;</td>
		<td><?php echo $completedProject['CompletedProject']['email']; ?>&nbsp;</td>
		<td><?php echo $completedProject['CompletedProject']['phone']; ?>&nbsp;</td>
		<td><?php echo $completedProject['CompletedProject']['zip_code']; ?>&nbsp;</td>
		<td><?php echo $completedProject['CompletedProject']['company']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($completedProject['Product']['name'], array('controller' => 'products', 'action' => 'view', $completedProject['Product']['product_type_id'])); ?>
		</td>
		<td><?php echo $completedProject['CompletedProject']['quantity']; ?>&nbsp;</td>
		<td><?php echo $completedProject['CompletedProject']['needed_by']; ?>&nbsp;</td>
		<td><?php echo $completedProject['CompletedProject']['needed_by_strict']; ?>&nbsp;</td>
		<td><?php echo $completedProject['CompletedProject']['comments']; ?>&nbsp;</td>
		<td><?php echo $completedProject['CompletedProject']['created']; ?>&nbsp;</td>
		<td><?php echo $completedProject['CompletedProject']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $completedProject['CompletedProject']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $completedProject['CompletedProject']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $completedProject['CompletedProject']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $completedProject['CompletedProject']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
