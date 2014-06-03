<?
$itemkey = 'cart_item_id';
$itemvalue = $cartItem['cart_item_id'];
if(!empty($order_item_id))
{
	$itemkey = 'order_item_id';
	$itemvalue = $order_item_id;
}
?>
<? $side1 = $this->Html->image("/designs/png/1/width:100/$itemkey:$itemvalue?rand=".rand(5000,9000)); ?>
<?= $this->Html->link($side1, "/designs/png/1/$itemkey:$itemvalue?rand=".rand(5000,9000), array('rel'=>'shadowbox;player=img','escape'=>false)); ?>

<? if(!empty($cartItem['parts2'])) { ?>
<div class='bold'>Side 1</div>
<br/>
<? $side2 = $this->Html->image("/designs/png/2/width:100/$itemkey:$itemvalue?rand=".rand(5000,9000)); ?>
<?= $this->Html->link($side2, "/designs/png/2/$itemkey:$itemvalue?rand=".rand(5000,9000), array('rel'=>'shadowbox;player=img','escape'=>false)); ?>
<div class='bold'>Side 2</div>
<? } ?>
