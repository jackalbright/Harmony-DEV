<div class="specialtyPage specialtyPage_view">

<table width="100%" border=1>
<tr>
	<td>
		<?
			$products = array($product);
			if (count($related_products) > 0) { 
				$products = array_merge($products, $related_products);
			}
			echo $hd->product_element("products/sample_gallery_left",$product['Product']['prod'],array('products'=>$products,'width'=>'200'));
		?>
	</td>
	<td>
	</td>
	<td>
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
