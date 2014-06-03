<div>
	<?= $this->element("admin/products/nav"); ?>
	<? __("Testimonials") ?> | <a href="/admin/testimonials">Add</a>
	<?= $this->element("sidebars/testimonials", array('testimonials'=>(isset($this->data['Testimonials']) ? $this->data['Testimonials'] : array()) ,'admin'=>1)); ?>
</div>
