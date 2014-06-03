<? include("config.php"); ?>
#header_row
{
	width: 100%;
}

#header_row #header_break
{
	border-bottom: solid #CECECE 1px;
}

#header_row #header_left
{
	text-align: center;
}

#header_row #header_center
{
}

#header_row #header_right
{
}

#header_row #header_center .header_center_table
{
}

.logo
{
	padding-top: 19px;
	padding-bottom: 10px;
}

#secnav_row, #slogan, #prinav_row
{
	width: 560px;
	/*padding-right: 20px;*/
}

#secnav_row, #account
{
	height: 50px;
}
#slogan, #cart
{
	height: 40px;
}

#header #cart
{
	text-align: right;
	font-size: 12px;
	font-weight: bold;
}

#cart
{
	float: right;
	width: 190px;
}

#cart p
{
	margin: 0 0 0 0px;
	padding: 0;
	font-size: 0.9em;
}
#cart p img
{
	float: none;
	margin: 0;
	padding: 0;
	border-width: 0;
}

#cart .carticon
{
	float: left;
	margin: 0;
	padding: 0px;
}

#cart #emptyCart div { display: none }

#cart #emptyCart:hover div
{
	display: block;
	width: 104px;
	background-color: #FFE;
	padding: 2px;
	border-color: #903;
	border-width: 1px;
	border-style: solid;
}

#freesample
{
	padding-bottom: 20px;
}

#freesample *
{
	font-size: 16px;
}

#header td#account
{
	text-align: right;
}

#sidebarSearchbox
{
	border: solid #CCCCCC 1px;
	width: 200px;
}

#sidebarSearchbox 
{
}


form#sidebarSearch { margin: 0 0 0px 0; }




/* DEFINE COLORS */

/* ALL NAVS: */
.dropdown_nav td a,
.dropdown_nav td a:visited,
.dropdown_nav td a:active,
.dropdown_nav td a:hover
{
	color: #000;
}

.dropdown_nav td a:hover
{
	background-color: #CECECE;
}

/* Per nav */
#prinav_wrapper, #prinav, #prinav .dropdown_nav_submenu
{
	background-color: <?=$css['color1']; ?>;
}
#secnav, #secnav .dropdown_nav_submenu
{
	background-color: <?=$css['color2']; ?>;
}

#sidebarSearchbox .header
{
	background-color: <?=$css['color1']; ?>;
}

.header_left_divider
{
	background-color: <?= $css['color1']; ?>;
}

.header_left_divider, .dropdown_nav
{
	height: 28px;
}

#breadcrumbs
{
	margin-bottom: 20px;
}
