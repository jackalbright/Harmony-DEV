<?
$this->set("shadowbox",true);
if(!isset($product_name))
{
	$product_name = "Gifts";
}

?>
			<? /*
			<? if (!empty($product['Product'])) { ?>
				<img class="" style="" src="/product_image/view/<?= $prod ?>/Gallery/<?= $image['GalleryImage']['catalog_number'] ?>/150">
			<? } else { ?>
				<img class="stamp_thumbnail" style="height: 115px;" src="<?= $image['GalleryImage']['image_location'] ?>">
			<? } ?>
			<?  */ ?>
			<?
			$max_w = 140;
			$height = 115;
			$width = "";
			$prod = $product['Product']['code'];

			$imagefile = APP . "/../".$image['GalleryImage']['image_location'];
			$image_exists = false;
			if (file_exists($imagefile))
			{
				list ($w,$h) = getimagesize($imagefile);
				$w2h = $w/$h;
				$width = ceil($height*$w2h);
				if ($width > $max_w)
				{
					$width = $max_w;
					$height = ceil($width / $w2h);
				}
				$image_exists = true;
			}

			$img_width = 150;
			$img_height = 150;

			$stamp_name = $image['GalleryImage']['stamp_name'] . " (#" . $image["GalleryImage"]['catalog_number'] . ")";

			?>
			<div style="width: <?= $max_w+10+8 ?>px;">
				<? if (!empty($product['Product']) && $image_exists) { ?>
					<a href="/build/create/<?= $prod ?>?catalog_number=<?=$image['GalleryImage']['catalog_number']?>&customize=1&start_over=1">
					<img class="hidden" src="/images/preview/<?= $prod ?>/Gallery/_<?=$image['GalleryImage']['catalog_number']?>/-<?= $width ?>x<?= $height ?>.png">
					<img src="/images/preview/<?= $prod ?>/Gallery/_<?=$image['GalleryImage']['catalog_number']?>/-150x150.png">
					</a>
				<? } else { ?>
					<a href="/gallery/view/<?=$image['GalleryImage']['catalog_number']?>"><img class="<?= !empty($image['GalleryImage']) ? "stamp_thumbnail" : "" ?>" style="width: <?= $width ?>px; height: <?= $height ?>px;" src="<?= $image['GalleryImage']['image_location'] ?>"></a>
				<? } ?>
			</div>
		<? if (!empty($product['Product']) && $image_exists) { ?>
			<a href="/build/create/<?= $prod ?>?catalog_number=<?=$image['GalleryImage']['catalog_number']?>&customize=1&start_over=1">"<?= $stamp_name ?>" <?= $product['Product']['name'] ?></a>
		<? } else { ?>
			<a href="/gallery/view/<?=$image['GalleryImage']['catalog_number']?>"><?= $stamp_name ?></a>
		<? } ?>
		<?
			$min_pricing = 0;
			$max_pricing = 0;
			if(!empty($product['ProductPricing']))
			{
				$pricing_level = !empty($effective_customer['pricing_level']) ? $effective_customer['pricing_level'] : 1;

				foreach($product['ProductPricing'] as $product_pricing)
				{
					# XXX
					if(empty($max_pricing))
					{
						$max_pricing = $product_pricing['price'];
					}

					if($min_pricing <= 0 || $min_pricing > $product_pricing['price'])
					{
						$min_pricing = $product_pricing['price'];
					}

				}
			}

		?>
		<? if($min_pricing > 0) { ?>
			<div style="color: #333; font-weight: bold;">Price <?= sprintf("$%.02f - $%.02f", $min_pricing, $max_pricing); ?> ea</div>
			<div>Minimum: <?= $product['Product']['minimum'] ?></div>
		<? } ?>


