<div class="customImage index">
<h2><?php __('CustomImage');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('Image_ID');?></th>
	<th><?php echo $paginator->sort('Image_Location');?></th>
	<th><?php echo $paginator->sort('display_location');?></th>
	<th><?php echo $paginator->sort('thumbnail_location');?></th>
	<th><?php echo $paginator->sort('Approved');?></th>
	<th><?php echo $paginator->sort('approval_notes');?></th>
	<th><?php echo $paginator->sort('Customer_ID');?></th>
	<th><?php echo $paginator->sort('Title');?></th>
	<th><?php echo $paginator->sort('Submission_Date');?></th>
	<th><?php echo $paginator->sort('Approval_Date');?></th>
	<th><?php echo $paginator->sort('format');?></th>
	<th><?php echo $paginator->sort('Notes');?></th>
	<th><?php echo $paginator->sort('Description');?></th>
	<th><?php echo $paginator->sort('Show_Field');?></th>
	<th><?php echo $paginator->sort('send_email');?></th>
	<th><?php echo $paginator->sort('session_id');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($customImage as $customImage):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $customImage['CustomImage']['Image_ID']; ?>
		</td>
		<td>
			<?php echo $customImage['CustomImage']['Image_Location']; ?>
		</td>
		<td>
			<?php echo $customImage['CustomImage']['display_location']; ?>
		</td>
		<td>
			<?php echo $customImage['CustomImage']['thumbnail_location']; ?>
		</td>
		<td>
			<?php echo $customImage['CustomImage']['Approved']; ?>
		</td>
		<td>
			<?php echo $customImage['CustomImage']['approval_notes']; ?>
		</td>
		<td>
			<?php echo $customImage['CustomImage']['Customer_ID']; ?>
		</td>
		<td>
			<?php echo $customImage['CustomImage']['Title']; ?>
		</td>
		<td>
			<?php echo $customImage['CustomImage']['Submission_Date']; ?>
		</td>
		<td>
			<?php echo $customImage['CustomImage']['Approval_Date']; ?>
		</td>
		<td>
			<?php echo $customImage['CustomImage']['format']; ?>
		</td>
		<td>
			<?php echo $customImage['CustomImage']['Notes']; ?>
		</td>
		<td>
			<?php echo $customImage['CustomImage']['Description']; ?>
		</td>
		<td>
			<?php echo $customImage['CustomImage']['Show_Field']; ?>
		</td>
		<td>
			<?php echo $customImage['CustomImage']['send_email']; ?>
		</td>
		<td>
			<?php echo $customImage['CustomImage']['session_id']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $customImage['CustomImage']['Image_ID'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $customImage['CustomImage']['Image_ID'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $customImage['CustomImage']['Image_ID']), null, sprintf(__('Are you sure you want to delete # %s?', true), $customImage['CustomImage']['Image_ID'])); ?>
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
		<li><?php echo $html->link(__('New CustomImage', true), array('action'=>'add')); ?></li>
	</ul>
</div>
