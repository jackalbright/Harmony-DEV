<div class="productParts form">
<?= $this->element("admin/products/nav"); ?>
<?php 
#echo $form->create('ProductPart');
?>
<form method="POST" action="/admin/product_parts/edit_list/<?= $product_id ?>">

	<fieldset>
 		<legend><?php __('Edit Product Customization Options');?></legend>
	<?php
		#$parts = !empty($this->data['ProductPart']) ? $this->data['ProductPart'] : array();
		$i = 0;
		echo "<div><table border=0 cellpadding=0 cellspacing=0>";
		#print_r($this->data['ProductPart']);
		foreach($all_parts as $part)
		#for($i = 1; $i < count($parts) + 2; $i++)
		{
			#print_r($part);
			#$part = $i < count($parts) ? $parts[$i] : array();
			$part_id = $part['Part']['part_id'];
			echo $form->hidden("ProductPart.$part_id.product_type_id", array('value'=>$product_id));
			echo $form->hidden("ProductPart.$part_id.product_part_id");
			echo $form->hidden("ProductPart.$part_id.part_id",array('value'=>$part_id));
			echo $html->tableCells(array(
				array($form->input("ProductPart.$part_id.optional", array('options'=>array('none'=>'Not Applicable','no'=>'Included (FREE)','yes'=>'Optional (Extra)'),'label'=>$part['Part']['part_name'])
				),
				)
			));
			$i++;
		}
		echo "</table></div>";
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
