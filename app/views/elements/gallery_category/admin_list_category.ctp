<tr>
<? print_r($galleryCategory); ?>
	<td>
		[<a href="#" onClick="toggleDisplay('gallerySubcategories_<?= $galleryCategory['browse_node_id'] ?>');">+</a>]
	</td>
	<td>
		<a href="/admin/gallery_category/edit/<?= $galleryCategory['browse_node_id']; ?>">
			<?= $galleryCategory['browse_name'] ?>
		</a>
	</td>
</tr>
<tr id="gallerySubcategories_<?= $galleryCategory['browse_node_id'] ?>" class="hidden">
	<? foreach($galleryCategory['Subcategories'] as $subcat) { ?>
		<?= $this->element("gallery_category/admin_list_category", array('galleryCategory' => $subcat)); ?>
	<? } ?>
</tr>

