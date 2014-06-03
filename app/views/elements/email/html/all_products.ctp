<div>
	<? if(!empty($message)) { ?>
	<p>
		<?= $message ?>
	</p>
	<? } ?>

	<?= $this->element("products/product_grid", array('build'=>$build)); ?>
</div>
