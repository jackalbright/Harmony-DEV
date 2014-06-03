<?php
//$this->set("body_title", 'Select a method for building your product'); 

//$this->set("body_title", 'My Pictures'); 
?>
<h1>&nbsp;3 Ways to Use Images on Your Products</h1>
<div style="margin-top: 0px;">

<? if(empty($prod) && !empty($product)) { $prod = !empty($product['Product']['code']) ? $product['Product']['code'] : null; } ?>

<?
if(empty($prod)) { $prod = ''; }
$image_id = !empty($build['CustomImage']) ? $build['CustomImage']['Image_ID'] : null;
$catalog_number = !empty($build['GalleryImage']) ? $build['GalleryImage']['catalog_number'] : null;

$preview_url = "/products/get_started/build?existing_prod=$prod&catalog_number=$catalog_number&image_id=$image_id";
$custom_url = "/products/get_started/custom_add?";
$gallery_url = empty($custom_only_product) ?  "/products/get_started/gallery?" : "/products/get_started/gallery?clear_product=1";

?>

<script>
function choose_product(prod)
{
var preview_url = "<?= $preview_url ?>";
var custom_url = "<?= $custom_url ?>";
var gallery_url = "<?= $gallery_url ?>";

var preview_img = $('preview_link_img');
var preview_button = $('preview_link_button');

var custom_img = $('custom_link_img');
var custom_button = $('custom_link_button');

var gallery_img = $('gallery_link_img');
var gallery_button = $('gallery_link_button');

if(preview_img)
{
	preview_img.href = preview_url+"&prod="+prod;
	preview_button.href = preview_url+"&prod="+prod;
}

if(custom_img)
{
	custom_img.href = custom_url+"&prod="+prod;
	custom_button.href = custom_url+"&prod="+prod;
}

//alert("custom="+custom_img.href);

if(gallery_img)
{
	gallery_img.href = gallery_url+"&prod="+prod;
	gallery_button.href = gallery_url+"&prod="+prod;
}


}
</script>
<br/>


<div align="left">
	<div id="tabs" style="width: 950px; margin-left: 10px;">
		<a id="tab_customart" href="javascript:void(0)" class="tab selected"><span>Build Your Product Online
			<div style="font-size: 10px; text-decoration: none;">
				&nbsp;<br>&nbsp;<!--Use our easy step-by-step process<br/>to create your design online-->
			</div>
		</span></a>
		<a id="tab_completedart" href="javascript:void(0)" class="tab"><span>Send Us Your Art File
			<div style="font-size: 10px; text-decoration: none;">
				&nbsp;<br>&nbsp;<!--Upload your completed art<br/>and we'll create your products-->
			</div>
		</span></a>
		<a id="tab_stampart" href="javascript:void(0)" class="tab"><span>Browse stamp art
			<div style="font-size: 10px; text-decoration: none;">
				&nbsp;<br>&nbsp;<!--Browse our licensed stamp images<br/>for ideas, then build your products online-->
			</div>
		</span></a>
	</div>
	<div class="clear"></div>
	<div  class='panelContainer' >
		<div id="panel_customart" class="panel selected" style="padding-top: 20px;">
			<div style="margin-left: 30px;">
				<? if (!$customer_id && !empty($images)) { ?>
				<!--<a class="alert2" href="/account/login?goto=/custom_images"><img src="/images/webButtons2014/orange/large/signupNow.png" alt="Signup now to save your art for later." title="Signup now to save your art for later." ></a> to save your art for later.--> 
                <!--<a class="alert2" href="/account/login?goto=/custom_images">Signup NOW</a> to save your art for later.-->
				<? } ?>
				<? if (!$customer_id) { ?>
				
				<!--<a class="alert2" href="/account/login?goto=/custom_images"><img src="/images/webButtons2014/orange/large/logIn.png" alt="Login to view saved images" title="Login to view saved images"></a> to view saved images.-->
                <!--<a class="alert2" href="/account/login?goto=/custom_images">Login</a> to view saved images.-->
				<? } ?>
			</div>
	
			<table style="width:100%" cellpadding=0 >
			<tr>
            <td style="width:300px" valign="top">
				<?= $this->element("custom_images/upload"); ?>
                
				
				<div class="grey_border_top"><span><h3 class="bold" style="padding-top: 5px;">With this option you can...</h3></span></div>
				<div class="grey_border_sides" style="padding: 10px;">
				<br/>
				<ul style="">
					<li>Build your product online
					<li>Instantly see a preview
					<li>Choose background colors, text and other options
					<li>Save your art if desired
					<li>Place your order online
					<!--<li>Qualify for free shipping offers-->
				</ul>
				</div>
				<div class="grey_border_bottom"><span></span></div>
				<br/>
	
				<div class="grey_border_top"><span><h3 class="bold" style="padding-top: 5px;">Your Privacy</h3></span></div>
				<div class="grey_border_sides" style="padding: 10px;">
				<br/>
				<ul style="">
					<li>Your art, photos, logos, images are your property. They are used to create products for you alone. 
					<li>If we are interested in featuring your design in our sample gallery or catalog, we ask for your permission.
				</ul>
				</div>
                
			<td valign="top" rowspan=1>
            <?php  
			if(!empty($images)) { ?>
            <div class='word_or'>Or</div>
            <?php } ?>
            </td>
            
            	
			</td><td valign="top" rowspan=2>
					<? if(!empty($images)) { ?>
						<?= $this->element("custom_images/album",array('inline'=>false)); ?>
					<? } ?>
			</td>
			</tr>
			<tr>
				<td colspan=2 style="padding-left: 15px;">
				</td>
			</tr>
			
			</table>
	
	
		</div>
		<div id="panel_completedart" class="panel" style="padding-top: 10px;">
			<?= $this->requestAction("/completed_projects/add?prod=$prod", array('return')); ?>
	
			<!--
					<div align="center"> 
					<a href="mailto:info@harmonydesigns.com?subject=Emailed Art">
						<img style="border: solid #AAA 1px !important;" src="/images/icons/medium/email.png"/>
					</a>
					</div>
	
					<ul style="margin-left: 5px;">
						<li> Please include your contact information 
						<li> We will contact you within one business day to discuss your project.
						<li> An email proof is FREE with your paid order.
						<li> An email proof without ordering is $25.
						<li> Please note: Phone and email orders do not qualify for free shipping offers.
					</ul>
			-->
		</div>
		<div id="panel_stampart" class="panel" style="">
			<?= $this->requestAction("/gallery/browse", array('return')); ?>
		</div>

	</div>


<div class="clear"></div>

	<script>
	j('#download_template, .download_template').click(function (e) {
		var href = j(this).prop('href');
		e.stopPropagation();
		j('#modal').load(href, null, function()
		{
			j('#modal').dialog({
				width: 700,
				title: 'Download <?= $product['Product']['name'] ?> Templates',
				modal: true,
				resizable: false,
				draggable: false
			});

			j('.ui-widget-overlay').click(function() {
				j('#modal').dialog('close');
			});
		})

		return false;

	});

	j('a.tab').click(function() {
		j('#flashMessage').remove();

		var panel = j(this).attr('id').replace("tab_", "");
		//console.log("P="+panel);
		j('.panel').removeClass('selected');
		j('#panel_'+panel).addClass('selected');
		j('.tab').removeClass('selected');
		j(this).addClass('selected');
		j(this).blur();
		window.location.hash = "#"+panel;
	});
	j(document).ready(function() {
		var hash = window.location.hash.substring(1).toLowerCase();
		if(j('#tab_'+hash))
		{
			j('#tab_'+hash).click();
		}
	});
	</script>
    
<!-- N O T E: styles for this page have been moved to  /stylesheets/autoload/imagePickerTabs.css-->

	<!--<style>
	#tabs
	{
		position: relative;
		/*top: 3px;*/
		z-index: 5;
	}
/*
light blue is #B8E8E7
*/
	a.tab {
		display: block;
		float: left;
		width: 268px;
		font-size: 18px;
		text-align: center;
		margin: 0px 5px -1px 5px;
	
		position: relative;
	
		color: #333;
	
		text-decoration: none;

		/*background: url("/images/banners/lightblue_right.png") no-repeat top right;*/
		/*background: url("/images/banners/darkgrey_whitefill_thick_border_right.png") no-repeat top right;*/
		background-color: #fff;
		border: solid #666 1px;
		/*border-bottom:none;*/
		border-top-left-radius:5px;
		border-top-right-radius:5px;
		padding-right: 15px;
	}
	a.tab span
	{
		padding: 5px 10px;
		display: block;
		/*background: url("/images/banners/lightblue.png") no-repeat top left;*/
	}

	a.tab.selected
	{
		position: relative;
		/*top: 3px;*/
		/*font-weight: bold;*/
		color: #000;
		border-bottom: 1px solid #B8E8E7 !important;
		background-color: #B8E8E7;
		/*
		background-color: #FFF;
		*/
		/*background: url("/images/banners/lightblue_right.png") no-repeat top right;*/
		/*background: url("/images/banners/darkgrey_whitefill_thick_border_right.png") no-repeat top right;*/
		padding-right: 15px;
	}
	a.tab.selected span
	{
		/*background: url("/images/banners/darkgrey_whitefill_thick_border.png") no-repeat top left;*/
		background: url("/images/banners/lightblue.png") no-repeat top left;
	}

	a.tab:hover
	{
		color: #0369A7;
		text-decoration: underline;
	}
	.panel
	{
		display: none;
	}
	.panel > td
	{
		
		/*padding: 15px;*/
		padding-bottom: 30px;
	}
	.panelContainer{
		width:950px;
		border: solid #666 1px; 
		border-top-left-radius:5px;
		border-top-right-radius:5px;
		border-bottom-left-radius:5px;
		border-bottom-right-radius:5px;
		min-height: 400px; 
		padding: 5px;
		background-color: #B8E8E7;
	}
	.panel.selected
	{
		display: block;
		/*background-color: #FFF;*/
		background-color: #B8E8E7;
	}
	#upload_box
	{ 	
		border-top-left-radius:5px;
		border-top-right-radius:5px;
		border-bottom-left-radius:5px;
		border-bottom-right-radius:5px;
		border:3px solid #666;
		background-color: #fff; 
		padding:10px 0;
		/*padding: 10px; */
		/*margin-right: 25px;*/
	}
	#upload_box  div{
		margin-left:10px;
		margin-right:10px;
	}
	#upload_box_top
	{
	}
	div.completedImages,
	div.steps_container,
	div.steps_container table td{
	background-color: #B8E8E7 !important;
	}
	
	div.albumContainer{
		border-top-left-radius:5px;
		border-top-right-radius:5px;
		border-bottom-left-radius:5px;
		border-bottom-right-radius:5px;
		background-color: #fff;
		border:1px solid #ccc;
	}
	div.word_or{
		/*border:1px solid #000;*/
		font-weight:bold;
		font-size:16pt;
		font-style:italic;
		padding: 50px 20px;
		text-transform:uppercase;
		text-align:center;
	}
	hr.softHR{
		color: #aaa;
		background-color: #fff;
		height: 1.5px;
		margin:0;
		width:100%;
	}
	</style>-->


</div>
