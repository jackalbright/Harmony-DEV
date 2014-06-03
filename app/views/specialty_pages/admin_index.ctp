<div class="specialtyPage index">
<h2><?php __('SpecialtyPage');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th>Resort</th>
	<th><?php echo $paginator->sort('link_name');?></th>
	<th><?php echo $paginator->sort('page_url');?></th>
	<th><?php echo $paginator->sort('page_title');?></th>
	<th><?php echo $paginator->sort('body_title');?></th>
</tr>
<tbody id="specialtyPage_sortable">
<?php
$i = 0;
foreach ($specialtyPages as $specialtyPage):
?>
	<tr class="<?= $i++ % 2 ? "altrow" : "" ?> <?= empty($specialtyPage['SpecialtyPage']['enabled']) ? "specialtyPage_disabled" : "" ?>" id="specialtyPage_<?= $specialtyPage['SpecialtyPage']['specialty_page_id'] ?>">
		<td>
			<img class="handles" src="/images/icons/up-down.png"/>
		</td>
		<td>
			<?
				$edit = !empty($specialtyPage['SpecialtyPage']['link_name']) ? $specialtyPage['SpecialtyPage']['link_name'] : $specialtyPage['SpecialtyPage']['page_title'];
			?>
			<?php echo $html->link($edit, array('action'=>'edit', $specialtyPage['SpecialtyPage']['specialty_page_id'])); ?>
			(<?php echo $html->link(__('Edit', true), array('action'=>'edit', $specialtyPage['SpecialtyPage']['specialty_page_id'])); ?>)
		</td>
		<td>
			<?php 
			echo $html->link(__("http://www.harmonydesigns.com/specialty_pages/view/".$specialtyPage['SpecialtyPage']['page_url'], true), array('admin'=>false, 'action'=>'view', $specialtyPage['SpecialtyPage']['page_url']),array('target'=>'_new')); ?>
		</td>
		<td>
			<?php echo $specialtyPage['SpecialtyPage']['page_title']; ?>
		</td>
		<td>
			<?php echo $specialtyPage['SpecialtyPage']['body_title']; ?>
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
		<li><?php echo $html->link(__('New SpecialtyPage', true), array('action'=>'add')); ?></li>
	</ul>
</div>

<?  echo $ajax->sortable("specialtyPage_sortable", array('tag'=>'tr','url'=>"/admin/specialty_pages/resort",'handle'=>"handles")); ?>
