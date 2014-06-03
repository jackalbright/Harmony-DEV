<div class="galleryImage view">
<h2><?php  __('GalleryImage');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('StampID'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryImage['GalleryImage']['stampID']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Catalog Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryImage['GalleryImage']['catalog_number']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Face Value'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryImage['GalleryImage']['face_value']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Issue Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryImage['GalleryImage']['issue_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Series'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryImage['GalleryImage']['series']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Stamp Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryImage['GalleryImage']['stamp_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Long Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryImage['GalleryImage']['long_description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Short Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryImage['GalleryImage']['short_description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Keywords'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryImage['GalleryImage']['keywords']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('HTML Keywords'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryImage['GalleryImage']['HTML_Keywords']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Image Location'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryImage['GalleryImage']['image_location']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Available'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryImage['GalleryImage']['available']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Thumbnail Location'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryImage['GalleryImage']['thumbnail_location']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Country'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryImage['GalleryImage']['country']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Trivia'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryImage['GalleryImage']['trivia']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('FiledUnder'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryImage['GalleryImage']['filedUnder']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Notes'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryImage['GalleryImage']['notes']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Reproducible'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryImage['GalleryImage']['reproducible']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Entry Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryImage['GalleryImage']['entry_date']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit GalleryImage', true), array('action'=>'edit', $galleryImage['GalleryImage']['stampID'])); ?> </li>
		<li><?php echo $html->link(__('Delete GalleryImage', true), array('action'=>'delete', $galleryImage['GalleryImage']['stampID']), null, sprintf(__('Are you sure you want to delete # %s?', true), $galleryImage['GalleryImage']['stampID'])); ?> </li>
		<li><?php echo $html->link(__('List GalleryImage', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New GalleryImage', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Gallery Categories', true), array('controller'=> 'gallery_categories', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Gallery Categories', true), array('controller'=> 'gallery_categories', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Gallery Categories');?></h3>
	<?php if (!empty($galleryImage['GalleryCategories'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Browse Node Id'); ?></th>
		<th><?php __('Browse Name'); ?></th>
		<th><?php __('Parent Node'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($galleryImage['GalleryCategories'] as $galleryCategories):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $galleryCategories['browse_node_id'];?></td>
			<td><?php echo $galleryCategories['browse_name'];?></td>
			<td><?php echo $galleryCategories['parent_node'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'gallery_categories', 'action'=>'view', $galleryCategories['browse_node_id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'gallery_categories', 'action'=>'edit', $galleryCategories['browse_node_id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'gallery_categories', 'action'=>'delete', $galleryCategories['browse_node_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $galleryCategories['browse_node_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Gallery Categories', true), array('controller'=> 'gallery_categories', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
