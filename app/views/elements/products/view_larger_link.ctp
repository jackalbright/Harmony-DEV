<?
$this->set("shadowbox", true); 

$imgtype = "";
$imgid = "";
$layout = !empty($preview_layout) ? "-$preview_layout" : "";

if (empty($prod))
{
	$prod = !empty($build['Product']['code']) ? $build['Product']['code'] : null;
}

if (empty($image))
{
	$image = $build;
}

if (!empty($image['CustomImage']))
{
	$imgtype = 'Custom';
	$imgid = $image['CustomImage']['Image_ID'];

} else if (!empty($image['GalleryImage'])) {
	$imgtype = 'Gallery';
	$imgid = $image['GalleryImage']['catalog_number'];
}

if ($prod && $imgtype && $imgid)
{
?>
<br/>
<a style="text-decoration: none;" rel="shadowbox" href="/images/preview/<?= $prod ?><?= $layout ?>/<?= $imgtype ?>/<?= $imgid ?>.png">+ View Larger</a>
<br/>
<br/>
<? } ?>
