<?  include(dirname(__FILE__)."/config.php"); ?>
.sidebar_block
{
	/*border: solid #CCC 1px;*/
	/*margin: 0px 5px 15px 5px;*/
}

.sidebar_header
{
	/*padding: 5px;
	margin-top: 10px;
	*/
	/*height: 32px;
	background: url("/images/style/gradient_bar_bg_green.png") repeat-x;
	*/
	font-size: 1.1em;
	font-weight: bold;
	white-space: nowrap;

}

.sidebar_content
{
	border: solid #CCC 1px;
}

.sidebar_more
{
}

#main_column, #leftbar_column, #rightbar_column
{
	vertical-align: top;
}


.breadcrumbs
{
	position: relative;
	/*top: -20px;*/
	/*left: -10px;*/
	/*padding-top: 2px;
	padding-left: 2px;*/
	/*padding-bottom: 20px;*/
}



.color_dark
{
	color: <?= $css['colors']['dark']; ?> !important;
}

.color_medium
{
	color: <?= $css['colors']['medium']; ?> !important;
}

.color_light
{
	color: <?= $css['colors']['light']; ?> !important;
}


.subtitle
{
	/*height: 32px;
	display: block;*/
	background: <?= $css['colors']['dark'] ?>;
	padding: 0px;
	/*padding: 2px 5px;*/
	/*border-top: solid #CCC 1px;*/
	width: 100% !important;
	font-size: 1.1em !important;
	font-weight: bold;
	white-space: nowrap;
}
.subtitle *
{
	color: <?= $css['colors']['dark_fg']; ?>;
}

.subtitle div
{
	padding: 5px 5px;
}

#title
{
	margin-top: 10px;
}
#title, #title h1, #aboutUsWrapper h1
{
	font-size: 15pt !important;
	font-weight: bold;
}

div#mainWrapper, div#container
{	
	width: 1000px;
	padding-top: 0px;
	margin: 0 auto 0 auto;
}

#content_row
{
	width: 100%;
}

div#bodyWrapper, #container
{
	position: relative;
	margin: 0 auto 0 auto;
	width: 1000px;
}

div#contentWrapper_full
{
	width: 100%;
}

div#contentWrapper
{
	position: relative;
	width: 544px;
	margin-left: 160px;
	margin-right: 275px;
	/*height: 1000px;*/
}

div#aboutUsWrapper{
width:80%;
margin-left:auto;
margin-right:auto;
overflow:auto;
}
#aboutUsWrapper h1{
padding:10px;
}
div#aboutUsWrapper #aboutUsLeft{
float:left;
width: 30%;
text-align:left;
padding: 0  10px;
}
div#aboutUsWrapper #aboutUsRight{
float:right;
width: 66%;
padding:0 5px;
text-align:center;
/*border:1px solid #000;*/
}
#aboutUsWrapper #ourAddress p{
font-weight:bold;
}

#sidebar_left
{
	float: left;
	width: 150px;
}

#sidebar_right
{
	float: right;
	width: 275px;
}

.paging
{
	text-align: right;
}

.disabled
{
	display: inline;
}

.error
{
	font-weight: bold;
	color: #B82A2A;
	padding-top: 5px;
	padding-bottom: 10px;
	max-width: 700px;
}

.even
{
	background: <?= $css['colors']['bg_light'] ?>;
}

.odd
{
	background: <?= $css['colors']['bg_medium'] ?>;
}

<? if(preg_match("/hdtest/", $_SERVER['HTTP_HOST'])) { ?>
body
{
	background-color: #000 !important;
	/*background-color: #FFDA06 !important;*/
}
<? } ?>
