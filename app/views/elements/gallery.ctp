<?
	$horiz = in_array($product['Product']['code'], array('RL'));

	$thumbsize = $horiz ? "-100x50" : "-50x50";
	$previewsize = $horiz ? "-700x300" : "-450x450";

	$prodoptions = Set::combine($products, "{n}.prod", "{n}.pricing_name");
?>

<?#= $this->Form->select("gallery_product", $prodoptions, null, array('id'=>'GallerySelect','empty'=>false)); ?>
<div id="gallery_container" class="gallery <?= $product['Product']['prod'] ?>">
<?
	$previews = array();
	$thumbs = array();
	$larger = array();
?>
	<? $allpreviews = array(); $i = 0; foreach($products as $p) { 
		$prod = $p['prod'];
		$pid = $p['product_type_id'];
		$thumbs[$pid] = array();

		$rel = $related_products_by_id[$pid];
		foreach($rel['ProductSampleImages'] as $img) { 
			$rid = $img['product_type_id'];
			$imgid = $img['product_image_id'];
			$imgext = $img['file_ext'];

			$thumbs[$rid][$imgid] = "/images/galleries/cached/products/$prod/$imgid/$thumbsize.$imgext";
			$previews[$imgid] = "/images/galleries/cached/products/$prod/$imgid/$previewsize.$imgext";
			$larger[$imgid] = "/images/galleries/products/$prod/$imgid.$imgext";

			$allpreviews[$imgid] = $previews[$imgid];
			$alldescriptions[$imgid] = $img['description'];
			if(empty($firstid)) { $firstid = $imgid; }
		}
		# Generate easy list of urls.... for reference
		if(empty($thumbs)) { continue; }
	}
	?>
	<div class="preview">
		<div align="center" style="font-size: 12px; font-weight: bold;" class="description ">
			<?= !empty($alldescriptions[$firstid]) ? $alldescriptions[$firstid] : null ?>
		</div>
		<a href="javascript:void(0)" class="prev"></a>
		<a href="javascript:void(0)" class="next"></a>
		<a class="larger" rel="shadowbox" href="<?= $larger[$firstid] ?>">
			<img id="preview_<?= $firstid ?>" src="<?= $allpreviews[$firstid]; ?>"/>
		</a>
		<div class="clear"></div>
		<div align="center">
			<br/>
			<br/>
			<br/>
			<a href="/custom_images?prod=<?= $product['Product']['code'] ?>"><img src="/images/buttons/Start-Designing.gif"/></a>
		</div>
	</div>
	<div class="thumbs">
	<? $i = 0; foreach($products as $p) { 

		$pid = $p['product_type_id'];
		if(empty($thumbs[$pid])) { continue; }
	?>
		<h3><?= $p['pricing_name'] ?></h3>
		<? foreach($thumbs[$pid] as $imgid => $thumburl) { 
			$previewurl = $previews[$imgid];
			$largerurl = $larger[$imgid];
		?>
		<div class="thumb <?= $i++ == 0 ? "selected":"" ?>">
			<a id="thumb_<?= $imgid ?>" href="<?= $previewurl ?>" rel="<?= $largerurl ?>">
				<img src="<?= $thumburl ?>"/>
			</a>
		</div>
		<? } ?>
		<div class="clear"></div>
	<? } ?>
	</div>
	<div class="clear"></div>
</div>
<script>
var descriptions = <?= json_encode($alldescriptions); ?>;

j('.gallery .thumb a').click(function(e) {
	var href = j(this).attr('href');
	var larger_href = j(this).attr('rel');

	j('.gallery .thumb').removeClass('selected');
	j(this).closest('.thumb').addClass('selected');

	var preview = j(this).closest('.gallery').find('.preview');
	var oldimg = preview.find('a.larger');
	var newimg = j("<a class='larger' rel='shadowbox' href='"+larger_href+"'><img/></a>").hide();
	var id = j(this).attr('id').replace(/^thumb_/, "");
	newimg.attr('id', "preview_"+id);

	oldimg.after(newimg);
	newimg.find('img').load(function() { oldimg.fadeOut().remove(); newimg.fadeIn(); });
	newimg.find('img').attr('src', href);
	preview.find('.description').html(descriptions[id]);

	Shadowbox.setup(newimg, {});

	e.preventDefault();
	return false;
});
j('#gallery_container .prev').click(function() {
	var id = j('.preview img').attr('id').replace(/^preview_/, "");
	var thumb = j('#thumb_'+id).closest('div.thumb').prevAll('div.thumb:first').find('a');
	if(!thumb) { thumb = j('.thumbs a:last'); }
	thumb.click();
});
j('#gallery_container .next').click(function() {
	var id = j('.preview img').attr('id').replace(/^preview_/, "");
	var thumb = j('#thumb_'+id).closest('div.thumb').nextAll('div.thumb:first').find('a');
	if(!thumb) { thumb = j('.thumbs a:first'); }
	thumb.click();
});

j('#GallerySelect').change(function() {
	j('.gallery').hide();
	j('#gallery_'+j(this).val()).show();

});
j('.preview').hover(function() { j(this).addClass('hover'); }, function() { j(this).removeClass('hover'); });
</script>

<style>
.thumbs
{
	float: left;
	width: 250px;
	background-color: #000;
	padding: 5px;
}

.thumbs h3
{
	margin: 10px 0px 0px 5px;
	color: white;
}
.thumbs .thumb
{
	float: left;
	<? if(!empty($horiz)) { ?>
	width: 100px;;
	<? } else { ?>
	width: 50px;
	<? } ?>
	height: 50px;
	border: solid black 3px;
	text-align: center;
	margin: 3px;
}
.thumbs .thumb a
{
	background-color: white;
	display: block;
}
.thumb.selected
{
	border: solid #FF9900 3px;
}
.preview
{
	position: relative;
	float: right;
	width: 450px;
	/*overflow: hidden;*/
	text-align: center;
	padding: 10px;
}
.preview img
{
	display: block;
	margin: 0 auto;
}
#gallery_container.customruler .preview,
#gallery_container.customruler .thumbs
{
	float: none;
	width: 100%;
}
</style>

<div class="clear"></div>
