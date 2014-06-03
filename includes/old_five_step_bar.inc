<table width="100%" id="five_step_bar">
<?
$path = $_SERVER['SCRIPT_NAME'];
#echo "P=$path";
$product_step = 1; 
$gallery_step = 2;

$step = 1;
$prod = '';
$catalogNumber = '';
$imageID = '';
if (!empty($_SESSION['build']['product'])) { $prod = $_SESSION['build']['product']; }
if (!empty($_SESSION['build']['catalogNumber'])) { $catalogNumber = $_SESSION['build']['catalogNumber']; }
if (!empty($_SESSION['build']['imageID'])) { $imageID = $_SESSION['build']['imageID']; }
#print_r($_SESSION);

if (preg_match("/\/(gallery|browse|custom)/", $path) && !$prod) {
	$gallery_step = 1;
	$product_step = 2;
}
# Since we've not chosen a product, and we're browsing images, assume first step.

# TODO: dont select a product until we've clicked on the button proactively!

if (preg_match("/^\/(gallery|browse|custom|product\/detail|product\/browse|details\/build_select)/", $path)) { $step = $gallery_step; }
else if (preg_match("/^\/(products|details)/", $path)) { $step = $product_step; }
else if (preg_match("/^\/(build\/customize|product\/build)/", $path)) { $step = 3; }
else if (preg_match("/^\/(build\/personalize)/", $path)) { $step = 4; }
else if (preg_match("/^\/(checkout)/", $path)) { $step = 5; }


?>
<tr>
	<? if ($product_step < $gallery_step) { ?>
		<td class="<?= ($step == $product_step) ? 'five_step_selected' : ''; ?>">
			<div class="five_step_step_title">
				<?=$product_step?>) 
				<a href="/products/">Choose Your Product</a>
			</div>
		</td>
		<td class="<?= ($step == $gallery_step) ? 'five_step_selected' : ''; ?>">
			<div class="five_step_step_title">
				<?=$gallery_step?>) 
				<a href="/gallery/">Choose Your Image</a>
			</div>
		</td>
	<? } else { ?>
		<td class="<?= ($step == $gallery_step) ? 'five_step_selected' : ''; ?>">
			<div class="five_step_step_title">
				<?=$gallery_step?>) 
				<a href="/gallery/">Choose Your Image</a>
			</div>
		</td>
		<td class="<?= ($step == $product_step) ? 'five_step_selected' : ''; ?>">
			<div class="five_step_step_title">
				<?=$product_step?>) 
				<a href="/products/">Choose Your Product</a>
			</div>
		</td>
	<? } ?>
	<td class="<?= ($step == 3) ? 'five_step_selected' : ''; ?>">
		<div class="five_step_step_title">
			3) 
			<? if ($prod && ($imageID || $catalogNumber)) { ?>
			<a href="/build/customize.php">Customize Product</a>
			<? } else { ?>
			Customize Product
			<? } ?>
		</div>
	</td>
	<td class="<?= ($step == 4) ? 'five_step_selected' : ''; ?>">
		<div class="five_step_step_title">
			4) 
			<? if ($step >= 4) { # Step 3 complete already... ie build['customize']['complete'], etc...
			?>
			<a href="/build/personalize.php">Add Personalization</a>
			<? } else { ?>
			Add Personalization
			<? } ?>
		</div>
	</td>
	<td class="<?= ($step == 5) ? 'five_step_selected' : ''; ?>">
		<div class="five_step_step_title">
			5) 
			<? if ($step >= 5) { ?>
			<a href="/checkout/">Checkout</a>
			<? } else { ?>
			Checkout
			<? } ?>
		</div>
	</td>
</tr>
<tr>
	<td colspan=5 class="five_step_options">
	<? if ($step == $product_step) { ?>
		<a href="/products/">
		View All Products
		</a>
	<? } else if ($step == $gallery_step) { ?>
		<a href="/gallery/browse.php">Browse Our Gallery</a>
		<span class="bold"> OR </span>
		<a href="/gallery/my_images/">Upload Your Own Image</a>
	<? } else if ($step == 3) { ?>
	<? } else if ($step == 4) { ?>
	<? } else if ($step == 5) { ?>
	<? } ?>
		&nbsp;
	</td>
</tr>
</table>
