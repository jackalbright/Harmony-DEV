<? 
$layout = $this->Session->read("DesignSide.$side.layout");
$hasPicture = ($layout != 'textonly');
if(empty($layout)) { $layout = 'standard'; }
# Above might be obsolete...

$image_id = $this->Session->read("Design.CustomImage.$side.Image_ID"); 
$image_path = $this->Session->read("Design.CustomImage.$side.path"); 
$image_filename = $this->Session->read("Design.CustomImage.$side.filename"); 
$image_location = $this->Session->read("Design.CustomImage.$side.Image_Location"); 
$image_location_png = preg_replace("/[.]\w+$/i", ".png", $image_location);
if($image_location_png != $image_location && file_exists(APP."/webroot/$image_location_png"))
{
	$image_location = $image_location_png;
}

$image_src = $image_filename;
if(!empty($image_filename) && !is_array($image_filename) && !preg_match("/\//", $image_filename))
{
	if(!preg_match("/^\//", $image_src)) { $image_src = "/$image_src"; }
	if(!empty($image_path)) { $image_src = "$image_path$image_src"; }
	if(!preg_match("/^\//", $image_src)) { $image_src = "/$image_src"; }
}
if(empty($image_src) && !empty($image_location))
{
	$image_src = $image_location;
}

?>

<h3 class='side<?=$side?>'><?=$i ?>. Select &amp; Adjust Your Picture (optional)</h3>
<div id="<?= $side ?>_step_image" class='side<?=$side?>'>
	<?= $this->Form->input("DesignSide.$side.imageNone", array('type'=>'hidden')); ?>
	<?= $this->Form->input("CustomImage.$side.filename", array('type'=>'hidden','value'=>$image_src)); ?>
	<?= $this->Form->input("DesignSide.$side.customImageID", array('type'=>'hidden','value'=>$image_id)); ?>

	<div id="ImageUpload<?=$side?>">
		<?= $this->Form->input("CustomImage.$side.file", array('type'=>'file','label'=>'Upload My Picture (optional)')); ?>
		<div class='alert2' style="font-size: 12px;">
			<div class='right'>2 MB limit</div>
			<div>JPEG, JPG, PNG, GIF, TIF, PDF</div>
		</div>
		<div class='clear'></div>
		<br/>
	</div>

	<div class='zoomPictureContainer' style='<?= empty($this->data["CustomImage"][$side]["Filename"]) ? "display:none;":"" ?>'>
		<h3>Zoom My Picture:</h3>
		<div id="zoomPicture<?=$side?>" class="zoomPicture"></div>
	</div>


	<div id="thumbs<?=$side?>" class='thumbs'>
	</div>

		<script>
		j('#CustomImage<?=$side?>File').change(function() {
			//console.log("FILE CHANGE");
			//showPleaseWait();
			j.loading();
			//j('#preview<?=$side?>').layout_image(true); // force layout to include image.

			//console.log("SUBMIT FILE");
			j('#DesignForm').ajaxSubmit({
				//target: '#options',
				url: "/designs/upload/<?=$side?>",
				dataType: 'json',
				success: function(data) {
					j.loading(false);

					if(data.error)
					{
						j.alert(data.error,"Could not upload your picture");
					} else {
						j('#<?=$side?>_crop_x, #<?=$side?>_crop_y, #<?=$side?>_crop_w, #<?=$side?>_crop_h').val(''); // clear so not distorted.
						j('#DesignSide<?=$side?>ImageNone').val('');
						j('#CustomImage<?=$side?>Filename').val(data.CustomImage[<?=$side ?>].Image_Location).change();
						// Image_Location is the PNG version if an odd format.
						j('#DesignSide<?=$side?>CustomImageID').val(data.CustomImage[<?=$side ?>].Image_ID); // Save img_id

						j('#thumbs<?=$side?>').load("/designs/images",function() { });
					}

					//console.log("LOADING LIST OF IMG");

				}
			});
		});
		// Don't load until visible.
		</script>
	

<?= $this->Form->hidden("DesignSide.$side.crop_x", array('id'=>"{$side}_crop_x",'div'=>false,'label'=>false,'size'=>4)); ?>
<?= $this->Form->hidden("DesignSide.$side.crop_y", array('id'=>"{$side}_crop_y",'div'=>false,'label'=>false,'size'=>4)); ?>
<?= $this->Form->hidden("DesignSide.$side.crop_w", array('id'=>"{$side}_crop_w",'div'=>false,'label'=>false,'size'=>4)); ?>
<?= $this->Form->hidden("DesignSide.$side.crop_h", array('id'=>"{$side}_crop_h",'div'=>false,'label'=>false,'size'=>4)); ?>
<script src="/js/zoomAndDrag.js"></script>
<script>
j('#CustomImage<?=$side?>Filename').bind('preview', function() {

	var filename = j(this).val();
	var layout = j('#DesignSide<?=$side?>Layout').val();
	var step = j(this).closest('.ui-accordion-content');

	//console.log("PREVIEW IMAGE <?=$side?> ="+filename);

	var img = j('#preview<?= $side?> .image img');
	var current_filename = j(img).attr('src');

	var placeholder = "/images/trans.gif";//"/images/designs/image-placeholder.png";

	if(!filename) { filename = placeholder; }

	//console.log(j('#<?= $side ?>_parts').position());

	if(filename && filename != current_filename) { 
		//console.log("SET SRC="+filename);
		j(img).attr('src',filename);
	} // called preview/refresh several times, no need to re-do.

	//console.log("FILE="+filename+", CUR="+current_filename);

	// Now see whether show or hide.

	if(filename && filename != placeholder)
	{
		//console.log("SHOW IMG");
		//console.log(j('#<?= $side ?>_parts').position());
		//console.log(j(img));
		j(img).show().removeClass('placeholder');
		// need to load zoomed/cropped version.
		//console.log(j('#<?= $side ?>_parts').position());
	// XXX TODO need to save AND load 'completed' classes so 
	// OR set 'imageNone', 'personalizationNone' and 'quoteNone'
	} else if (j(step).hasClass('completed') || j('#DesignSide<?=$side?>ImageNone').val()) { // done with image and non set.
		//console.log("SET IMGSRC=placeholder, none wanted");
		j(img).hide();
		j(step).find('.zoomPictureContainer').hide();
	} else { 
		//console.log("SET IMGSRC=placeholder, none available");
		j(img).show().addClass('placeholder');
		j(step).find('.zoomPictureContainer').hide();
	}
	// ?? where do we load default coords?

	//console.log(img);
	//console.log(j('#<?= $side ?>_parts').position());
});
j('#DesignSide<?=$side?>ImageNone').bind('change', function() {
	var none = j(this).val();
	//console.log("NO IMAGE!");
	if(none)
	{
		j('#CustomImage<?=$side?>File').val(''); 
		j('#CustomImage<?=$side?>Filename').val('').change();
	}
});

//j(document).ready(function() {
j('#side<?=$side ?>').bind('visible', function() { // things sensitive to position.
	j('#thumbs<?=$side?>').load("/designs/images",function() { }); // show thumbs immediately since first step.

	//console.log("XLOASX="+j('#preview<?=$side?> .fullbleed img').attr('src'));
	j('#CustomImage<?= $side ?>Filename').trigger('preview'); // since filename with picture. in case of starting over, etc.
	j('#preview<?=$side?> .fullbleed img').addClass('dynamic placeholder').trigger('load');
});
</script>

<?= $this->element("../designs/next",array('skip'=>'/images/buttons/small/No-Picture.gif', 'skip_js'=>"j('#DesignSide{$side}ImageNone').val('1').change();")); ?>

</div>
