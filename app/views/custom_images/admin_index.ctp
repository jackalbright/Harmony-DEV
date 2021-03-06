<div class="customImage index">


<h2><?php __('CustomImage');?></h2>


<!--<p>conditionsText:<?php //echo $conditionsText;?></p>-->
<form action="/admin/custom_images/index" method="POST">
<p><strong>Image_ID:</strong> <input type="text" name="data[searchImage_ID]" value=""><input type="submit" value="Search"></p>
</form>


<? if(empty($all)) { ?><a href="/admin/custom_images/index/all">Show All</a><? } else { ?><a href="/admin/custom_images/index">Show Unapproved</a><? } ?>
	<?
		$paginator->options(array('url' => $this->passedArgs));
	?>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>

<form method="POST">

<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>

<table cellpadding="0" cellspacing="0">
<tr>
	<th>&nbsp;</th>
	<th><?php echo $paginator->sort('Image_ID');?></th>
	<th><?php echo $paginator->sort('Image_Location');?></th>
	<th><?php echo $paginator->sort('Approved');?></th>
	<th><?php echo $paginator->sort('Customer_ID');?></th>
	<th><?php echo $paginator->sort('Title');?></th>
	<th><?php echo $paginator->sort('Submission_Date');?></th>
	<th><?php echo $paginator->sort('Approval_Date');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($customImages as $customImage):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?= $form->checkbox("Image_ID",array('class'=>"image_id", 'value'=>$customImage['CustomImage']['Image_ID'])); ?>
		</td>
		<td>
			<?php echo $customImage['CustomImage']['Image_ID']; ?>
		</td>
		<td>
			<a href="<?php echo $customImage['CustomImage']['Image_Location']; ?>">
			<img width="200" src="<?php echo $customImage['CustomImage']['display_location']; ?>"/>
			</a>
		</td>
		<td>
			<?php echo $customImage['CustomImage']['Approved']; ?>
		</td>
		<td>
			<?php echo $customImage['CustomImage']['Customer_ID']; ?>
			<br/>
			<? if($customImage['Customer']) { ?>
				<a href="/admin/customers/edit/<?= $customImage['CustomImage']['Customer_ID'] ?>">
					<?= $customImage['Customer']['First_Name'] ?> <?= $customImage['Customer']['Last_Name'] ?>
				</a>
			<? } ?>
			<br/>
			<a href="/admin/tracking_requests/session/<?= $customImage['CustomImage']['session_id'] ?>"><?= $customImage['CustomImage']['session_id'] ?></a>
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
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $customImage['CustomImage']['Image_ID'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $customImage['CustomImage']['Image_ID'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $customImage['CustomImage']['Image_ID']), null, sprintf(__('Are you sure you want to delete # %s?', true), $customImage['CustomImage']['Image_ID'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

</form>


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
