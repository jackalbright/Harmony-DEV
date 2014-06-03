<div>
<?
if(!isset($products)) { $products = $compare_products; }
$pid = $products[0]['product_type_id'];
$prod = $products[0]['prod'];
$code = $products[0]['code'];
$pimg = $related_products_by_id[$pid]['ProductSampleImages'][0];
$imgid = $pimg['product_image_id'];
$imgext = $pimg['file_ext'];
$size = $code == "RL" ? "-700x400" : "-350x500";
$pimgpath = "/images/galleries/cached/products/$prod/$imgid/$size.$imgext";
$full_pimgpath = "/images/galleries/products/$prod/$imgid.$imgext";

?>
<div class="overview <?= $code ?>">
	<div class="image">
		<a href="<?= $full_pimgpath ?>" rel="shadowbox">
			<img src="<?= $pimgpath ?>"/>
		</a>
	</div>
	<div class="info">
		<div class="details">
			<?= $product['Product']['description'] ?>
		</div>
		<div class="free">
			<? if(!empty($product['Product']['free_with_your_order'])) { ?>
				<?= $product['Product']['free_with_your_order']; ?>
				<br/>
			<? } ?>
	
			<?
				$code = $product['Product']['code'];
				$prices = $compare_pricings[$code][0]['pricing_data'];
				$highPrice = $prices[0]['price'];
				$lowPrice = $prices[count($prices)-1]['price'];
			?>
			<div class="bold">
				<div class="left">Price:&nbsp;</div>
				<div class="left">
				<a href="javascript:void(0)" onClick="j('#pricing_tab').click(); j(window).scrollTo('#tabs', 100, { offset: {top: -75}});">
					<?= sprintf("$%.02f - $%.02f ea.", $lowPrice, $highPrice); ?>
				</a><br/>
				<a href="javascript:void(0)" onClick="j('#pricing_tab').click(); j(window).scrollTo('#tabs', 100, { offset: {top: -75}});">
					Bulk Pricing
				</a>
				</div>
				<div class="clear"></div>
				<br/>
			</div>

		<div style="font-size: 12px; font-weight: bold;">
		<? if($code == 'ORN') { ?>
			You might also like <a href="/details/ceramic_ornament.php">Ceramic Ornaments</a>
		<? } else if ($code == 'ORN-CER') { ?>
			You might also like <a href="/details/ornament.php">Laminated Ornaments</a>
		<? } ?>
		</div>

		</div>
	</div>
	<div class="clear"></div>
</div>
<style>
.overview
{
}
.overview .image
{
	float: left;
	width: 350px;
	text-align: center;
}
.overview .info
{
	float: right;
	width: 50%;
	border-left: solid #CCC 1px;
}
.overview .details
{
	padding: 10px;
}
.overview .free
{
	padding: 10px;
}

.overview.RL .image
{
	float:none;
	width:100%;
}
.overview.RL .info
{
	width: 100%;
	clear: left;
	float: none;
	border: none;
	border-top: solid #CCC 1px;
}
.overview.RL .details,
.overview.RL .free
{
	float: left;
	width: 325px;
}
</style>

</div>
