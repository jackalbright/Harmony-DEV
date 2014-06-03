<div class="galleryFilterKeyword view">
<h2><?php  __('GalleryFilterKeyword');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Filter Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryFilterKeyword['GalleryFilterKeyword']['filter_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryFilterKeyword['GalleryFilterKeyword']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $galleryFilterKeyword['GalleryFilterKeyword']['description']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit GalleryFilterKeyword', true), array('action'=>'edit', $galleryFilterKeyword['GalleryFilterKeyword']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete GalleryFilterKeyword', true), array('action'=>'delete', $galleryFilterKeyword['GalleryFilterKeyword']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $galleryFilterKeyword['GalleryFilterKeyword']['id'])); ?> </li>
		<li><?php echo $html->link(__('List GalleryFilterKeyword', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New GalleryFilterKeyword', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
