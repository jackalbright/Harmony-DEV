<script type="text/javascript">
/*
var session = '(<?php echo json_encode($_SESSION['Build_Options_Test']);?>';
console.log('Build_Options_Test');
 console.log(session);
 
 var session = '(<?php echo json_encode($_SESSION['Build_Options_Test']);?>';
console.log('Build');
 console.log(session);
//CantDoStandard
 var session = '(<?php echo json_encode($_SESSION['CantDoStandard']);?>';
console.log('CantDoStandard');
 console.log(session);
  var session = '(<?php echo json_encode($_SESSION['Product']);?>';
console.log('Product');
 console.log(session);
 
//templateTest
  var session = '(<?php echo json_encode($_SESSION['templateTest']);?>';
console.log('templateTest');
 console.log(session);
 */
</script>
<script type="text/javascript">
//console.log("product code: " + '<?php echo $build['Product']['code']?>');
</script>
<? $prod = $build['Product']['code']; 

?>
<?
	if(!in_array($prod, array('P'))) { # There are no parts on these, so don't tell to wait. (will get stuck)
		$this->set("showPleaseWait", true);
	}
	$this->set("enable_tracking", "build");
	$this->set("cropper",true);
	$this->set("shadowbox",true);
?>
<? $this->element("steps/steps",array('step'=>'options')); ?>
<? $template = !empty($build['template']) ? $build['template'] : null; ?>
<div id="build">
	<script>
	function setProduct(code)
	{
		j('input[name=prod]').val([code]); // needs to be called BEFORE setPart, so appropriate review/calc can show
		j('#prod').val(code); // needs to be called BEFORE setPart, so appropriate review/calc can show

		/*
		var url = "/build/customize/"+code;
		if(arguments.length > 1) { url += "?step="+arguments[1]; }
		var existing = $('prod').value;
		if(existing != code) // Dont change pages when already there.
		{
			document.location.href = url;
		}
		*/
	}
	</script>

	<form id="build_form" name="build_form" method="POST" enctype="multipart/form-data" action="/cart/add_consolidated"/>
	<input type="hidden" id="step" name="data[step]" value="<?= !empty($build['step']) ? $build['step'] : "" ?>"/>
	<input type="hidden" name="data[cart_item_id]" value="<?= !empty($build['cart_item_id']) ? $build['cart_item_id'] : "" ?>"/>
	<input id="prod" type="hidden" name="data[productCode]" value="<?= $build['Product']['code'] ?>"/>
	<?
		error_log("BTXXXXXXXXXXX=".print_r($build['template'],true));
	?>
	<input id="template" type="hidden" name="data[template]" value="<?= !empty($build['template']) ? $build['template'] : "imageonly"; ?>"/>
	<!-- no more persNone here, since checkbox elsewhere -->

	<input id="CustomImageID" type="hidden" name="data[options][customImageID]" value="<?= !empty($build['CustomImage']) ? $build['CustomImage']['Image_ID'] : "" ?>"/>
	<input id="CustomImageDisplayLocation" type="hidden" value="<?= !empty($build['CustomImage']) ? $build['CustomImage']['display_location'] : "" ?>"/>

	<input id="CatalogNumber" type="hidden" name="data[options][catalogNumber]" value="<?= !empty($build['GalleryImage']) ? $build['GalleryImage']['catalog_number'] : "" ?>"/>

	<a name="formtop">&nbsp;</a>

	<table style="" align="center" border=0 cellspacing=0 cellpadding=0 width="100%" style="">
	<tr>
		<td style="width: 325px;" valign="top" align="right">
			<div id="build_img_container" style="width: 315px;">
			<?= $this->element("../build/preview_adjust"); ?>
			</div>

			<!--
			<div align="center" style="font-weight: bold; padding: 0px 10px 20px 10px; color: #F15922;"> Need a different layout?<br/>Call 888.293.1109 </div>
			-->
			<div class="center">
                <p class='center_align'><a href="/info/testimonials.php" class='reviewsLink'><img src="/images/icons/starsForReviewSmall.png"> Reviews</a></p> 
			</div>
			<br/>

			<div class="" align="left">
			<?= !empty($build['Product']['build_notes']) ? $build['Product']['build_notes'] : null; ?>
			<?= !empty($build_notes) ? $build_notes : null; ?>
			</div>
		</td>
		<td valign="top" style="padding-left: 10px;">
		<!--<div class="main_border_top"><span></span></div>-->
		<div class="XXXmain_border_sides" style=""> 

			<?= $this->element("build/options"); ?>
		</div>
		<div class="main_border_bottom"><span></span></div>
		</td>
		<? /* ?>
		<td width="200" rowspan="2" colspan=1 align="left" class="left_border top_border grey_border" valign="top">
			<?= $this->element("build/sidebar"); ?>
		</td>
		<? */ ?>
	</table>

	</form>

	<script>
		/*
		<? if(!empty($_REQUEST['step'])) { ?>
		showBuildStep('<?= $_REQUEST['step'] ?>',true);
		<? } ?>
		*/
		/*hidePleaseWait();*/
	</script>

	<?= $this->element("clients/clientlist",array('cols'=>4,'notop'=>true)); ?>



</div>
<script>
/*
j(document).ready(function() { 
	<? if(empty($build['GalleryImage']) && empty($build['CustomImage'])) { ?>
	askUpload();
	<? } ?>
});
function askUpload()
{
	j('#modal').load("/custom_images/index/no_tips:1", function() {
		var xy = j('#build_img_container').offset();
		var x = parseInt(xy.left) + 350;
		var y = parseInt(xy.top) + 75;

		j('#modal').dialog({position: [x,y], draggable: true, resizable: false, modal: false, title: "Upload Your Art, Logo, Photo to Preview Online", width: 650, height: 'auto', dialogClass: 'buildUpload', 
			open: function(event, ui) {
				j(this).css({'max-height': 450, 'overflow-y': 'auto'});
				j(this).closest('.ui-dialog').css({'top': y });
				j(this).closest('.ui-dialog').css({'top': y });
				j('.buildUpload .ui-dialog-titlebar').removeClass('ui-corner-all');
			}
		});
	});
}
*/
</script>
