<div class="product product_view">

<table border=0 align="center" width="100%">
<tr>
	<td valign=top style="" colspan=3 rowspan=1 align="left">
		<?=$hd->product_element("products/sample_gallery_vertical",$product['Product']['prod'],array('products'=>$related_products)); ?>
	</td>
	<td rowspan=3 valign="top" style="width: 200px;" align="right">
		<?= $this->element("clients/clientlist", array('clients'=>$client_list,'vertical'=>true)); ?>
	</td>
</tr>
<tr>
	<td valign=top style="width: 550px; border: solid #CCC 1px;">
		<?= $this->element("products/intro",array('product'=>$product)); ?>
		<?#= $this->element("products/choose",array('no_chart'=>1)); ?>
	</td>
	<td rowspan=1 valign="top">
		<?= $this->element("products/choose"); #,array('no_features'=>1)); ?>
		<div class="clear"></div>
	</td>
</tr>
<tr>
	<td colspan=3>
		<? if(count($product['Testimonials'])) { ?>
		<div>
			<hr/>
			<a class="hidden right" href="#top" name="comments">Top</a>
			<div id="testimonials">
			<div class="sidebar_header">Customer Comments:</div>
				<?= $this->element("products/testimonials", array('testimonials'=>$product['Testimonials'],'limit'=>1,'random'=>true)); ?>
			</div>
		</div>
		<? } ?>

	</td>
</tr>
</table>

</div>
