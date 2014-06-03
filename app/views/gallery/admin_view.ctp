<div class="gallery view">
<h2><?php  __('Gallery');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Gallery', true), array('action'=>'edit', $gallery['GalleryCategory'][''])); ?> </li>
		<li><?php echo $html->link(__('Delete Gallery', true), array('action'=>'delete', $gallery['GalleryCategory']['']), null, sprintf(__('Are you sure you want to delete # %s?', true), $gallery['GalleryCategory'][''])); ?> </li>
		<li><?php echo $html->link(__('List Gallery', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Gallery', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
