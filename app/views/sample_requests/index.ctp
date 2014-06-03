<div class="sampleRequests index">
<h2><?php __('SampleRequests');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('product_type_id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('organization');?></th>
	<th><?php echo $paginator->sort('address_1');?></th>
	<th><?php echo $paginator->sort('address_2');?></th>
	<th><?php echo $paginator->sort('city');?></th>
	<th><?php echo $paginator->sort('state');?></th>
	<th><?php echo $paginator->sort('zip_code');?></th>
	<th><?php echo $paginator->sort('email');?></th>
	<th><?php echo $paginator->sort('phone');?></th>
	<th><?php echo $paginator->sort('comments');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($sampleRequests as $sampleRequest):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $sampleRequest['SampleRequest']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($sampleRequest['Product']['name'], array('controller' => 'products', 'action' => 'view', $sampleRequest['Product']['product_type_id'])); ?>
		</td>
		<td>
			<?php echo $sampleRequest['SampleRequest']['name']; ?>
		</td>
		<td>
			<?php echo $sampleRequest['SampleRequest']['organization']; ?>
		</td>
		<td>
			<?php echo $sampleRequest['SampleRequest']['address_1']; ?>
		</td>
		<td>
			<?php echo $sampleRequest['SampleRequest']['address_2']; ?>
		</td>
		<td>
			<?php echo $sampleRequest['SampleRequest']['city']; ?>
		</td>
		<td>
			<?php echo $sampleRequest['SampleRequest']['state']; ?>
		</td>
		<td>
			<?php echo $sampleRequest['SampleRequest']['zip_code']; ?>
		</td>
		<td>
			<?php echo $sampleRequest['SampleRequest']['email']; ?>
		</td>
		<td>
			<?php echo $sampleRequest['SampleRequest']['phone']; ?>
		</td>
		<td>
			<?php echo $sampleRequest['SampleRequest']['comments']; ?>
		</td>
		<td>
			<?php echo $sampleRequest['SampleRequest']['created']; ?>
		</td>
		<td>
			<?php echo $sampleRequest['SampleRequest']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $sampleRequest['SampleRequest']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $sampleRequest['SampleRequest']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $sampleRequest['SampleRequest']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $sampleRequest['SampleRequest']['id'])); ?>
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
		<li><?php echo $html->link(__('New SampleRequest', true), array('action' => 'add')); ?></li>
		<li><?php echo $html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>
