<? $sid = "imageScroller".rand(10000,999999); ?>
<div id="<?= $sid ?>" class="jcarousel_container" style="<?= empty($images) ? "display:none;":"" ?>">
	<a href="javascript:void(0)" class='jcarousel_left'></a>
	<div class='jcarousel'>
	<ul>
	<? foreach($images as $image) { 
		$id = $image['CustomImage']['Image_ID'];
		$imgid = "CustomImage".$id.rand(10000,50000); # MUST be random so both sides work ok.
	?>
	<li>
		<?= $this->Html->link($this->Html->image($image['CustomImage']['thumbnail_location']), "javascript:void(0)", array('id'=>$imgid,'escape'=>false)); ?>
		<script>
		j('#<?= $imgid ?>').click(function() {
			var side = j(this).closest('.accordion').attr('id').replace(/^accordion/,"");
			var filename = '<?= !empty($image['CustomImage']['filename']) ? '/'.$image['CustomImage']['path'].'/'.$image['CustomImage']['filename'] : $image['CustomImage']['display_location'] # Default to old version, but prefer large one. ?>';

			// clear crop.
			j('#'+side+'_crop_x, #'+side+'_crop_y, #'+side+'_crop_w, #'+side+'_crop_h').val(''); // clear so not distorted.
			j('#DesignSide'+side+'ImageNone').val('');

			j('#CustomImage'+side+'Filename').val(filename).change();
			j('#DesignSide'+side+'CustomImageID').val('<?=$id ?>');

			j('#DesignForm').save(); 
		});
		</script>
	</li>
	<? } ?>
	</ul>
	</div>
	<a href="javascript:void(0)" class='jcarousel_right'></a>
</div>
<? if(!empty($images)) { ?>
	<p>To delete pictures, go to <a href="/custom_images">My Pictures</a></p>
<? } ?>
<script>
// this needs to initialize only once step is OPENED.... otherwise sizing is 0.
j('#<?= $sid ?>').waitForImages(function() {
	j(this).find('.jcarousel').jcarousel({
		animation: "fast"
	});

	j(this).find('.jcarousel_left').click(function() {
		j(this).closest('.jcarousel_container').find('.jcarousel').jcarousel('scroll', '-=1');
	});
	j(this).find('.jcarousel_right').click(function() {
		j(this).closest('.jcarousel_container').find('.jcarousel').jcarousel('scroll', '+=1');
	});

	// Hide arrows when at start or end of list.
	/*
	j(this).find('.jcarousel').on('itemfirstin.jcarousel', 'li', function(event, carousel) {
		var li = this;
		if(j(li).is(':first-child')) // first, hide left arrow.
		{
			j(this).closest('.jcarousel_container').find('.jcarousel_left').hide();
		} else {
			j(this).closest('.jcarousel_container').find('.jcarousel_left').show();
		}

	});
	j(this).find('.jcarousel').on('itemlastout.jcarousel', 'li', function(event, carousel) {
		var li = this;
		if(j(li).is(':last-child')) // last, hide right arrow.
		{
			j(this).closest('.jcarousel_container').find('.jcarousel_right').hide();
		} else {
			j(this).closest('.jcarousel_container').find('.jcarousel_right').show();
		}

	});
	*/
});
</script>
