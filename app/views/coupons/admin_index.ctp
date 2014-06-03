<div class="coupons index">
	<h2><?php __('Coupons');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('code');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('percent');?></th>
			<th><?php echo $this->Paginator->sort('amount');?></th>
			<th><?php echo $this->Paginator->sort('minimum');?></th>
			<th><?php echo $this->Paginator->sort('start');?></th>
			<th><?php echo $this->Paginator->sort('end');?></th>
			<th><?php echo $this->Paginator->sort('day_of_week');?></th>
			<th><?php echo $this->Paginator->sort('multiple_use');?></th>
			<th><?php echo $this->Paginator->sort('advertise');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($coupons as $coupon):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $coupon['Coupon']['id']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['code']; ?>&nbsp;</td>
		<td> 
			<?php echo $this->Html->link($coupon['Coupon']['title'], array('action' => 'edit', $coupon['Coupon']['id'])); ?> 
		<? if(!empty($this->data['Coupon']['filename'])) { ?>
			<? $image = $this->Html->image("/".$this->data['Coupon']['path']."/".$this->data['Coupon']['filename'],array('height'=>35)); ?>
			<?= $this->Html->link($image, array('action'=>'edit', $coupon['Coupon']['id'],'title'=>'Click to see special offer details')); ?>
		<? } ?>
		</td>
		<td><?php echo $coupon['Coupon']['percent']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['amount']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['minimum']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['start']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['end']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['day_of_week']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['multiple_use']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['advertise']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['active']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['created']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $coupon['Coupon']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $coupon['Coupon']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $coupon['Coupon']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $coupon['Coupon']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Coupon', true), array('action' => 'add')); ?></li>
	</ul>
</div>
