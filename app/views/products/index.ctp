<? 
$this->set("title_for_layout", "Unique Custom Gifts, Personalized Business Gifts, Museum Store Products | Harmony Designs");
$this->set("body_title", "Discover How Easy it is to Create Custom Gifts Online in Just a Few Clicks");
#$this->set("meta_description", "");
#$this->set("meta_keywords", "");

?>
<!--
<div style="font-size: 16px;">
	Click on a product below to learn more
</div>
-->
<? $this->element("steps/steps", array()); ?>
<div class="hidden left notice_header_medium">Low minimums • Free personalization &bull; Made in USA</div>

<br/>

<table width="100%" cellpadding=0 cellspacing=5>
<tr>
	<td style="" valign="top" colspan=3>
    1st time
		<?= $this->element("products/product_grid", array('title_height'=>60,'XXXXXXcenter_text'=>$this->element("try_preview"), 'title'=>"Create Custom Products", 'intro'=>'Use your photo, logo, art &bull; Preview online', 'products'=>$products_by_category['Custom Products'], 'items_per_row'=>7,'live'=>0,'details_link'=>1,'homepage'=>1)); ?>
		<br/>
	</td>
</tr>
<tr>
	<td valign="top">
    2nd time
		<?= $this->element("products/product_grid", array('title_height'=>60,'title'=>"Do-It-Yourself", 'products'=>$products_by_category['For Crafters'], 'items_per_row'=>3,'live'=>0,'details_link'=>1,'bg_color'=>'#FFF')); ?>
	</td>
	<td valign="top">
		<div class="color_steps" style="font-size: 16px;">Stamp Products</div>
		<div class="rounded product_table" style="background-color: #FFF; text-align: center; padding: 4px;">
			<a href="/gallery/browse?clear_product=1">
				<img src="/images/choose_stamp.jpg" height=94/></a>
			<br/>
			<a href="/gallery/browse?clear_product=1">
				Thousands of stamp images</a>
			<br/>
			to use on your products
		</div>
	</td>
	<td valign="top">
		<?= $this->element("products/product_grid", array('title'=>"Ready Made", 'intro'=>'Add your logo or text (optional)', 'products'=>$products_by_category['Ready Made'], 'items_per_row'=>2,'live'=>0,'details_link'=>1,'bg_color'=>'#FFF')); ?>
	</td>
</tr>
</table>
		<br/>
		<br/>
<? /*
<div class="hidden">

<? if (isset($popular_products)) { echo $this->element("products/product_grid", array('title'=>'Popular Items', 'products'=>$popular_products,'details_link'=>1,'items_per_row'=>5,'live'=>0,'link_href'=>'#all','link_label'=>'View All Products')); } ?>
<? if (isset($stock_products)) { echo $this->element("products/product_grid", array('title'=>'Stock Items', 'products'=>$stock_products,'details_link'=>1,'items_per_row'=>5,'live'=>0)); } ?>
<? if (isset($all_products)) { echo $this->element("products/product_grid", array('title'=>'All Items', 'products'=>$all_products,'details_link'=>1,'items_per_row'=>5,'live'=>0,'a_name'=>'all')); } ?>


</div>
*/ ?>
