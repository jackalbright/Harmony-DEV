<?= $this->element("steps/steps", array('step'=>'product','gallery'=>1)); ?>
<div class="hidden"><?= $this->element("products/preview_image",array('is_stamp'=>true)); ?></div>
<?= $this->element("gallery/switch_layout"); ?>
<?= $this->element("products/product_grid", array('links'=>$this->element('gallery/switch_layout'))); ?>
