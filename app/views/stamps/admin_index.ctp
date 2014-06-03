<div class="stamps index">
<h2><?php __('Stamps');?></h2>
<div align="right" class="">
		<?php echo $html->link(__('New Stamp', true), array('action' => 'edit')); ?></li>
</div>
<p>
	<div class="right">
	<?= $form->create("Stamp", array('url'=>$this->here)); ?>
	<table><tr>
		<td>
			<?= $form->input("keyword",array('label'=>'catalog number, name, keyword')); ?>
		</td>
		<td><?= $form->submit('Search'); ?></td>
		<td>
			<?= $html->link("View all", array('action'=>'index')); ?>
		</td>
	</tr></table>
	<?= $form->end(); ?>
	</div>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('catalog_number');?></th>
	<th><?php echo $paginator->sort('thumbnail_location');?></th>
	<th><?php echo $paginator->sort('stamp_name');?></th>
	<th><?php echo $paginator->sort('issue_date');?></th>
	<th><?php echo $paginator->sort('series');?></th>
	<th><?php echo $paginator->sort('short_description');?></th>
	<th><?php echo $paginator->sort('keywords');?></th>
	<th><?php echo $paginator->sort('available');?></th>
	<th><?php echo $paginator->sort('reproducible');?></th>
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
			<?php echo $stamp['Stamp']['catalog_number']; ?>
		</td>
		<td>
			<a href="/admin/stamps/edit/<?= $stamp['Stamp']['stampID'] ?>">
				<img  style="background-color: black; border: solid black 5px !important;" src="<?php echo $stamp['Stamp']['thumbnail_location']; ?>"/>
			</a>
		</td>
		<td>
			<a href="/admin/stamps/edit/<?= $stamp['Stamp']['stampID'] ?>">
			<?php echo $stamp['Stamp']['stamp_name']; ?>
			</a>
		</td>
		<td>
			<?php echo $stamp['Stamp']['issue_date']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['series']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['short_description']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['keywords']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['available']; ?>
		</td>
		<td>
			<?php echo $stamp['Stamp']['reproducible']; ?>
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
