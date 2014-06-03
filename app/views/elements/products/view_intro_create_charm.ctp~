<?
if (!isset($position) || $position != 'bottom') { $position = 'top'; }

if ($position == 'top') {
?>
<div style="text-align: right;">
	<div class="border padded margin_bottom_small">
	<?
	echo $hd->product_element("products/create_button", $product['Product']['prod'], array('product'=>$product['Product'],'list_link'=>1)); 
	if ($position == 'bottom')
	{
	?>
		<img src="/images/products/diagram/<?=$product['Product']['code']?>.jpg">
	<?
	}
	?> </div> <?
	$subProducts = $product['RelatedProducts'];
	if(isset($subProducts) && count($subProducts)) {
		foreach($subProducts as $subProduct) {
			if ($subProduct['buildable'] == 'yes')
			{
				?> <div class="border padded margin_bottom_small"> <?
				echo $this->element("products/create_button", array('product'=>$subProduct));
				if ($position == 'bottom')
				{
				?>
				<img src="/images/products/diagram/<?=$subProduct['code']?>.jpg"> 
				<?
				}
				?> </div> <?
			}
		}
	} ?>

</div>

<? } else { ?>
&nbsp;
<? } ?>
