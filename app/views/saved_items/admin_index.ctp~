<div class="savedItems index">
<h2><?php __('SavedItems');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('saved_item_id');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('customer_id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('parts');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($savedItems as $savedItem):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $savedItem['SavedItem']['saved_item_id']; ?>
		</td>
		<td>
			<?= $savedItem['SavedItem']['created'] ?>
		</td>
		<td>
			<a href="/admin/tracking_requests/session/<?= $savedItem['Customer']['eMail_Address'] ?>">
			<?php echo $savedItem['SavedItem']['customer_id']; ?>
			<br/>
			<?= $savedItem['Customer']['First_Name'] ?>
			<?= $savedItem['Customer']['Last_Name'] ?>
			</a>
		</td>
		<td>
			<?php echo $savedItem['SavedItem']['name']; ?>
		</td>
		<td style="width: 500px;">
			<? $parts = unserialize($savedItem['SavedItem']['build_data']); 
				$prod = $parts['code'];
				$imgtype = "";
				if (!empty($parts['image_id'])) { $imgtype = 'Custom'; $imgid = $parts['image_id']; }
				if (!empty($parts['catalog_number'])) { $imgtype = 'Gallery'; $imgid = $parts['catalog_number']; }
				if($prod && $imgtype && $imgid)
				{
			?>
			<div class="right">
				<a rel="" href="/images/preview/<?= $prod ?>/<?= $imgtype ?>/<?= $imgid ?>.png">
					<img src="/images/preview/<?= $prod ?>/<?= $imgtype ?>/_<?= $imgid ?>/x150.png"/>
				</a>
			</div>
			<?
				}
			foreach($parts as $part => $value)
			{
				if(empty($value)) { continue; }
				?><?= $part ?>: <?= $value ?><br/>
				<?
			}
			?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $savedItem['SavedItem']['saved_item_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $savedItem['SavedItem']['saved_item_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $savedItem['SavedItem']['saved_item_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $savedItem['SavedItem']['saved_item_id'])); ?>
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
		<li><?php echo $html->link(__('New SavedItem', true), array('action'=>'add')); ?></li>
	</ul>
</div>
