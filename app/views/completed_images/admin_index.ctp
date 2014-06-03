<div class="completedImages index">
	<h2><?php __('Completed Images');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('first_name');?></th>
			<th><?php echo $this->Paginator->sort('last_name');?></th>
			<th><?php echo $this->Paginator->sort('email');?></th>
			<th><?php echo $this->Paginator->sort('phone');?></th>
			<th><?php echo $this->Paginator->sort('zip_code');?></th>
			<th><?php echo $this->Paginator->sort('company');?></th>
			<th><?php echo $this->Paginator->sort('product_type_id');?></th>
			<th><?php echo $this->Paginator->sort('quantity');?></th>
			<th><?php echo $this->Paginator->sort('proof');?></th>
			<th><?php echo $this->Paginator->sort('needed_by');?></th>
			<th><?php echo $this->Paginator->sort('needed_by_strict');?></th>
			<th><?php echo $this->Paginator->sort('comments');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($completedImages as $completedImage):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $completedImage['CompletedImage']['id']; ?>&nbsp;</td>
		<td><?php echo $completedImage['CompletedImage']['first_name']; ?>&nbsp;</td>
		<td><?php echo $completedImage['CompletedImage']['last_name']; ?>&nbsp;</td>
		<td><?php echo $completedImage['CompletedImage']['email']; ?>&nbsp;</td>
		<td><?php echo $completedImage['CompletedImage']['phone']; ?>&nbsp;</td>
		<td><?php echo $completedImage['CompletedImage']['zip_code']; ?>&nbsp;</td>
		<td><?php echo $completedImage['CompletedImage']['company']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($completedImage['Product']['name'], array('controller' => 'products', 'action' => 'view', $completedImage['Product']['product_type_id'])); ?>
		</td>
		<td><?php echo $completedImage['CompletedImage']['quantity']; ?>&nbsp;</td>
		<td>
		<?
			$proof_options = array(
				'consult'=>'Free Consultation',
				'proof_only'=>'$25 Proof',
				'proof_order'=>'Proof WITH Order',
			);
			echo $proof_options[$completedImage['CompletedImage']['proof']];
		?>
			&nbsp;
		</td>
		<td><?php echo $completedImage['CompletedImage']['needed_by']; ?>&nbsp;</td>
		<td><?php echo $completedImage['CompletedImage']['needed_by_strict']; ?>&nbsp;</td>
		<td><?php echo $completedImage['CompletedImage']['comments']; ?>&nbsp;</td>
		<td><?php echo $completedImage['CompletedImage']['created']; ?>&nbsp;</td>
		<td><?php echo $completedImage['CompletedImage']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $completedImage['CompletedImage']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $completedImage['CompletedImage']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $completedImage['CompletedImage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $completedImage['CompletedImage']['id'])); ?>
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
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Completed Image', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>
