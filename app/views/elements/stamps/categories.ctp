<?
	$cat_ids = Set::extract("/GalleryCategory/browse_node_id", $this->data);
?>
<? foreach($categories[$pid] as $cat) { ?>
<?
	$checked = in_array($cat['GalleryCategory']['browse_node_id'], $cat_ids);
?>
<div class="input checkbox">
<input type="checkbox" name="data[GalleryCategory][GalleryCategory][]" value="<?= $cat['GalleryCategory']['browse_node_id'] ?>" <?= !empty($checked) ? "checked='checked'" : "" ?> <label> <?= $cat['GalleryCategory']['browse_name'] ?> </label>
</div>
	<? 
		$cid = $cat['GalleryCategory']['browse_node_id'];
		if(!empty($categories[$cid]))
		{
		?>
		<div style="margin-left: 10px;">
			<?= $this->element("stamps/categories", array('categories'=>$categories,'pid'=>$cid)); ?>
		</div>
		<?
		}

	?>
<? } ?>
