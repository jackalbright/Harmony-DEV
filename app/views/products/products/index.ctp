<div class="notice_header_medium">Low minimums • No setup charges</div>
<br/>

<? if (isset($popular_products)) { echo $this->element("products/product_grid", array('title'=>'Popular Items', 'products'=>$popular_products)); } ?>
<? if (isset($stock_products)) { echo $this->element("products/product_grid", array('title'=>'Stock Items', 'products'=>$stock_products)); } ?>
<? if (isset($all_products)) { echo $this->element("products/product_grid", array('title'=>'All Items', 'products'=>$all_products)); } ?>

