<?
if (!isset($productSampleImages) && isset($product['ProductSampleImages']))
{
	$productSampleImages = $product['ProductSampleImages'];
}
if (isset($product['Product']))
{
	$product = $product['Product'];
}

$path = "products/".$product['prod'];

if (!isset($gallery_title)) { $gallery_title = 'Sample Gallery'; }
$pathclass = "image_gallery_" . preg_replace("/\//", "_", $path);

#error_log("P=$path");

#print_r($product);
$file_count = count($productSampleImages);

if ($file_count > 0)
{
	$underpath = preg_replace("/\W+/", "_", $path);
?>
	<div class="image_gallery <?= $pathclass ?>">
		<div class="subtitle"><div><?= $gallery_title ?></div></div>
		<table class="image_gallery_nav" width="100%">
		<tr><td align=left>
			<button class="image_gallery_button" onClick="sample_image_gallery_previous('<?= $underpath ?>');">&laquo; Previous</button>
		</td>
		<td align=center id="image_gallery_counter_<?=$underpath?>">1 of <?= $file_count ?></td>
		<td align=right>
			<button class="image_gallery_button" onClick="sample_image_gallery_next('<?= $underpath ?>');">Next &raquo;</button>
		</td></tr>
		</table>
		<br/>

		<? 

		$i = 0;
		foreach($productSampleImages as $image) 
		{ 
			$hidden = $i++ > 0 ? "hidden" : "";
		?>
			<div class="sample_image_<?=$underpath ?> <?= $hidden ?>">
				<a title="<?= $image['title'] ?>" rel="shadowbox[<?=$underpath?>]" id="image_gallery_largelink1_<?=$underpath?>" href="/images/galleries/<?= $path ?>/<?= $image['product_image_id'] ?>.<?=$image['file_ext'] ?>">
					<img border="0" src="/images/galleries/<?= $path ?>/display/<?= $image['product_image_id'] ?>.<?=$image['file_ext'] ?>" id="image_gallery_<?=$underpath?>"/>
				<br/>+ View Larger</a>
			</div>
		<?
		}
		?>
	</div>

<?
}
?>
