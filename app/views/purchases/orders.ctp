<div class="purchases index">
<h2><?php __('Previous Orders');?></h2>

<? if(empty($purchases) && empty($searched)) { ?>

<div class="alert2">You have no previous orders</div>


<? } else { ?>

<script>
function updateReorderPricing(item_id, quantity)
{
	new Ajax.Updater('pricing_'+item_id, "/purchases/reorder_pricing/"+item_id+"/"+quantity, 
		{ evalScripts: true, asynchronous: false });
}
function confirmChecked()
{
	var reorders = $$('.reorder');
	var checked = false;
	reorders.each(function(c) {
		if($(c).checked)
		{
			checked = true;
		}
	});
	if(!checked)
	{
		alert("Please checkmark which items you wish to reorder");
	}
	return checked;
}
</script>

<? if(empty($readonly) && !empty($purchases)) { ?>
<div align="right" class=" right alert2">
	<input type="image" src="/images/webButtons2014/orange/large/addToCart.png" onClick="if(confirmChecked()) { $('reorder_form').submit(); }"/>
	<br/>
		You can modify your custom items once they are added to your cart.	
</div>
<? } ?>
<div class="left">
	<script>
	function showInput(id)
	{
		$$('.values').each(function(i) { i.addClassName('hidden') });
		$(id).removeClassName('hidden');
	}
	</script>
	<?= $form->create("Purchase", array('url'=>'/purchases')); ?>
	<table> <tr>
	<td>
		Search by: &nbsp;
	</td>
	<td valign="top">
	<? $fields = array(
		'Purchase_id'=>"Order #",
		'customer_po'=>'PO #',
		'product_type_id'=>"Product",
		"dates"=>"Date(s)",
	);
	$field = !empty($this->data['Purchase']['field']) ? $this->data['Purchase']['field'] : "Purchase_id";
	?>
		<?= $form->input("field", array('div'=>array('class'=>'left'),'type'=>'select','label'=>false,'options'=>$fields,'onChange'=>"if(this.value == 'product_type_id') { showInput('product_type_id'); } else if(this.value == 'dates') { showInput('dates'); } else { showInput('search_value'); }")); ?>
	</td><td valign="top">
			<?= $form->input("value", array('div'=>array('id'=>'search_value','class'=>($field == 'product_type_id' || $field == 'dates' ? "hidden" : ""). ' values'),'label'=>false)); ?>
		<?= $form->input("product_type_id", array('type'=>'select','label'=>false,'options'=>$products, 'div'=>array('id'=>'product_type_id','class'=>($field == 'product_type_id' ? "" : "hidden")." values"))); ?>
		<div id="dates" style="width: 300px;" class="values <?= $field == 'dates' ? "":"hidden" ?>">
		<?= $form->input("date_start",array('size'=>10,'div'=>array('class'=>'left'),'label'=>false,'after'=>'<br/>mm/dd/yyyy')); ?>
		<div class="left">&nbsp;to&nbsp;</div>
		<?= $form->input("date_end",array('size'=>10,'div'=>array('class'=>'left'),'label'=>false,'after'=>'<br/>mm/dd/yyyy')); ?>
		</div>
		<div class="clear"></div>
	</td><td valign="top">
	<?= $form->submit("/images/buttons/small/Search-grey.gif",array('div'=>array('class'=>'left'),'type'=>'image')); ?>
	<? if(!empty($searched)) { ?>&nbsp; <a href="/purchases">Start over</a><? } ?>
	</td>
	</tr></table>
	<?= $form->end(); ?>
	<div class="clear"></div>
</div>
<? if(empty($purchases) && !empty($searched)) { ?>
<div class="clear"></div>
	<div class="alert2">No orders found matching search criteria</div>
<? } else { ?>
<form method="POST" action="/purchases/reorder" id="reorder_form">
<div class="clear"></div>
<br/>
<div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<?= $paginator->counter(array( 'format' => __('Page %page% of %pages%', true))); ?>
<div class="clear"></div>
</div>
<style>
#Orders th
{
	color: white;
	background-color: #7777CC;
}
</style>
<table id='Orders' width="100%" border=0 cellspacing=0 cellpadding=5 style="border: solid #AAA 1px;">
<tr>
	<th>Date</th>
	<th>Order #</th>
	<th>PO #</th>
	<th align="center">Preview</th>
	<th>Catalog #</th>
	<th>Description</th>
	<th>Quantity</th>
	<th>Ext. Price</th>
	<? if(empty($readonly)) { ?>
	<th align="center">Reorder?</th>
	<? } ?>
</tr>
<?
	$OrderItem = ClassRegistry::init("OrderItem");
	$purchase_id = null;
?>
<? $i = 0; foreach($purchases as $p) { 
	$item = $p['OrderItem'];
	$purchase_id = $p['OrderItem']['Purchase_id'];
	#foreach($p['OrderItem'] as $item) { 
	$item_id = $item['order_item_id'];
	$product = $p['Product'];
	$minimum = $product['minimum'];
	$sides = $p['ItemPart'];
?>
<? if(!empty($previous_purchase_id) && $previous_purchase_id != $purchase_id) { ?>
<tr>
	<td colspan=9>
		<hr/>
	</td>
</tr>
<? } ?>
<tr style="background-color: <?= $i % 2 == 0 ? "#FFF" : "#DDD"; ?>; ">
	<td width="100">
		<?= date("n/j/Y", strtotime($p['Purchase']['Order_Date'])); ?>
	</td>
	<td valign="middle" width="75">
		<?= $p['Purchase']['purchase_id'] ?>
		<? if(!empty($this->params['admin'])) { ?>
		<br/>
			<?= $this->Html->link("Delete", array('action'=>'delete',$p['Purchase']['purchase_id']), array('class'=>'red','confirm'=>"Are you sure you want to remove order #{$p['Purchase']['purchase_id']}?")); ?>
		<? } ?>
	</td>
	<td width="75">
		<?= $p['Purchase']['customer_po'] ?>
	</td>
	<td align="center" valign="top" width="225">
		<? if(!empty($item['new_build'])) { ?>
			<a rel='shadowbox' href="/designs/png/1/order_item_id:<?=$item['order_item_id'] ?>.png">
				<img src="/designs/png/1/width:100/order_item_id:<?=$item['order_item_id'] ?>">
			</a>
			<? if(count($sides) > 1) { ?>
			<a rel='shadowbox' href="/designs/png/2/order_item_id:<?=$item['order_item_id'] ?>.png">
				<img src="/designs/png/2/width:100/order_item_id:<?=$item['order_item_id'] ?>">
			</a>
			<? } ?>
		<? } else { ?>
			<?= $this->element("build/preview",array('scale'=>'-150x100','order_item_id'=>$item_id,'no_view_larger'=>true)); ?>
		<? } ?>
	</td>
	<td valign="middle">
		<?= $OrderItem->getItemNumber($p); ?>
	</td>
	<td valign="middle">
		<?= $OrderItem->getItemDescription($p); ?>
	</td>
	<td valign="middle" width="75">
		<? if(!empty($readonly)) { ?>
			<?= $item['Quantity'] ?>
		<? } else { ?>
			<input size=5 type="text" name="data[OrderItem][<?=$i?>][quantity]" value="<?= $item['Quantity'] ?>" onChange="if(this.value < parseInt('<?= $minimum ?>')) { alert('Minimum is <?=$minimum?>'); this.value = '<?=$minimum?>'; return false; } else { updateReorderPricing('<?=$item_id ?>', this.value); }"/>
		<? } ?>
	</td>
	<td valign="middle" width="75">
		<div id="pricing_<?=$item_id ?>">
			<?= sprintf("$%.02f", $item['Quantity']*$item['Price']); ?>
		</div>
	</td>
	<? if(empty($readonly)) { ?>
	<td align="center">
		<input class="reorder" id="reorder_<?=$i ?>" type="checkbox" name="data[OrderItem][<?=$i?>][reorder]" value="<?= $item_id; ?>"/>
	</td>
	<? } ?>
</tr>
<? 
	$previous_purchase_id = $purchase_id; $i++; #}
} ?>
</table>

<div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<?= $paginator->counter(array( 'format' => __('Page %page% of %pages%', true))); ?>
<div class="clear"></div>
</div>

<? if(empty($readonly) && !empty($purchases)) { ?>
<div align="right">
	<input type="image" src="/images/webButtons2014/orange/large/addToCart.png" onClick="return confirmChecked();"/>
</div>
<? } ?>
</form>
<? } ?>

<br/>
<br/>



<? } ?>

</div>


