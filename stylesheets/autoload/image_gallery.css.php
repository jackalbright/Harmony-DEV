<? include(dirname(__FILE__)."/config.php"); ?>
.image_gallery_col
{
	width: 230px;
}

.image_gallery
{
	/*float: right;*/
	/*width: 225px;*/
	/*height: 500px;*/
	text-align: center;
	/*border: solid #CCC 1px;*/
	/*margin: 0px 5px 5px 5px;*/
	margin: 0px;
}

.image_gallery_album
{
	border: solid #CCC 1px;
	margin: 5px;
	padding: 15px;
}

.image_gallery_album img
{
	height: 100px;
	
}

.image_gallery_album .sample_image
{
	padding: 20px;
}

.specialtyPage .image_gallery_album .image_gallery_scroll_image img
{
	height: 100px;
}

.image_gallery_button
{
	white-space: nowrap;
}


.image_gallery_horizontal
{
	/*height: 325px;*/
	width: 325px;
}

div.image_gallery_details_keychain_small
{
	/*height: 350px;*/
}

div.image_gallery_details_keychain_large
{
	width: 330px;
	/*height: 450px;*/
}

img#image_gallery_details_keychain_large
{
	/*width: auto;*/
	width: 325px;
}

img#image_gallery_details_keychain_small
{
	/*width: 200px;*/
}

.image_gallery_details_keychain_small
{
	width: 225px;
}

.image_gallery_details_paperweightkit, .image_gallery_details_paperweightkit_domed, 
.image_gallery_products_paperweightkit, .image_gallery_products_paperweightkit_domed
{
	/*height: 300px !important;*/
}

.image_gallery_details_mug
{
	/*height: 325px;*/
}

.image_gallery h4
{
	/*background-color: #99CC66;*/
	padding: 3px;
}

.image_gallery table
{
	padding: 5px;
}

.image_gallery table td
{
	width: 33%;
}

.image_gallery img
{
	/*width: 200px;*/
}

#RL_gtab_content_row
{
	height: 150px;
}
/*
.sample_image_products_customruler    img
{
	width: 550px;
}
*/

.image_gallery_horizontal img
{
	width: auto;
	height: auto;
}


.image_gallery_details_paperweight_domed, .image_gallery_details_paperweightkit_domed,
.image_gallery_products_paperweight, .image_gallery_products_paperweight_domed
{
	/*height: 345px;*/
}

.image_gallery_title
{
	height: 32px;
	font-size: 14pt;
	font-weight: bold;
	padding-top: 3px;
	background: url("/images/style/gradient_bar_bg_green.png") repeat-x;
	border-top: solid #CCC 1px;
}

.image_gallery_scroll_table
{
	border: solid #CCC 1px;
	padding: 5px;
}

.image_gallery_scroll_table_tabbed
{
	border-top: 0px !important;
}

#image_gallery_scroll_container
{
	/*height: 210px;*/
	/*width: 600px;*/
	width: 450px;
	overflow: hidden;
	background-color: <?= $css['colors']['bg_light']; ?>
}

#image_gallery_scroll_container_full
{
	width: 700px;
	overflow: hidden;
	background-color: <?= $css['colors']['bg_light']; ?>
}

#image_gallery_scroll_container_full img,
#image_gallery_scroll_container img
{
	border: solid #CCC 1px;
	margin: 2px;
}
