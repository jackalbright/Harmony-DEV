<div class="completedArtImages index">
<h2><?php __('CompletedArtImages');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('product_id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('email');?></th>
	<th><?php echo $paginator->sort('phone');?></th>
	<th><?php echo $paginator->sort('organization');?></th>
	<th><?php echo $paginator->sort('comments');?></th>
	<th><?php echo $paginator->sort('original_path');?></th>
	<th><?php echo $paginator->sort('display_path');?></th>
	<th><?php echo $paginator->sort('thumb_path');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($completedArtImages as $completedArtImage):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $completedArtImage['CompletedArtImage']['id']; ?>
		</td>
		<td>
			<?php echo $completedArtImage['CompletedArtImage']['product_id']; ?>
		</td>
		<td>
			<?php echo $completedArtImage['CompletedArtImage']['name']; ?>
		</td>
		<td>
			<?php echo $completedArtImage['CompletedArtImage']['email']; ?>
		</td>
		<td>
			<?php echo $completedArtImage['CompletedArtImage']['phone']; ?>
		</td>
		<td>
			<?php echo $completedArtImage['CompletedArtImage']['organization']; ?>
		</td>
		<td>
			<?php echo $completedArtImage['CompletedArtImage']['comments']; ?>
		</td>
		<td>
			<?php echo $completedArtImage['CompletedArtImage']['original_path']; ?>
		</td>
		<td>
			<?php echo $completedArtImage['CompletedArtImage']['display_path']; ?>
		</td>
		<td>
			<?php echo $completedArtImage['CompletedArtImage']['thumb_path']; ?>
		</td>
		<td>
			<?php echo $completedArtImage['CompletedArtImage']['created']; ?>
		</td>
		<td>
			<?php echo $completedArtImage['CompletedArtImage']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $completedArtImage['CompletedArtImage']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $completedArtImage['CompletedArtImage']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $completedArtImage['CompletedArtImage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $completedArtImage['CompletedArtImage']['id'])); ?>
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
		<li><?php echo $html->link(__('New CompletedArtImage', true), array('action' => 'add')); ?></li>
	</ul>
</div>
