<div class="trackingRequests index">
<h2><?php __('TrackingRequests');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('tracking_request_id');?></th>
	<th><?php echo $paginator->sort('customer_id');?></th>
	<th><?php echo $paginator->sort('session_id');?></th>
	<th><?php echo $paginator->sort('address');?></th>
	<th><?php echo $paginator->sort('internal');?></th>
	<th><?php echo $paginator->sort('browser');?></th>
	<th><?php echo $paginator->sort('date');?></th>
	<th><?php echo $paginator->sort('complete_url');?></th>
	<th><?php echo $paginator->sort('url');?></th>
	<th><?php echo $paginator->sort('query_string');?></th>
	<th><?php echo $paginator->sort('referer');?></th>
	<th><?php echo $paginator->sort('referer_query_string');?></th>
	<th><?php echo $paginator->sort('complete_referer');?></th>
	<th><?php echo $paginator->sort('is_bot');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($trackingRequests as $trackingRequest):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $trackingRequest['TrackingRequest']['tracking_request_id']; ?>
		</td>
		<td>
			<?php echo $trackingRequest['TrackingRequest']['customer_id']; ?>
		</td>
		<td>
			<?php echo $trackingRequest['TrackingRequest']['session_id']; ?>
		</td>
		<td>
			<?php echo $trackingRequest['TrackingRequest']['address']; ?>
		</td>
		<td>
			<?php echo $trackingRequest['TrackingRequest']['internal']; ?>
		</td>
		<td>
			<?php echo $trackingRequest['TrackingRequest']['browser']; ?>
		</td>
		<td>
			<?php echo $trackingRequest['TrackingRequest']['date']; ?>
		</td>
		<td>
			<?php echo $trackingRequest['TrackingRequest']['complete_url']; ?>
		</td>
		<td>
			<?php echo $trackingRequest['TrackingRequest']['url']; ?>
		</td>
		<td>
			<?php echo $trackingRequest['TrackingRequest']['query_string']; ?>
		</td>
		<td>
			<?php echo $trackingRequest['TrackingRequest']['referer']; ?>
		</td>
		<td>
			<?php echo $trackingRequest['TrackingRequest']['referer_query_string']; ?>
		</td>
		<td>
			<?php echo $trackingRequest['TrackingRequest']['complete_referer']; ?>
		</td>
		<td>
			<?php echo $trackingRequest['TrackingRequest']['is_bot']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $trackingRequest['TrackingRequest']['tracking_request_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $trackingRequest['TrackingRequest']['tracking_request_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $trackingRequest['TrackingRequest']['tracking_request_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $trackingRequest['TrackingRequest']['tracking_request_id'])); ?>
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
		<li><?php echo $html->link(__('New TrackingRequest', true), array('action'=>'add')); ?></li>
	</ul>
</div>
