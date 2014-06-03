<?= $javascript->() ?>

<div id="preview_loading">
Loading products... Please wait...
(animating image)
</div>
<div class="hidden" id="preview_list">
<? foreach($products as $product) { ?>
	<img src="/products/preview/<?= $product['Product']['code'] ?>" width="200"/>
	<!--<img src="/products/preview/<?= $product['Product']['code'] ?>"/>-->
<? } ?>
</div>
