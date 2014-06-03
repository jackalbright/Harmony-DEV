<? if(empty($prod)) { $prod = $product['Product']['code']; } ?>
<? $this->set("enable_tracking", "product"); ?>
<div class="product product_view">

<table border=0 id="view_related_chart" class="relative" cellspacing=0 cellpadding=5 width="<?= empty($product['Product']['is_stock_item']) ? "100%" : "960" ?>">
<tr>
	<td class="relative" colspan="<?= !empty($_REQUEST['wide']) ? 3 : 2 ?>" valign="top" style="padding-bottom: 10px;">
		
		<?= $this->element("products/tabs"); ?>
        
	</td>
	<? if(empty($product['Product']['is_stock_item'])) { ?>
	<!--<td rowspan=2 valign="top" align="center" style="width: 220px;">-->
   <td rowspan=2 valign="top" align="center" style="width: 210px;">
		<?#= $this->element("products/cta_new",array('get_started'=>false,'clients'=>false,'calc'=>false,'learn_more'=>true)); ?>
		<?= $this->element("products/cta_new",array('clients'=>false,'calc'=>false)); ?>
	</td>
	<? } ?>
</tr>
<tr>
	<td colspan=2>
	</td>
</tr>
</table>
</div>