<div class="productPricings form">
<?php 
#echo $form->create('ProductPricing');
?>
<? 
echo $ajax->form("edit_list/$prod",'post', array('model'=>'Shipping','enctype'=>'multipart/form-data','name'=>'productPricingForm','id'=>'productPricingForm','update'=>'pricing_list'));
?>
<!-- <form method="POST" action="/admin/product_pricings/edit_list/<?= $product_id ?>"> -->

	<fieldset>
 		<legend><?php __('Edit ProductPricing');?></legend>
	<?php
		#$pricings = !empty($this->data['ProductPricing']) ? $this->data['ProductPricing'] : array();
		$this->data['ProductPricing'][] = array();
		$i = 0;
		foreach($this->data['ProductPricing'] as $id => $pricing)
		#for($i = 1; $i < count($pricings) + 2; $i++)
		{
			if (!$id) { $id = 0; }
			#$pricing = $i < count($pricings) ? $pricings[$i] : array();
			echo "<div><table border=0 cellpadding=0 cellspacing=0>";
			echo $form->hidden("ProductPricing.$id.price_point_id");
			echo $form->hidden("ProductPricing.$id.product_type_id",array('value'=>$product_id));
			echo $html->tableCells(array(
				array($form->input("ProductPricing.$id.quantity"), $form->input("ProductPricing.$id.price")
				)
			));
			echo "</table></div>";
		}
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
