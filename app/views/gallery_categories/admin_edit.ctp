<div class="galleryCategory form">

<?php echo $form->create('GalleryCategory');?>
	<fieldset>
 		<legend><?php __('Edit ' . $this->data['GalleryCategory']['browse_name'] . ' Category');?></legend>
	<table width="100%">
	<tr> <td valign="top">
	<?php
		echo $form->input('browse_node_id');
		echo $form->input('browse_name');
		echo $form->input('page_title');
		echo $form->input('parent_node',array('label'=>'Parent Category', 'options'=>$all_categories_options,'after'=>"<br/>CAUTION: Changes where this category is located under"));
		if ($this->data['GalleryCategory']['parent_node'] > 0) { 
			echo "<a href='/admin/gallery_categories/edit/" . $this->data['GalleryCategory']['parent_node'] . "'>Edit Parent Category</a>";
		}

		echo $form->input('thumb_catalog_number',array('options'=>$stamp_map,'onChange'=>"updateGalleryCategoryThumbnail(this.value)",'empty'=>'[None]'));
			
		?>
			
			<a id="gallery_category_thumb_link" rel="shadowbox" href="<?= !empty($this->data['GalleryCategory']['thumb_catalog_number']) ? "/gallery/image/".$this->data['GalleryCategory']['thumb_catalog_number'] : "" ?>">
				<img id="gallery_category_thumb_img" src="<?= !empty($this->data['GalleryCategory']['thumb_catalog_number']) ? "/gallery/image/".$this->data['GalleryCategory']['thumb_catalog_number'] : "" ?>" height="50"/>
			</a>
		<?

		echo $form->input('meta_keywords',array('class'=>'full_width'));
		echo $form->input('meta_desc',array('class'=>'full_width'));
		echo $form->input('description',array('class'=>'full_width'));
		echo $form->input('GalleryFilterKeywords.GalleryFilterKeywords', array('type'=>'select','multiple'=>'checkbox', 'options'=>$galleryFilterKeywords));
		#echo $form->input('GalleryImage');
	?>
	</td> 
	<td valign="top">
		<b>Start here to find a specific category</b>
		<h3>Subcategories:</h3>
		<table>
		<tr>
			<td align="right">
				[<a href="/admin/gallery_categories/add/<?= $this->data['GalleryCategory']['browse_node_id'] ?>">Add</a>]
			</td>
		</tr>
		<? foreach($subCategories as $sc) { ?>
		<tr>
			<td>
				<a href="/admin/gallery_categories/edit/<?= $sc['GalleryCategory']['browse_node_id'] ?>"><?= $sc['GalleryCategory']['browse_name'] ?></a>
			</td>
		</tr>
		<? } ?>
		</table>
	</td> </tr>
	</table>
	</fieldset>
<?php echo $form->end('Submit');?>

</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('GalleryCategory.browse_node_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('GalleryCategory.browse_node_id'))); ?></li>
		<li><?php echo $html->link(__('List Categories', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Gallery Images', true), array('controller'=> 'gallery_images', 'action'=>'index', $this->data['GalleryCategory']['browse_node_id'])); ?> </li>
		<li><?php echo $html->link(__('New Gallery Image', true), array('controller'=> 'gallery_images', 'action'=>'add')); ?> </li>
	</ul>
</div>
