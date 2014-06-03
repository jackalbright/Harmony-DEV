<div class="specialtyPage specialtyPage_view">

<table width="100%" border=0>
<tr>
	<td width="250" valign="top" align="center">
		<div id="product_gallery_all" class="product_gallery">
		<?= $this->element("sample_gallery/left",array('id'=>'specialty','model'=>'SpecialtyPageSampleImage','album_link'=>"/specialty_page_sample_images/album/".$specialtyPage['SpecialtyPage']['specialty_page_id'],'model_key'=>'specialty_page_image_id','sample_images'=>$sample_images,'path'=>"specialties/".$specialtyPage['SpecialtyPage']['page_url'])); ?>
		</div>

		<? foreach($image_products as $ip) { 
			$product_sample_images = array();
			foreach($sample_images as $si)
			{
				if ($si['SpecialtyPageSampleImage']['product_type_id'] == $ip)
				{
					$product_sample_images[] = $si;
				}
			}
		?>
		<div id="product_gallery_<?= $ip ?>" class="hidden product_gallery">
		<?= $this->element("sample_gallery/left",array('id'=>"specialty_$ip",'album_link'=>"/specialty_page_sample_images/album/".$specialtyPage['SpecialtyPage']['specialty_page_id']."/".$ip,'model'=>'SpecialtyPageSampleImage','model_key'=>'specialty_page_image_id','sample_images'=>$product_sample_images,'path'=>"specialties/".$specialtyPage['SpecialtyPage']['page_url'])); ?>
		</div>
		<? } ?>

		<div class="" align=left>
			Select a product:
			<ul>
				<li><a href="Javascript:void(0);" onClick="toggleSpecialtySampleProduct('all');">All products</a>
				<? foreach($image_products as $pid => $pid) { if (empty($products_by_id[$pid])) { continue; } ?>
				<li><a href="Javascript:void(0);" onClick="toggleSpecialtySampleProduct('<?= $pid ?>');"><?= $products_by_id[$pid]['Product']['name']; ?></a>
				<? } ?>
			</ul>
		</div>
	</td>
	<td valign="top">
		<?= $specialtyPage['SpecialtyPage']['introduction'] ?>

		<div align="right">
			<a href="Javascript:void(0);" class="" onClick="showPopup('more_info');">More information</a>
		</div>
		<div class="clear"></div>
			<div class="product_info_popup hidden" id="more_info">
				<a class="block right" href="Javascript:void(0);" onClick="hidePopup('more_info');">Close</a>

				More info here....

				<a class="block right" href="Javascript:void(0);" onClick="hidePopup('more_info');">Close</a>
			</div>
	</td>
	<td width="300" valign="top" rowspan=2>
		<?= $this->element("specialty_pages/contact"); ?>
	</td>
</tr>
<tr>
	<td colspan=2>
		<?= $this->element("clients/clientlist",array('clients'=>$specialtyPage['Clients'])); ?>
	</td>
</tr>
</table>



<hr/>

<?
$gallery_title = $specialtyPage['SpecialtyPage']['body_title'] ." Sample Gallery";

echo $this->element("specialty_pages/sample_gallery_album",array('specialtyPage'=>$specialtyPage['SpecialtyPage'],'specialtyPageSampleImages'=>$specialtyPage['SpecialtyPageSampleImages'], 'gallery_title'=>$gallery_title));
?>

<hr/>

<div>
	<table width="100%" class="tab_list">
	<tr>
		<td id="description_tab" class="tab selected_tab">
			<a href="javascript:void(0)" onClick="selectTab('description');">Description</a>
		</td>
		<!--
		<td id="description2_tab" class="tab ">
			<a href="javascript:void(0)" onClick="selectTab('description2');">D2</a>
		</td>
		-->
		<? foreach($specialtyPage['SpecialtyPageSectionContent'] as $section) { 
			$id = preg_replace("/\W+/", "_", strtolower($section['title'])); 
		?>
			<td class="spacer"></td>
			<td id="<?=$id?>_tab" class="tab">
				<a href="javascript:void(0)" onClick="selectTab('<?= $id ?>');"><?= $section['title']?></a>
			</td>
		<? } ?>
			<td class="spacer"></td>
			<td id="testimonials_tab" class="tab">
				<a href="javascript:void(0)" onClick="selectTab('testimonials');">Reviews</a>
			</td>
		<td class="spacer"></td>
		<td align=center>
			<form method="POST" action="/products/select">
				<input type="image" src="/images/buttons/Personalize.gif"/>
			</form>
		</td>
	</tr>
	</table>

	<div class="tabbed_container">

	<div class="selected_tab_content tab_content" id="description_tab_content">
		<div style="width: 600px;">
		<?= $specialtyPage['SpecialtyPage']['introduction'] ?>
		</div>
	</div>

	<? foreach($specialtyPage['SpecialtyPageSectionContent'] as $section) { 

		$id = preg_replace("/\W+/", "_", strtolower($section['title'])); 
	?>
	<div class="tab_content" id="<?= $id ?>_tab_content">
		<?= $section['content'] ?>
	</div>
	<? } ?>

	<div class="tab_content" id="testimonials_tab_content">
		<?= $this->element("specialty_pages/testimonials", array('testimonials'=>$specialtyPage['Testimonials'])); ?>
	</div>

</div>


</div>
