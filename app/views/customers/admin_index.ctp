<div class="customer index">
<h2><?php __('Customer');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<select onChange="document.location.href = '/admin/customers/index/'+this.value; ">
	<option value="">All Customers</option>
	<option value="myob" <?= !empty($customer_type) && $customer_type == 'myob' ? "selected='selected'" : "" ?> >MYOB Imports</option>
	<option value="wholesale" <?= !empty($customer_type) && $customer_type == 'wholesale' ? "selected='selected'" : "" ?> >Wholesale Customers</option>
</select>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('customer_id');?></th>
	<th><?php echo $paginator->sort('First_Name');?></th>
	<th><?php echo $paginator->sort('Last_Name');?></th>
	<th><?php echo $paginator->sort('eMail_Address');?></th>
	<th><?php echo $paginator->sort('Company');?></th>
	<th><?php echo $paginator->sort('Phone');?></th>
	<th><?php echo $paginator->sort('dateAdded');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
if(!empty($incomplete_customers))
{
	$customers = array_merge($incomplete_customers, $customers);
}
$i = 0;
foreach ($customers as $customer):
?>
	<tr style="background-color: <?= $i++%2==0 ? "#FFF;":"#DDD;"?>">
		<td>
			<?php echo $html->link($customer['Customer']['customer_id'], array('controller'=>'account','action'=>'edit', $customer['Customer']['customer_id'])); ?>
		</td>
		<td>
			<?php echo $customer['Customer']['First_Name']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['Last_Name']; ?>
		</td>
		<td style="<?= empty($customer['Customer']['eMail_Address']) ? "background-color: #FF9999;" :""?>" >
			<?if(!empty($customer['Customer']['eMail_Address'])) { ?>
				<?php echo $customer['Customer']['eMail_Address']; ?>
			<? } else { ?>
				<b>EMAIL INCOMPLETE - REQUIRED FOR ORDERING</b>
			<? } ?>
		</td>
		<td>
			<?php echo $customer['Customer']['Company']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['Phone']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['dateAdded']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $customer['Customer']['customer_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $customer['Customer']['customer_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $customer['Customer']['customer_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $customer['Customer']['customer_id'])); ?>
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
