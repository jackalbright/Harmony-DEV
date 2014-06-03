<div class="customerRatings index">
<h2><?php __('CustomerRatings');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('customer_rating_id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('organization');?></th>
	<th><?php echo $paginator->sort('email');?></th>
	<th><?php echo $paginator->sort('product_rating');?></th>
	<th><?php echo $paginator->sort('service_rating');?></th>
	<th><?php echo $paginator->sort('customer_type_id');?></th>
	<th><?php echo $paginator->sort('permission');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($customerRatings as $customerRating):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $customerRating['CustomerRating']['customer_rating_id']; ?>
		</td>
		<td>
			<?php echo $customerRating['CustomerRating']['name']; ?>
		</td>
		<td>
			<?php echo $customerRating['CustomerRating']['organization']; ?>
		</td>
		<td>
			<?php echo $customerRating['CustomerRating']['email']; ?>
		</td>
		<td>
			<?php echo $customerRating['CustomerRating']['product_rating']; ?>
		</td>
		<td>
			<?php echo $customerRating['CustomerRating']['service_rating']; ?>
		</td>
		<td>
			<?php echo $customerRating['CustomerRating']['customer_type_id']; ?>
		</td>
		<td>
			<?php echo $customerRating['CustomerRating']['permission']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $customerRating['CustomerRating']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $customerRating['CustomerRating']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $customerRating['CustomerRating']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $customerRating['CustomerRating']['id'])); ?>
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
		<li><?php echo $html->link(__('New CustomerRating', true), array('action'=>'add')); ?></li>
	</ul>
</div>
