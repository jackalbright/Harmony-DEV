<?
if (!isset($specialtyPageSampleImages) && isset($specialtyPage['SpecialtyPageSampleImages']))
{
	$specialtyPageSampleImages = $specialtyPage['SpecialtyPageSampleImages'];
}
if (isset($specialtyPage['SpecialtyPage']))
{
	$specialtyPage = $specialtyPage['SpecialtyPage'];
}

$path = "specialties/".$specialtyPage['page_url'];

#if (isset($sample_gallery_album)) { $gallery_title = ''; }
#else if (!isset($gallery_title)) { $gallery_title = 'Sample Gallery'; }

echo $this->element("sample_gallery", array('path'=>$path,'gallery_title'=>$gallery_title, 'images'=>$specialtyPageSampleImages, 'image_key'=>'specialty_page_image_id','group_by'=>'product_type_id','group_options'=>$products));
?>
