<? if (!isset($images_per_row)) { $images_per_row = 5; } ?>

<? $width = intval(100 / $images_per_row); ?>

<div class="specialtyPageSampleImage index specialtyPageSampleImage_sortable">

<div class="right_align">
	<?php echo $html->link(__('Upload New Image', true), array('action'=>'add',$specialtyPage['SpecialtyPage']['specialty_page_id'])); ?></li>
</div>
<br/>
<? if (count($specialtyPageSampleImages)) { ?>
To change/replace/remove an image, click on the name/edit link.<br/>
<br/>
To resort the images, drag the image to the order you want it.
<? } ?>
<br/>

<div id="specialtyPageSampleImage_sortable">
<?php
$i = 0;
foreach ($specialtyPageSampleImages as $specialtyPageSampleImage):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
	#print_r($specialtyPageSampleImage);

?>
	<div class="float_left padded" id="photo_<?= $specialtyPageSampleImage['SpecialtyPageSampleImage']['specialty_page_image_id'] ?>">
		<img src="/images/galleries/specialties/<?= $specialtyPage['SpecialtyPage']['page_url'] ?>/thumbs/<?= $specialtyPageSampleImage['SpecialtyPageSampleImage']['specialty_page_image_id'] ?>.<?= $specialtyPageSampleImage['SpecialtyPageSampleImage']['file_ext']; ?>">
		<br/>
		<a href="/admin/specialty_page_sample_images/edit/<?= $specialtyPageSampleImage['SpecialtyPageSampleImage']['specialty_page_image_id'] ?>">
			<?= $specialtyPageSampleImage['SpecialtyPageSampleImage']['title']; ?> (Edit)
		</a>
	</div>
<?php endforeach; ?>
<div class="clear divider">&nbsp;</div>
</div>

<?  echo $ajax->sortable("specialtyPageSampleImage_sortable", array('tag'=>'div','url'=>"/admin/specialty_page_sample_images/resort/$specialty_page_id")); ?>



</div>
<div class="actions">
	<ul>
	</ul>
</div>
