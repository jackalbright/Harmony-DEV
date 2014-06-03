<? include(dirname(__FILE__)."/config.php"); ?>
.tab_list
{
	position: relative;
	border-collapse: collapse;
	z-index: 1;
	top: 1px;
	/*left: 5px;*/
}

.tab_list .gtab
{
	border: solid #CCC 1px;
	background-color: <?= $css['colors']['medium']?>;
	padding: 6px 6px;
	text-align: center;
	font-weight: bold;
	font-size: 1.1em;
	border-bottom: 0px;
}
.tab_list .gspacer
{
	width: 2px;
	border: 0px;
	border-bottom: solid #CCC 1px;
}
.tab_list .selected_gtab
{
	background-color: #FFFFEE;
}


.tab_content, .gtab_content
{
	display: none;
	/*height: 300px;*/
	line-height: 1.5em;
}

.selected_tab_content, .selected_gtab_content
{
	display: block;
}



.tabbed_container
{
	border:0px;
	/*border: solid #AAA 1px;*/
	background-color: #FFF;
	border-top: 0px;
}
.tab_list .tab
{
	border: 0px;
	/*border-top: solid black 1px;*/
	padding: 3px 8px;
	text-align: center;
	font-weight: bold;
	font-variant: small-caps;
	/*font-size: 1.2em;*/
	font-size: 18px;
	background: url("/images/tab_right.gif") no-repeat right top;
}

.part_settings .tab_list .tab
{
	font-size: 12px !important;
}


.tab_list .tab a, .tab_list .gtab a
{
	text-decoration: none;
	color: black;
	display: block;

}

.tab_list .spacer
{
	position: relative;
	width: 7px;
	border: 0px;
	background: url("/images/tab_left.gif") no-repeat right top;
}

.tab_list .selected_tab
{
	background: url("/images/tab_selected_right.gif") no-repeat right top;
}
.tab_list .selected_tab a
{
	color: #000;
}
.tab_list .selected_spacer
{
	background: url("/images/tab_selected_left.gif") no-repeat right top;
}



.tab_list .spacer.first
{
	width: 3px;
}

.tabbed_container
{
	padding: 10px;
	border: solid #CCC 1px;
	/*border-top: 0px;*/
}
