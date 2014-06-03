<div>
<table cellpadding=5 width="100%" border=0>
<tr>
	<td style="width: 250px;" align="center" valign="top" rowspan=2>
		<?= $this->element("specialty_pages/sample_gallery_tabbed",array('sample_images'=>$sample_images,'size'=>'225')); ?>
	</td>
	<td valign="top">
		<?= $specialtyPage['SpecialtyPage']['introduction'] ?>

		<div>

			<? foreach($specialtyPage['SpecialtyPageSectionContent'] as $section) { 
				$id = preg_replace("/\W+/", "_", strtolower($section['title'])); 
			?>
			<div class="accordian_header">
				<a href="Javascript:void(0);" onClick="accordianClick('section_<?=$id?>');">
				 <img src="/images/icons/white_arrow_down.gif" id="section_<?=$id?>_arrow_show" align="bottom" class="hidden"/>
				<img src="/images/icons/white_arrow_right.gif" id="section_<?=$id?>_arrow_hide" align="top" class=""/>
					<?= $section['title'] ?>
				</a>
			</div>
			<div id="section_<?=$id?>" class="hidden">
				<?= $section['content'] ?>
			</div>
			<? } ?>

			<div class="accordian_header">
				<a href="Javascript:void(0);" onClick="accordianClick('wholesale');">
				 <img src="/images/icons/white_arrow_down.gif" id="wholesale_arrow_show" align="bottom" class="hidden"/>
				<img src="/images/icons/white_arrow_right.gif" id="wholesale_arrow_hide" align="top" class=""/>
					Wholesale Pricing
				</a>
			</div>
			<div id="wholesale" class="hidden">
				<?= $this->element("products/wholesale_pricing",array('style'=>'width: 100%;')); ?>
			</div>

			<div class="accordian_header">
				<a href="Javascript:void(0);" onClick="accordianClick('products');">
				 <img src="/images/icons/white_arrow_down.gif" id="products_arrow_show" align="bottom" class="hidden"/>
				<img src="/images/icons/white_arrow_right.gif" id="products_arrow_hide" align="top" class=""/>
				View All Products
				</a>
			</div>
			<div id="products" class="hidden">
				<?= $this->element("products/product_grid",array('live'=>0,'details_link'=>1,'items_per_row'=>3)); ?>
				<div class="clear"></div>
			</div>

			<div class="accordian_header">
				<a href="Javascript:void(0);" onClick="accordianClick('clients');">
				 <img src="/images/icons/white_arrow_down.gif" id="clients_arrow_show" align="bottom" class="hidden"/>
				<img src="/images/icons/white_arrow_right.gif" id="clients_arrow_hide" align="top" class=""/>
					A few of our customers
				</a>
			</div>
			<div id="clients" class="hidden">
				<?= $this->element("clients/clientlist",array('clients'=>$specialtyPage['Clients'],'notitle'=>1)); ?>
			</div>


			<div class="accordian_header">
				<a href="Javascript:void(0);" onClick="accordianClick('reviews');">
				 <img src="/images/icons/white_arrow_down.gif" id="reviews_arrow_show" align="bottom" class="hidden"/>
				<img src="/images/icons/white_arrow_right.gif" id="reviews_arrow_hide" align="top" class=""/>
					Reviews <img height="15" src="/images/icons/5stars.gif"/>
				</a>
			</div>
			<div id="reviews" class="hidden">
				<?= $this->element("specialty_pages/testimonials",array('testimonials'=>$specialtyPage['Testimonials'],'notitle'=>1)); ?>
			</div>



		</div>
	</td>
	<td valign="top" style="width: 225px;" align="center">
		<div style="position: relative;">
			<div style="position: absolute; top: -50px; right: -45px;">
				<img src="/images/Try-our-preview-tool.gif"/>
			</div>
		</div>
		<?= $this->element("rbox", array('element'=>'specialty_pages/cta','title'=>"Preview Your Products")); ?>
		<br/>
		<b style="font-size: 16px; color: #009900;">OR</b>
		<br/>
		<br/>
		<?= $this->element("rbox", array('element'=>'specialty_pages/contact','title'=>"Contact Us")); ?>
	</td>
</tr>
<tr>
	<td colspan=2>
	</td>
</tr>

</table>
</div>


<hr/>
<br/>
<br/>
<br/>
<br/>

<?= $this->element("steps/steps"); ?>
<div class="specialtyPage specialtyPage_view">

<?
$gallery_title = $specialtyPage['SpecialtyPage']['body_title'] ." Sample Gallery";

echo $this->element("specialty_pages/sample_gallery_album",array('specialtyPage'=>$specialtyPage['SpecialtyPage'],'specialtyPageSampleImages'=>$specialtyPage['SpecialtyPageSampleImages']));
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
				<input type="image" src="/images/buttons/Get-Started.gif"/>
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
