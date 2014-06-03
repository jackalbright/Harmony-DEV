<div style="width: 450px;">

<?= $snippets['wholesale_pricing'] ?>

<p class="alert">
Please note:  Surcharges may apply to high value or rare stamps used on products.  
</p>
<?
$custom_products = array();
$stock_products = array();
foreach($all_products as $p)
{
	$code = $p['Product']['code'];
	$name = $hd->pluralize( preg_replace("/^Custom /", "", (!empty($p['Product']['short_name']) ? $p['Product']['short_name'] : $p['Product']['name'])) );
	if(!empty($p['Product']['is_stock_item']))
	{
		$stock_products[$code] = $name;
	} else {
		$custom_products[$code] = $name;
	}

}
asort($custom_products);
asort($stock_products);

$prod = !empty($_REQUEST['prod']) ? $_REQUEST['prod'] : null;
?>

<form id="form" method="GET">
<div class="bold">View wholesale pricing for:</div>
<select name="prod" onChange="$('form').submit();">
	<option value="">All Products</option>
	
		<optgroup label="Custom" style="font-style: normal; font-weight: bold;">
		<? foreach($custom_products as $code=>$name) { ?>
			<option <?= !empty($prod) && $prod == $code ? "selected='selected'":"" ?> value="<?= $code ?>">
				&nbsp;	
				<?= $name; ?>
			</option>
		<? } ?>
		</optgroup>
		<optgroup label="Stock" style="font-style: normal; font-weight: bold;">
		<? foreach($stock_products as $code=>$name) { ?>
			<option <?= !empty($prod) && $prod == $code ? "selected='selected'":"" ?> value="<?= $code ?>">
				&nbsp;	
				<?= $name; ?>
			</option>
		<? } ?>
		</optgroup>
</select>
<!--
<a href="/products/wholesale_pricing?prod=">All products</a>
-->
</form>

<?= $this->element("products/wholesale_pricing"); ?>




</div>
