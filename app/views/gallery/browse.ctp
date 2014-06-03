<?
$page_title = !empty($galleryCategory['GalleryCategory']['page_title']) ? $galleryCategory['GalleryCategory']['page_title'] : $galleryCategory['GalleryCategory']['browse_name']. " Gifts";
$this->set("page_title", $page_title);
$this->set("body_title", $page_title);
?>
<?= $this->element("steps/steps",array('step'=>'image', 'gallery'=>1)); ?>
<?
	#$this->element("gallery/browse_intro"); 
?>

<table width="100%" class="hidden">
<tr>
	<td>
		&nbsp;
	</td>
	<td align="right">
		<a href="/gallery/browse">View All Subjects</a>
	</td>
</tr>
</table>

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