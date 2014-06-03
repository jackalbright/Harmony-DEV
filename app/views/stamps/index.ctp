<div class="stamps index">
<h2><?php __('Stamps');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('stampID');?></th>
	<th><?php echo $paginator->sort('catalog_number');?></th>
	<th><?php echo $paginator->sort('face_value');?></th>
	<th><?php echo $paginator->sort('issue_date');?></th>
	<th><?php echo $paginator->sort('series');?></th>
	<th><?php echo $paginator->sort('stamp_name');?></th>
	<th><?php echo $paginator->sort('long_description');?></th>
	<th><?php echo $paginator->sort('short_description');?></th>
	<th><?php echo $paginator->sort('keywords');?></th>
	<th><?php echo $paginator->sort('HTML_Keywords');?></th>
	<th><?php echo $paginator->sort('image_location');?></th>
	<th><?php echo $paginator->sort('available');?></th>
	<th><?php echo $paginator->sort('thumbnail_location');?></th>
	<th><?php echo $paginator->sort('country');?></th>
	<th><?php echo $paginator->sort('trivia');?></th>
	<th><?php echo $paginator->sort('filedUnder');?></th>
	<th><?php echo $paginator->sort('notes');?></th>
	<th><?php echo $paginator->sort('reproducible');?></th>
	<th><?php echo $paginator->sort('entry_date');?></th>
	<th><?php echo $paginator->sort('old_catalog_number');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($stamps as $stamp):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $stamp['Stamp']['stampID']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['catalog_number']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['face_value']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['issue_date']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['series']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['stamp_name']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['long_description']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['short_description']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['keywords']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['HTML_Keywords']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['image_location']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['available']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['thumbnail_location']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['country']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['trivia']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['filedUnder']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['notes']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['reproducible']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['entry_date']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['old_catalog_number']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $stamp['Stamp']['stampID'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $stamp['Stamp']['stampID'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $stamp['Stamp']['stampID']), null, sprintf(__('Are you sure you want to delete # %s?', true), $stamp['Stamp']['stampID'])); ?>
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
		<li><?php echo $html->link(__('New Stamp', true), array('action' => 'add')); ?></li>
	</ul>
</div>
