<?  include(dirname(__FILE__)."/config.php"); ?>
#prinav_wrapper
{
	/*display: block;
	clear: both;
	padding-bottom: 30px;
	*/
}

#prinav_row
{
	/*background-color: <?= $css['colors']['dark']; ?>;*/
}
#prinav_row *
{
	color: <?= $css['colors']['dark_fg']; ?>;
	font-weight: bold;
}
#prinav_row input
{
	color: black;
}

#prinav_bar
{
	/*background: url("/images/style/gradient_bar_bg_green.png") repeat-x;*/
	/*height: 32px;*/
	/*text-align: right;*/
}

#prinav_wrapper .dropdown_nav_submenu
{
	/*background-color: #99CC66;*/
	background-color: <?= $css['colors']['dark']; ?>;
}
#prinav_wrapper .dropdown_nav_submenu *
{
	color: <?= $css['colors']['dark_fg']; ?>;
}

#prinav_wrapper .dropdown_nav_button
{
	/*padding: 5px 5px;*/
}

#header_search_field
{
	width: 150px;
}

#prinav_wrapper .dropdown_navsubmenu .dropdown_subheader,
#prinav_row .dropdown_subheader
{
	color: #FF9900;
	font-weight: bold;
}
