<script src="/js/jquery.bxGallery.js"></script>
<?
$path = "specialties/".$specialtyPage['SpecialtyPage']['page_url'];

?>

<div>
	<ul id="sampleImages">
		<? foreach($sample_images as $img) { 
			$img_url = "/images/galleries/cached/$path/".$img['SpecialtyPageSampleImage']['specialty_page_image_id']."/-400x400.".$img['SpecialtyPageSampleImage']['file_ext']; 
		?>
		<li>
			<img src="<?= $img_url ?>" title="<?= $img['SpecialtyPageSampleImage']['title'] ?>"/>
		</li>
		<? } ?>
	</ul>
	
</div>
<style>
#sampleImages
{
}

ul.thumbs, ul#sampleImages
{
	list-style-type: none;
}
ul.thumbs li
{
}

</style>
<script>
j(document).ready(function() {
	j('#sampleImages').bxGallery({
		maxheight: 350,
		thumbwidth: 75,
		thumbplacement: 'bottom',
		//thumbcontainer: 600

	});

});
</script>

