<div class="galleryCategory view">
<?= $this->element("breadcrumbs", $this->viewVars); ?>

<table>
</table>

<h2><?php  __('GalleryCategory');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Browse Node Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryCategory['GalleryCategory']['browse_node_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Browse Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryCategory['GalleryCategory']['browse_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Parent Category'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($galleryCategory['ParentCategory']['browse_node_id'], array('controller'=> 'gallery_categories', 'action'=>'view', $galleryCategory['ParentCategory']['browse_node_id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit GalleryCategory', true), array('action'=>'edit', $galleryCategory['GalleryCategory']['browse_node_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete GalleryCategory', true), array('action'=>'delete', $galleryCategory['GalleryCategory']['browse_node_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $galleryCategory['GalleryCategory']['browse_node_id'])); ?> </li>
		<li><?php echo $html->link(__('List GalleryCategory', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New GalleryCategory', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Gallery Categories', true), array('controller'=> 'gallery_categories', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Parent Category', true), array('controller'=> 'gallery_categories', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Gallery Images', true), array('controller'=> 'gallery_images', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Gallery Image', true), array('controller'=> 'gallery_images', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Gallery Categories');?></h3>
	<?php if (!empty($galleryCategory['Subcategories'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Browse Node Id'); ?></th>
		<th><?php __('Browse Name'); ?></th>
		<th><?php __('Parent Node'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($galleryCategory['Subcategories'] as $subcategories):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $subcategories['browse_node_id'];?></td>
			<td><?php echo $subcategories['browse_name'];?></td>
			<td><?php echo $subcategories['parent_node'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'gallery_categories', 'action'=>'view', $subcategories['browse_node_id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'gallery_categories', 'action'=>'edit', $subcategories['browse_node_id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'gallery_categories', 'action'=>'delete', $subcategories['browse_node_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $subcategories['browse_node_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Subcategories', true), array('controller'=> 'gallery_categories', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Gallery Images');?></h3>
	<?php if (!empty($galleryCategory['GalleryImage'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('StampID'); ?></th>
		<th><?php __('Catalog Number'); ?></th>
		<th><?php __('Face Value'); ?></th>
		<th><?php __('Issue Date'); ?></th>
		<th><?php __('Series'); ?></th>
		<th><?php __('Stamp Name'); ?></th>
		<th><?php __('Long Description'); ?></th>
		<th><?php __('Short Description'); ?></th>
		<th><?php __('Keywords'); ?></th>
		<th><?php __('HTML Keywords'); ?></th>
		<th><?php __('Image Location'); ?></th>
		<th><?php __('Available'); ?></th>
		<th><?php __('Thumbnail Location'); ?></th>
		<th><?php __('Country'); ?></th>
		<th><?php __('Trivia'); ?></th>
		<th><?php __('FiledUnder'); ?></th>
		<th><?php __('Notes'); ?></th>
		<th><?php __('Reproducible'); ?></th>
		<th><?php __('Entry Date'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($galleryCategory['GalleryImage'] as $galleryImage):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $galleryImage['stampID'];?></td>
			<td><?php echo $galleryImage['catalog_number'];?></td>
			<td><?php echo $galleryImage['face_value'];?></td>
			<td><?php echo $galleryImage['issue_date'];?></td>
			<td><?php echo $galleryImage['series'];?></td>
			<td><?php echo $galleryImage['stamp_name'];?></td>
			<td><?php echo $galleryImage['long_description'];?></td>
			<td><?php echo $galleryImage['short_description'];?></td>
			<td><?php echo $galleryImage['keywords'];?></td>
			<td><?php echo $galleryImage['HTML_Keywords'];?></td>
			<td><?php echo $galleryImage['image_location'];?></td>
			<td><?php echo $galleryImage['available'];?></td>
			<td><?php echo $galleryImage['thumbnail_location'];?></td>
			<td><?php echo $galleryImage['country'];?></td>
			<td><?php echo $galleryImage['trivia'];?></td>
			<td><?php echo $galleryImage['filedUnder'];?></td>
			<td><?php echo $galleryImage['notes'];?></td>
			<td><?php echo $galleryImage['reproducible'];?></td>
			<td><?php echo $galleryImage['entry_date'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'gallery_images', 'action'=>'view', $galleryImage['stampID'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'gallery_images', 'action'=>'edit', $galleryImage['stampID'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'gallery_images', 'action'=>'delete', $galleryImage['stampID']), null, sprintf(__('Are you sure you want to delete # %s?', true), $galleryImage['stampID'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Gallery Image', true), array('controller'=> 'gallery_images', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
