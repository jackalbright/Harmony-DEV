<div class="clients index">
<h2><?php __('Clients');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th>Sort</th>
	<th><?php echo $paginator->sort('client_id');?></th>
	<th><?php echo $paginator->sort('company');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th>Logo</th>
	<th><?php echo $paginator->sort('sort_index');?></th>
	<th><?php echo $paginator->sort('comments');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<tbody id="clients">
<?php
$i = 0;
foreach ($clients as $client):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr id="client_<?= $client['Client']['client_id'] ?>" <?php echo $class;?>>
		<td>
			<img class="sort_handle" src="/images/icons/up-down.png">
		</td>
		<td>
			<?php echo $client['Client']['client_id']; ?>
		</td>
		<td>
			<?php echo $client['Client']['company']; ?>
		</td>
		<td>
			<?php echo $client['Client']['name']; ?>
		</td>
		<td>
			<img src="/images/clients/<?= $client['Client']['client_id'] ?>.jpg" width="150"/>
		</td>
		<td>
			<?php echo $client['Client']['comments']; ?>
		</td>
		<td>
			<?php echo $client['Client']['sort_index']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $client['Client']['client_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $client['Client']['client_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $client['Client']['client_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $client['Client']['client_id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</tbody>

</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Client', true), array('action'=>'add')); ?></li>
	</ul>
</div>


<?= $ajax->sortable("clients", array('tag'=>'tr','url'=>"/admin/clients/sort_index",'handle'=>'sort_handle')); ?>
