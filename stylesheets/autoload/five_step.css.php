<? include(dirname(__FILE__)."/config.php"); ?>
#five_step_bar
{
	background-color: #FFFFFF;
	/*border: solid #CCC 1px;*/
	border-collapse: collapse;
}

#five_step_bar td
{
	white-space: nowrap;
	border: solid #CCC 1px;
	padding: 5px;
}

.five_step_img
{
	float: left;
	width: 20px;
	padding: 2px;
	display: none;
}

#five_step_bar .five_step_options, #five_step_bar .five_step_selected
{
	background-color: #FFFFCC;
}

.five_step_selected
{
	font-weight: bold;
	font-size: 1.1em;
}

#five_step_bar .five_step_options
{
	border-top: 0px;
}

#five_step_bar .five_step_selected
{
	border-bottom: 0px;
}




#build_steps
{
	/*margin-top: 20px;*/
	padding: 5px;
	border: solid #CCC 1px;
	/*background-color: <?= $css['colors']['bg_dark'];?>*/
}

#build_steps .selected_step
{
	background-color: <?= $css['colors']['dark']; ?>;
}

#build_steps .selected_step *
{
	color: <?= $css['colors']['dark_fg']; ?>;
}

#build_steps .step_num
{
	font-size: 24px;
	font-weight: bold;
	color: <?= $css['colors']['secondary_dark']?>;
}

#build_steps a
{
	text-decoration: none;
}

#build_steps a:hover
{
	text-decoration: underline;
}

#five_easy_steps
{
	font-weight: bold;
	font-size: 20px;
}
