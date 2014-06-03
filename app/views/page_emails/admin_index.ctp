<div class="pageEmails index">
<h2><?php __('PageEmails');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('your_name');?></th>
	<th><?php echo $paginator->sort('recipient');?></th>
	<th><?php echo $paginator->sort('subject');?></th>
	<th><?php echo $paginator->sort('url');?></th>
	<th><?php echo $paginator->sort('custom_message');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($pageEmails as $pageEmail):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $pageEmail['PageEmail']['id']; ?>
		</td>
		<td>
			<?php echo $pageEmail['PageEmail']['your_name']; ?>
		</td>
		<td>
			<?php echo $pageEmail['PageEmail']['recipient']; ?>
		</td>
		<td>
			<?php echo $pageEmail['PageEmail']['subject']; ?>
		</td>
		<td>
			<?php echo $pageEmail['PageEmail']['url']; ?>
		</td>
		<td>
			<?php echo $pageEmail['PageEmail']['custom_message']; ?>
		</td>
		<td>
			<?php echo $pageEmail['PageEmail']['created']; ?>
		</td>
		<td>
			<?php echo $pageEmail['PageEmail']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $pageEmail['PageEmail']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $pageEmail['PageEmail']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $pageEmail['PageEmail']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $pageEmail['PageEmail']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New PageEmail', true), array('action' => 'add')); ?></li>
	</ul>
</div>
