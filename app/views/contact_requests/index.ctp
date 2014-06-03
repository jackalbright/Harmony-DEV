<div class="contactRequests index">
	<h2><?php __('Contact Requests');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('phone');?></th>
			<th><?php echo $this->Paginator->sort('email');?></th>
			<th><?php echo $this->Paginator->sort('message');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($contactRequests as $contactRequest):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $contactRequest['ContactRequest']['id']; ?>&nbsp;</td>
		<td><?php echo $contactRequest['ContactRequest']['name']; ?>&nbsp;</td>
		<td><?php echo $contactRequest['ContactRequest']['phone']; ?>&nbsp;</td>
		<td><?php echo $contactRequest['ContactRequest']['email']; ?>&nbsp;</td>
		<td><?php echo $contactRequest['ContactRequest']['message']; ?>&nbsp;</td>
		<td><?php echo $contactRequest['ContactRequest']['created']; ?>&nbsp;</td>
		<td><?php echo $contactRequest['ContactRequest']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $contactRequest['ContactRequest']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $contactRequest['ContactRequest']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $contactRequest['ContactRequest']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contactRequest['ContactRequest']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Contact Request', true), array('action' => 'add')); ?></li>
	</ul>
</div>