<? $this->set("showPleaseWait", count($products)); ?>

<?= $this->element("steps/steps",array('step'=>'product', 'gallery'=>1)); ?>
<div>

<div class="right" style="padding-right: 20px;">
	<?= $this->element("build/free"); ?>
	<br/>
	<?= $this->element("products/availability_notice"); ?>

</div>


<div class="" style="width: 500px;">

<p><? 
$str = $image['GalleryImage']['long_description'];
$maxlen = 200;
if(strlen($str) > $maxlen)
{
	$substr = substr($str, 0, $maxlen);
	while(preg_match("/\w$/", $substr)) { $substr = substr($str, 0, strlen($substr)-1); }
?>
	<div id="short_desc">
		<?= $substr ?>...
		<a href="Javascript:void(0);" onClick="$('long_desc').removeClassName('hidden'); $('short_desc').addClassName('hidden');"> more information</a>
	</div>
	<div id="long_desc" class="hidden">
		<?= $str ?>
			<a href="Javascript:void(0);" onClick="$('long_desc').addClassName('hidden'); $('short_desc').removeClassName('hidden');"> hide information</a>
	</div>
<?
} else {
	?><?= $str ?><?
}
?>

<br/>
<div class="note">Catalog Number: <?= $image['GalleryImage']['catalog_number'] ?></div>

<div class="hidden" id="long_description">
	<div align="right"><a href="Javascript:void(0)" onClick="hideblock('long_description')">Hide information</a></div>
	<p><?= $image['GalleryImage']['long_description'] ?>

	 This <? $fv = $image['GalleryImage']['face_value']; if($fv > 0) { $fv >= 1 ? sprintf("$%.02f", $fv) : sprintf("%.02f&#162;", $fv); } ?> 
	stamp was issued by the <?= isset($image['GalleryImage']['country']) ? $image['GalleryImage']['country'] : ""; ?> Postal Service
	<? if (!empty($image["GalleryImage"]['issue_date'])) { ?> on <?= $hd->unixToHumanDate($image['GalleryImage']['issue_date']); ?><? } ?>
	<? if ($image['GalleryImage']['series'] != '' && $image['GalleryImage']['series'] != 'non series issue') { ?> as part of the <?= $image['GalleryImage']['series'] ?> series<? } ?>
	.</p>
</div>


</div>

<div class="clear"></div>

<? if(!empty($is_admin)) { ?>
<div>
	<a href="/admin/products/select?catalog_number=<?= $image['GalleryImage']['catalog_number']?>">Send Email</a>
</div>
<? } ?>
<? 
echo $this->element("products/product_grid", array('image'=>$image,'live'=>1,'details'=>1,'no_view_larger'=>1,'product_build_link'=>1,'links'=>$this->element("gallery/switch_layout"))); 
?>
