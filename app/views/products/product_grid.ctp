<?

if (!isset($items_per_row)) { 
	$items_per_row = 4;
}

?>

<div class="product_grid">	

<? if(isset($title)) { ?>
<div class="title"><?= $title ?></div>
<? } ?>
<?php
echo __line__ . "views/products/product_grid.ctp <br>"
?>
<table class="product_table" cellpadding=2 width="100%" border=1>
	<? 
		$i = 0; 
		#print_r($products);
		$row = 0;
		$column = 0;
		for ($i = 0; $i < count($products); $i++)
		{
			$product = $products[$i];
			if($i % $items_per_row == 0 && $i > 0) { ?> </tr> <? $row++; $column = 0; } 
			if($i % $items_per_row == 0) { ?> <tr class=""> <? } 
			?>
				<td valign=top class="itemDisplay" align=center>
					<a class="no_underline" href="/details/<?= $product['Product']['prod']?>.php">
						<img src="/images/products/thumbnail/<?= $product['Product']['code'] ?>.png">
					</a><br/>
					<!--<a class="underline" href="/details/<?= $product['Product']['prod']?>.php"><nobr><?= $product['Product']['short_name'] ? $product['Product']['short_name'] : $product['Product']['name']; ?>s</nobr>-->
					<a class="underline" href="/details/<?= $product['Product']['prod']?>.php"><?= $product['Product']['short_name'] ? $product['Product']['short_name'] : $product['Product']['name']; ?>s
					</a>
					<? if (isset($product_build_link)) { ?>
						<br/>
						[<a class="underline" href="/details/<?= $product['Product']['prod']?>.php">more info</a>]
						<br/>
						<br/>
						<form method="GET" action="/products/select/<?= $product['Product']['code'] ?>">
							<input type="submit" value="Create Product &raquo;">
						</form>

					<? } ?>
				</td>
			<?
		}

	?>
</table>

</div>
