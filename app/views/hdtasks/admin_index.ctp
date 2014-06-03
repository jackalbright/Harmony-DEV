<div class="hdtasks index">
<h2><?php __('Hdtasks');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('hdtask_id');?></th>
	<th><?php echo $paginator->sort('title');?></th>
	<th><?php echo $paginator->sort('summary');?></th>
	<th><?php echo $paginator->sort('priority');?></th>
	<th><?php echo $paginator->sort('status');?></th>
	<th><?php echo $paginator->sort('due_date');?></th>
	<th><?php echo $paginator->sort('expected_completion_date');?></th>
	<th><?php echo $paginator->sort('reference');?></th>
	<th><?php echo $paginator->sort('description');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($hdtasks as $hdtask):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $hdtask['Hdtask']['hdtask_id']; ?>
		</td>
		<td>
			<?php echo $hdtask['Hdtask']['title']; ?>
		</td>
		<td>
			<?php echo $hdtask['Hdtask']['summary']; ?>
		</td>
		<td>
			<?php echo $hdtask['Hdtask']['priority']; ?>
		</td>
		<td>
			<?php echo $hdtask['Hdtask']['status']; ?>
		</td>
		<td>
			<?php echo $hdtask['Hdtask']['due_date']; ?>
		</td>
		<td>
			<?php echo $hdtask['Hdtask']['expected_completion_date']; ?>
		</td>
		<td>
			<?php echo $hdtask['Hdtask']['reference']; ?>
		</td>
		<td>
			<?php echo $hdtask['Hdtask']['description']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $hdtask['Hdtask']['hdtask_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $hdtask['Hdtask']['hdtask_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $hdtask['Hdtask']['hdtask_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $hdtask['Hdtask']['hdtask_id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Hdtask', true), array('action'=>'add')); ?></li>
	</ul>
</div>
