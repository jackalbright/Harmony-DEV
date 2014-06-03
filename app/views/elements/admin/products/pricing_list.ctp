<?
if (!isset($product_id)) { $product_id = ''; }
 echo $ajax->Javascript->event('window','load',
	$ajax->remoteFunction( array('url'=>"/admin/product_pricings/edit_list/$product_id", 'update'=>"pricing_list")));
?>
<div id="pricing_list"></div>

