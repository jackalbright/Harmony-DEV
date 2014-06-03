<div class="specialtyPageProspects index">
<h2><?php __('SpecialtyPageProspects');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('specialty_page_prospects_id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('organization');?></th>
	<th><?php echo $paginator->sort('email');?></th>
	<th><?php echo $paginator->sort('phone');?></th>
	<th><?php echo $paginator->sort('address1');?></th>
	<th><?php echo $paginator->sort('address2');?></th>
	<th><?php echo $paginator->sort('city');?></th>
	<th><?php echo $paginator->sort('state');?></th>
	<th><?php echo $paginator->sort('zipcode');?></th>
	<th><?php echo $paginator->sort('sample1');?></th>
	<th><?php echo $paginator->sort('sample2');?></th>
	<th><?php echo $paginator->sort('sample3');?></th>
	<th><?php echo $paginator->sort('project_details');?></th>
	<th><?php echo $paginator->sort('want_quote');?></th>
	<th><?php echo $paginator->sort('want_catalog');?></th>
	<th><?php echo $paginator->sort('want_consultation');?></th>
	<th><?php echo $paginator->sort('want_sample');?></th>
	<th><?php echo $paginator->sort('specialty_page_id');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($specialtyPageProspects as $specialtyPageProspect):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['name']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['organization']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['email']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['phone']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['address1']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['address2']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['city']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['state']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['zipcode']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['sample1']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['sample2']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['sample3']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['project_details']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['want_quote']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['want_catalog']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['want_consultation']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['want_sample']; ?>
		</td>
		<td>
			<?php echo $html->link($specialtyPageProspect['SpecialtyPage']['specialty_page_id'], array('controller'=> 'specialty_pages', 'action'=>'view', $specialtyPageProspect['SpecialtyPage']['specialty_page_id'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id'])); ?>
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
		<li><?php echo $html->link(__('New SpecialtyPageProspect', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Specialty Pages', true), array('controller'=> 'specialty_pages', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Specialty Page', true), array('controller'=> 'specialty_pages', 'action'=>'add')); ?> </li>
	</ul>
</div>
