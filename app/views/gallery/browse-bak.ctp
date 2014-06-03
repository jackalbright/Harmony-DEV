<table width="100%">
<tr>
	<td width="" valign=top>
		<?= $this->element("gallery/browse_intro"); ?>
	</td>
	<td width="720" valign=top>
		<?= $this->element("products/product_grid", array('products'=>$products,'items_per_row'=>-1)); ?>
	</td>
</tr>
</table>
<div class="right_align">
	<a href="/gallery/browse">View All Subjects</a>
</div>
<div class="clear"></div>

<div class="gallery view">
	<? if(preg_match("/\w/", $galleryCategory['GalleryCategory']['description'])) { ?>
	<p>
		<?= $galleryCategory['GalleryCategory']['description'] ?>
	</p>
	<? } ?>
	<?= $this->element("gallery/subcategories", $this->viewVars); ?>
	<?= $this->element("gallery/image_grid", $this->viewVars); ?>
</div>
