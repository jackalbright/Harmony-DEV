<div class="productPricings form">
<?= $this->element("admin/products/nav"); ?>
<?php 
#echo $form->create('ProductPricing');
?>
<form method="POST" action="/admin/product_pricings/edit_list/<?= $product_id ?>">

	<fieldset>
 		<legend><?php __('Edit ProductPricing');?></legend>
	<?php
		#$pricings = !empty($this->data['ProductPricing']) ? $this->data['ProductPricing'] : array();
		$this->data['ProductPricing'][] = array();
		$i = 0;
		echo "<div><table border=1 cellpadding=0 cellspacing=0>";
		foreach($this->data['ProductPricing'] as $id => $pricing)
		#for($i = 1; $i < count($pricings) + 2; $i++)
		{
			$price = !empty($this->data['ProductPricing'][$id]['percent_discount']) ? sprintf("$%.02f", $product['Product']['base_price'] * $this->data['ProductPricing'][$id]['percent_discount'] / 100) : "&nbsp;";
			if (!$id) { $id = 0; }
			#$pricing = $i < count($pricings) ? $pricings[$i] : array();
			echo $form->hidden("ProductPricing.$id.price_point_id");
			echo $form->hidden("ProductPricing.$id.product_type_id",array('value'=>$product_id));
			echo $html->tableCells(array(
				array($form->input("ProductPricing.$id.quantity"), 
					$form->input("ProductPricing.$id.price"),
					#$form->input("ProductPricing.$id.percent_discount"),
					#$price
				)
			));
		}
		echo "</table></div>";
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
