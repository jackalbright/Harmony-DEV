<?
include(dirname(__FILE__)."/config.php");

?>
.sidebar_block
{
	border: solid #CCC 1px;
	margin: 0px 5px 15px 5px;
}

.sidebar_header
{
	height: 32px;
	background: url("/images/style/gradient_bar_bg_green.png") repeat-x;
	padding: 5px;
	font-size: 1.1em;
	font-weight: bold;
	white-space: nowrap;

}

.sidebar_content
{
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
	padding-top: 2px;
	padding-left: 2px;
	padding-bottom: 20px;
}

div#title
{
	/*
	clear: right;
	position: relative;
	*/
}

.subtitle
{
	height: 32px;
	display: block;
	background: url("/images/style/gradient_bar_bg_green.png") repeat-x;
	padding: 0px;
	/*padding: 2px 5px;*/
	border-top: solid #CCC 1px;
	width: 100% !important;
	font-size: 1.1em !important;
	font-weight: bold;
	white-space: nowrap;
}

.subtitle div
{
	padding: 5px 5px;
}

#title
{
	/*height: 32px;*/
	display: block;
	background: url("/images/style/gradient_bar_bg_green.png") repeat-x #99cc66;
	background-position: bottom;
	padding: 2px 5px;
	border-top: solid #CCC 1px;
	width: 100% !important;
	margin-bottom: 10px;
}
#title h1
{
	font-size: 14pt !important;
	font-weight: bold;
	padding: 0px;
	margin: 0px;
	/*padding-top: 3px;*/
}

div#mainWrapper
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
	margin-left: 210px;
	margin-right: 210px;
}

#sidebar_left
{
	float: left;
	width: 200px;
}

#sidebar_right
{
	float: right;
	width: 200px;
}

.paging
{
	text-align: right;
}

.disabled
{
	display: inline;
}

.error, #flashMessage, .message
{
	font-weight: bold;
	color: #EE0000;
	padding-top: 5px;
	padding-bottom: 10px;
}
