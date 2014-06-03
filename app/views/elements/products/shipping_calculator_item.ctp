<? if(empty($i)) { $i = 0; } ?>
<?
$class = !empty($required) ? "required" : "";
?>
<tr id="">
<td colspan=2>
	<?php 

	//$theDefault = array("Choose a Product");
	//$theArray = array_merge($theDefault,$all_products_map);
	//echo $form->select("Products.$i.code",array_merge(array(' '=>'[Choose a product]'), $all_products_map),null,array('class'=>$class,'title'=>'Product'),false);
	?>
    <!--<select id="Products0Code" name="data[Products][0][code]">-->
    <select id="Products<?php echo $i;?>code" name="data[Products][<?php echo $i;?>][code]">
    <option value=" ">Select a Product</option>
    <?php
	foreach ($all_products_map as $key=>$value){
		echo "<option value='$key'>$value</option>\n";
	}
	?>
    </select>

</td>
<td align="right">
	<?= $form->text("Products.$i.quantity",array('size'=>5,'class'=>$class,'title'=>'Quantity')); ?>
</td>
</tr>

