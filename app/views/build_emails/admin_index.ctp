<div class="buildEmails index">
<h2><?php __('BuildEmails');?></h2>
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
	<th><?php echo $paginator->sort('custom_message');?></th>
	<th><?php echo $paginator->sort('build_data');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($buildEmails as $buildEmail):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $buildEmail['BuildEmail']['id']; ?>
		</td>
		<td>
			<?php echo $buildEmail['BuildEmail']['your_name']; ?>
		</td>
		<td>
			<?php echo $buildEmail['BuildEmail']['recipient']; ?>
		</td>
		<td>
			<?php echo $buildEmail['BuildEmail']['subject']; ?>
		</td>
		<td>
			<?php echo $buildEmail['BuildEmail']['custom_message']; ?>
		</td>
		<td>
			<?php echo $buildEmail['BuildEmail']['build_data']; ?>
		</td>
		<td>
			<?php echo $buildEmail['BuildEmail']['created']; ?>
		</td>
		<td>
			<?php echo $buildEmail['BuildEmail']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $buildEmail['BuildEmail']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $buildEmail['BuildEmail']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $buildEmail['BuildEmail']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $buildEmail['BuildEmail']['id'])); ?>
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
		<li><?php echo $html->link(__('New BuildEmail', true), array('action' => 'add')); ?></li>
	</ul>
</div>
