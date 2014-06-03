<div class="color_dark">
	<? for($i = 0; $i < count($galleryCategory['Subcategories']); $i++) { 
		$cat = $galleryCategory['Subcategories'][$i];
		?>
		<a href="/gallery/browse/<?= $path ?>;<?= preg_replace("/ /", "_", $cat['browse_name']) ?>" style="font-weight: bold;">
		<!-- <a href="/product/browse.php?browseNode=<?=$cat['browse_node_id'] ?>" style="font-weight: bold;">-->
			<?= $cat['browse_name'] ?></a>
		<? if($i+1 < count($galleryCategory['Subcategories'])) { echo ' | '; } ?>
	<? } ?>
</div>
