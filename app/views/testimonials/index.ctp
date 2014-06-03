<? $this->set("page_title", "Customer Reviews"); ?>
<div class="testimonials index" style="width: 600px; margin: 0 auto;">
<h1 id='title'><?php __('Customer Reviews');?></h1>
<?  $i = 0; foreach ($testimonials as $testimonial): ?>
	<div style="padding: 10px 5px; background-color: <?= $i++%2==0?"#FFF":"#CCC";?>; ">
		<div class="testimonial">
			<?= strip_tags($testimonial['Testimonial']['text']); ?>
		</div>
		<div class="attribution">
			<?= strip_tags($testimonial['Testimonial']['attribution']); ?>
		</div>
	</div>
<?php endforeach; ?>
</div>
