<div class="galleryCategory index">
<h2><?php __('Gallery Categories');?></h2>

<table width="100%">
	<td>
		<form method="POST" action="/admin/gallery_category/search">
		<input type="submit" name="keyword" class="long_text">
		<input type='submit' value="Search">
		</form>
	</td>
	<td class="right_align">
		<?php echo $html->link(__('New Category', true), array('action'=>'add')); ?>
	</td>
</table>

<table border="1">
<tr>
	<th>
		[<a href="#" onClick="toggleDisplayAll('gallerySubcategories');">+</a>]
	</th>
	<th>
		Category Name
	</th>
</tr>
<? 
foreach($galleryCategories as $galleryCategory) 
{ 
	echo $this->element("gallery_category/admin_list_category", array('galleryCategory' => $galleryCategory));
}
?>
</table>
</div>
