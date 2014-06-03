<?
#header("Content-Type", "text/css");
?>

<?  function rbox($name, $colorname, $colorcode) { ?>
/*************************************/
#<?= $name ?>_rbox
{
}
#<?= $name ?>_container
{
}

#<?= $name ?>_content
{
	background-color: #<?= $colorcode ?>;
	padding: 0px 10px;
}

#<?= $name ?>_b, #<?= $name ?>_t
{
	text-align: center;
	padding: 0px;
	margin: 0px;
	background-color: #<?= $colorcode ?>;
	color: #FFFFFF;
	overflow: visible;
}

#<?= $name ?>_bl,
#<?= $name ?>_br,
#<?= $name ?>_tl,
#<?= $name ?>_tr
{
	margin: 0px; padding: 0px;
	width: 25px;
	height: 25px;
	background-repeat: no-repeat;
	background-image: url("/images/rbox/<?= $colorname ?>.gif");
}

#<?= $name ?>_bl
{
	/*float: left;*/
	background-position: bottom left;
}

#<?= $name ?>_br
{
	/*float: right;*/
	background-position: bottom right;
}

#<?= $name ?>_tl
{
	/*float: left;*/
	background-position: top left;
}

#<?= $name ?>_tr
{
	/*float: right;*/
	background-position: top right;
}
<? } ?>

#pricing_chart
{
	width: 500px;
}

#pricing_chart .product_spacer
{
	padding-top: 5px;
}

#pricing_chart .product_heading
{
	border: solid #CCC 1px;
	background-color: #CCC;
	text-align: left;
}

#pricing_chart .pricing_title
{
	text-align: left;
	font-weight: bold;
}

#pricing_chart td, #pricing_chart th
{
	padding: 5px;
}

.pricing_chart_compact
{
	font-size: 10px;
}

.pricing_chart_compact h4
{
	font-size: 11pt !important;
	font-weight: bold;
	
}

.next_step button, input.next_step
{
	font-size: 12px;
	font-weight: bold;
}

#next_step_primary 
{
	position: relative;
}

#next_step_secondary
{
}

#product_diagram
{
	float: left;
}

#more_info
{
	/*float: right;*/
	width: 500px;
	border: solid black 1px;
	background-color: white;
	z-index: 500;
	position: absolute;
	padding: 20px;
}

#detail_content
{
}

.product_compare_sheet
{
	border-collapse: collapse;
}

.product_compare_sheet, .product_compare_sheet td, .product_compare_sheet th
{
	border: solid black 1px;
}

.product_compare_sheet .even
{
	background-color: #DEDEDE;
}

.selected_product
{
	border: solid #CCC 1px;
	background-color: #EEE;
}

.product_info_popup
{
	width: 425px;
	height: 300px;
	overflow: scroll;
	border: solid black 2px;
	background-color: white;
	z-index: 500;
	position: absolute;
	right: 0px;
	/*left: 50%;
	top: 50%;
	*/
	padding: 20px;
}

#clientlist
{
	/*border: solid #CCC 1px;*/
}

#clientlist *
{
}

#clientlist .client
{
}

.product_grid h3
{
	margin-left: 10px;
}

#product_choose
{
	/*margin-top: 10px;*/
}

#product_choose .header
{
	background-color: #CCC;
	font-weight: bold;
	font-size: 14px;
	padding: 2px;
}

#product_choose ul
{
	margin-left: 0px;
	list-style-type: square;
}

#product_choose li
{
	
}
#view_related_chart
{
	border-collapse: collapse;
}

#view_related_chart .product
{
	background-color: #FEFEFE;
}

#view_related_chart .product .image_gallery img
{
	/*border: solid #CCC 1px !important;*/
}

#view_related_chart .product .image_gallery .image
{
	width: 175px;
}

#view_related_chart .product_title
{
	background-color: #CCC;
	color: white;
	font-weight: bold;
	text-align: left;
	padding-left: 5px;
}
#view_related_chart .product_title *
{
	padding: 0px;
	margin: 0px;
}

#view_related_chart .product #pricing_chart_small
{
	background-color: white;
}

#view_related_chart .product .gallery_col
{
	/*border-left: solid #666 1px;*/
}


#view_related_chart .product .select_col
{
	/*
	border-right: solid #666 1px;
	*/
}

#view_related_chart .product > td
{
	/*
	border-top: solid #666 1px;
	border-bottom: solid #666 1px;
	padding: 10px 0px;
	*/
}

#view_related_chart .product ul
{
	margin-left: 0px;
}

#product_intro
{
	line-height: 1.5em;
}

#product_intro p
{
	margin: 0px;
	padding: 0px;
}


div.fakefile {
	position: absolute;
	top: 0px;
	left: 0px;
	z-index: 1;
}

div.fakefile 
{
	position: absolute;
	top: 0;
	left: 0;
	z-index: 1;
	font-size: 8pt;
}

div.fakefile input
{
	width: 150px;
	margin: 0px;
	padding-bottom: 5px;
	font-size: 16px;
	padding-left: 0;
	text-align: left;
	font-style: italic;
}

div.fileinputs img
{
	border: 0px;
	margin:0px;
	margin-top: -3px;
	padding: 0;
}
/*

div.oneclick_upload
{
	position: relative;
}

div.oneclick_upload input
{
	position: absolute;
	top: 0px;
	left: 0px;
	z-index: 2;
	-moz-opacity:0 ;
	filter:alpha(opacity: 0);
	opacity: 0;
	width: 190px;
	height: 50px;
}

div.oneclick_upload img
{
	z-index: 1;
}
*/

/*
.product ul
{
	width: 500px;
}

.product ul li
{
	float: left;
	width: 250px;
	list-style: none;

}
*/

.custom_gallery_tab,
.sample_gallery_tab
{
	border: solid #999 1px;
	background-color: #AAA;
	color: #999;
}

.custom_gallery_tab a, .custom_gallery_tab a:hover, .custom_gallery_tab a:link, .custom_gallery_tab a:visited,
.sample_gallery_tab a, .sample_gallery_tab a:hover, .sample_gallery_tab a:link, .sample_gallery_tab a:visited
{
	font-weight: bold;
	text-decoration: none !important;
	color: #FFF !important;
}

.custom_gallery_tab.selected,
.sample_gallery_tab.selected
{
	border-bottom: none;
	background-color: #BCBCFF !important;
}

.custom_gallery_tab.selected a,
.sample_gallery_tab.selected a
{
	color: black !important;
}

.gallery_type_tab
{
	/*
	border: solid #AAA 1px;
	*/
	background-color: #CCC;
	padding: 5px 0px;
}

.gallery_type_tab a, .gallery_type_tab a:hover, .gallery_type_tab a:link, .gallery_type_tab a:visited
{
	font-weight: bold;
	text-decoration: none !important;
	color: #999;
}

.gallery_type_tab.selected
{
	border-bottom: none;
	color: #FFFFFF;
	background: #7777CC !important;
}

.gallery_type_tab.selected a
{
	color: white !important;
}

.gallery_type
{
	/*
	padding: 2px;
	background: #7777CC;
	*/
}

.gallery_type_inner
{
	/*background: white;*/
}

<? rbox('products_links','gray','CCCCCC'); ?>
#products_links_t, #products_links_table { color: black; }
<? rbox('products_cta','gray','CCCCCC'); ?>
#products_cta_t, #products_cta_table { color: black; font-size: 12px; }
<? rbox('specialty_pages_cta','blue','CCCCCC'); ?>
<? rbox('specialty_pages_contact','lightblue','BCBCFF'); ?>



/*************************************************/
#comparison_chart
{
	border-collapse: collapse;
}

#comparison_chart .pricing_name
{
	background-color: #CCCCCC;
	font-size: 1.2em;
	text-align: center;
}

#comparison_chart .option
{
	padding: 5px;
	vertical-align: middle;
}

.accordian_header
{
	background-color: #AAA;
	padding: 5px;
	margin-top: 5px;
	font-size: 18px;
}

.accordian_header *
{
	font-size: 18px;
}

.accordian_header a
{
	color: white !important;
	text-decoration: none;
}

.accordian_header a:hover
{
	text-decoration: underline;
}

.customers
{
	width: 175px;
	float: right;
}

#product_content
{
	width: 800px;
	float: left;
}
.product_intro
{
	padding-bottom: 20px;
}

.product_tab_content
{
	background-color: white;
	padding: 10px 10px 10px 0px;
	/*border: solid #459645 1px;*/
	border: solid #ccc 1px;
	
}

#compare_tabs
{
	margin-left: 280px;
}
#compare_tabs div
{
	float: left;
}
#compare_tabs div.right
{
	float: right;
}
#compare_tabs div
{
	position: relative;
	z-index: 1;
	top: 1px;
	background: url("/images/tab_left.gif") no-repeat left top;
	margin-right: 3px;
}
#compare_tabs div.selected
{
	background: url("/images/tab_selected_left.gif") no-repeat left top;
}

#compare_tabs div a
{
	text-decoration: none;
	display: block;
	background: url("/images/tab_right.gif") no-repeat right top;
	margin-left: 5px;
	padding: 5px;
	color: white;
	height: 15px;
}

#compare_tabs div.selected a
{
	background: url("/images/tab_selected_right.gif") no-repeat right top;
	color: black;
}

.product_pricing
{
	float: right;
	width: 240px;
	text-align: center;
}

.product_gallery
{
	float: left;
	width: 275px;
}

.product_details
{
	float: left;
	width: 230px;
	/*border: solid #ccc 1px;*/
	margin-left: 15px;
}
.product_panel
{
	width: 500px;
	float: right;
	position: relative;
}

.product_title
{
	float: left;
}

.product_action
{
	float: right;
}

#product_compare_details
{
	float: right;
}

.product_nav
{
	width: 150px;
}

.product_nav div
{
	padding: 5px;
	font-size: 13px;
	/*border-bottom: 1px #CCC solid;*/
}

.product_nav div.first
{
	/*border-top: 1px #CCC solid;*/
}

.product_nav div a
{
	text-decoration: underline;
}

.product_nav div a.img
{
	text-decoration: none;
}


.product_subsection
{
	padding-bottom: 50px;
}

.product_subsection_header
{
	font-weight: bold;
	font-size: 12pt;
}
