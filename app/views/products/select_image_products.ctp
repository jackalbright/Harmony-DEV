<div class="" style="padding-bottom: 10px; color: #444;">
	<span class="alert2">Please note:</span> You can adjust your image and add optional text once you select a product
</div>
<? $this->set("build_context", $this->element("products/preview_image")); ?>
<? if(!empty($is_admin)) { ?>
<a href="/admin/products/select">Send Emails</a>
<? } ?>
<?= $this->element("products/product_grid"); #, array('links'=>$this->element('gallery/switch_layout'))); ?>
