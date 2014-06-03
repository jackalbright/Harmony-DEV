<div class="customer index">
<h2><?php __('Customer');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('First_Name');?></th>
	<th><?php echo $paginator->sort('Last_Name');?></th>
	<th><?php echo $paginator->sort('eMail_Address');?></th>
	<th><?php echo $paginator->sort('Username');?></th>
	<th><?php echo $paginator->sort('Password');?></th>
	<th><?php echo $paginator->sort('Password_Question');?></th>
	<th><?php echo $paginator->sort('Password_Answer');?></th>
	<th><?php echo $paginator->sort('Company');?></th>
	<th><?php echo $paginator->sort('Phone');?></th>
	<th><?php echo $paginator->sort('Mail_List');?></th>
	<th><?php echo $paginator->sort('customer_id');?></th>
	<th><?php echo $paginator->sort('billing_id_pref');?></th>
	<th><?php echo $paginator->sort('shipping_id_pref');?></th>
	<th><?php echo $paginator->sort('testAccount');?></th>
	<th><?php echo $paginator->sort('dateAdded');?></th>
	<th><?php echo $paginator->sort('idHash');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($customer as $customer):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $customer['Customer']['First_Name']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['Last_Name']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['eMail_Address']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['Username']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['Password']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['Password_Question']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['Password_Answer']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['Company']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['Phone']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['Mail_List']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['customer_id']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['billing_id_pref']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['shipping_id_pref']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['testAccount']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['dateAdded']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['idHash']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $customer['Customer']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $customer['Customer']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $customer['Customer']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $customer['Customer']['id'])); ?>
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
		<li><?php echo $html->link(__('New Customer', true), array('action'=>'add')); ?></li>
	</ul>
</div>
