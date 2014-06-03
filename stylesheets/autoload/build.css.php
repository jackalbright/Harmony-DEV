<? include(dirname(__FILE__)."/config.php"); ?>

#buildnav
{
	border: solid #CCC 1px;
}

#build_preview
{
}


#build_step_container, .build_step_container
{
	padding: 10px;
	border: solid #CCC 1px;
	background-color: #FFF;
	border-top: 0px;
}

#build_step_tabs
{
	width: 100%;
	border-collapse: collapse;
	text-align: center;
	background-color: #FFF;
}

.build_step_tab
{
	border: solid #CCC 1px;
	padding: 5px;
	background-color: #99AA66;
}

.build_step_tab_selected
{
	background-color: #FFF;
	border-bottom: 0px;
}

.build_step_tab a:visited,
.build_step_tab a:link,
.build_step_tab a:hover
{
	color: black;
	/*text-decoration: none;*/

}



#build
{
	margin-left: auto;
	margin-right: auto;
}



#build h2
{
	color: white;
	background-color: black;/*<?= $css['colors']['bg_dark']?>;*/
}


.build_tab_container
{
	margin-top: 10px;
	
}

.build_step_container
{
	padding-top: 20px;
	border: solid #CCC 1px;
	border-top: 0px;
}

.build_step_container h2
{
	margin: 0px !important;
}

.build_tab
{
	/*display: block;
	float: left;*/
	padding: 6px;
	border: solid #CCC 1px;
	margin-left: 3px;
	background-color: #EEE;
	text-align: center;
}
.selected_build_tab
{
	border-bottom: 0px;
	background-color: #FFF;
}

.build_tab_complete
{
	background-color: #00FF00;
}

.progress_bar
{
}

.progress_bar .progress_bar_outer
{
	border: solid black 1px;
	height: 15px;
	background-color: white;
}

.progress_bar .progress_bar_outer .progress_bar_inner
{
	background-color: <?= $css['colors']['secondary_dark'] ?>;
	height: 15px;
}

.progress_bar .progress_bar_label
{
}

.aslowas
{
	font-weight: bold;
	color: <?= $css['colors']['dark'] ?>;
	font-size: 14px;
}

.savings
{
	font-size: 12px;
	color: red;

}

#build_intro_sidebar
{
	border: solid 1px #CCC;
	background-color: <?= $css['colors']['bg_light'] ?>;
	margin-top: 5px;
	padding: 3px;
}

/* SIDEBAR DETAILS */

.preview_option
{
	border: solid #CCC 1px;
	margin: 5px;
	background-color: #FAFAFA;
	padding: 2px;
}

.preview_option_title
{
	font-weight: bold;
}

.preview_option_value
{
	padding-top: 2px;
	padding-left: 5px;
}

.preview_option .quote_attrib
{
	font-style: italic;
	text-align: right;
}

.preview_option_selected
{
	background-color: #CECECE;
}

#build_summary
{
	width: 550px;
}

#build_summary .preview_option
{
	float: left;
	width: 98%;
	margin: 5px 5px;
	padding: 10px !important;
	height: 100px;
}

#build_summary .preview_option_quote, #build_summary .preview_option_stamp
{
	width: 98%;
	clear: both;
}

#build_summary .preview_option_stamp
{
	height: 50px;
}

#build_summary .preview_option_border,
#build_summary .preview_option_tassel,
#build_summary .preview_option_charm
{
	width: 125px;
}

#build_summary .preview_option_personalization
{
	clear: left;
}

#build_summary .preview_option_personalization,
#build_summary .preview_option_comments
{
	width: 250px;
}


.currently_building
{
	font-weight: bold;
	/*font-size: 1.1em;*/
	padding: 3px;
	color: black;

}

#ribbon_preview
{
	width: 50px;
}

.part_summary
{
	font-size: 0.8em;
	font-style: italic;
	clear: left;
}

#press_ready_popup
{
	border: solid #000 2px;
	background-color: white;
	z-index: 1000;
	width: 200px;
	position: absolute;
	padding: 5px;
}

#build_form th a
{
	text-decoration: none;
	color: black;
}
	
#build_form th a:hover
{
	text-decoration: underline;
	
}
.part_settings
{
	padding: 5px;
	border: solid #DDD 1px;
}

#part_settings_layout .selected_layout
{
	background-color: #EEE;
	border: solid black 1px;
}

#part_settings_layout .selected_layout img
{
	border: solid #CCC 1px !important;
}

#build_form .step
{
	/*border-top: solid #DDD 1px;*/
}
#build_form .step .step_header
{
	border-bottom: solid #DDD 1px;
	font-size: 14px;
}

#build_form .step .step_header
{
	background-color: #EEE;
	color: #777;
}

#build_form .step .step_header td
{
	padding: 2px;
}


#build_form .completed_step .step_header
{
}

#build_form .incomplete_step .step_header
{
	/*background-color: #FAFAFA;*/
}

#build_form .step th a
{
	color: #777;
}
/*
#build_form .step1 .step_header
{
	background: none;
}
#build_form .step1 .step_header th,
#build_form .step1 .step_header td
{
	padding: 2px;
}
*/

#build_form .step_header th,
#build_form .step_header td
{
	padding: 5px;
}
#build_form .step_header th
{
	padding-left: 15px;
}

/*
#build_form .step1.step .step_header th,
#build_form .step1.step .step_header td
{
	padding: 5px;
}
#build_form .step1.step .step_header th
{
	background: url("/images/banners/light_grey.png") no-repeat scroll left 0 transparent;
}
#build_form .step1 .step_header td
{
	background: url("/images/banners/light_grey.png") no-repeat scroll right 0 transparent;
}
*/

#build_form .selected_step .step_header
{
	background-color: #B8E8E7;
	/*background-color: #FFD46E;*/
	/*background-color: #44AC44 !important;*/
}
/*
#build_form .step1.selected_step .step_header
{
	background: none !important;
}
*/

#build_form .selected_box
{
	background-color: #B8E8E7;
	border: solid 1px #999;
	padding: 5px;
}

#build_form .step1.selected_step .step_header th
{
	background: url("/images/banners/lightblue.png") no-repeat scroll left 0 transparent;
}
#build_form .step1.selected_step .step_header td
{
	background: url("/images/banners/lightblue.png") no-repeat scroll right 0 transparent;
}

#build_form .selected_step th a
{
	color: black;
}

#build_form .selected_step .step_header .part_info *
{
	color: #000;
}


.step .complete
{
	display: none;
	white-space: nowrap;
}

.incomplete_step .complete
{
	display: none !important;
}

.step .complete
{
	display: block;
}

.build_option_group_header, 
.build_option_group_header a,
.build_option_group_header a:link,
.build_option_group_header a:hover,
.build_option_group_header a:visited,
.build_option_group_header a:active
{
	background-color: #FFF;
	color: #000;
	font-weight: bold;
	text-decoration: none;
}

.build_option_group tbody
{
	border: solid #CCC 1px;
}

.build_option_group td
{
	background-color: #FFF;
	border-bottom: solid #CCC 1px;
}

.quoteAttribution
{
	font-style: italic;
	font-size: 0.8em;
}

#proof_info
{
	position: absolute;
	left: -100px;
}

.default_text
{
	color: #999;
}


#track1-left {
	position: absolute;
	width: 5px;
	height: 9px;
	background: transparent url("/images/slider-images-track-left.png") no-repeat top left;
}
#track1
{
	background: transparent url("/images/slider-images-track-right.png") no-repeat top right;
}

#quote_container
{
	width: 385px;
}

#quote_details textarea
{
	/*border: 0px;*/
}

#personalization_container
{
	width: 220px;
}
#personalization_details > div
{
	margin-top: 0px;
}
#personalizationInput,
#personalizationInput_clone
{
	overflow: hidden;
	width: 100%;
}

#quote_details > div
{
	padding-top: 4px;
}
#quote_details textarea
{
	border: none;
}

#quote_details #custom
{
	background-color: white;
}

.ghost
{
	color: #888;
}

.buildUpload 
{
	border: solid #226644 5px;
	background-color: #E0E0E0;
}

.buildUpload .ui-widget-content
{
	background-image: none;
	background: #E0E0E0;
}

.buildUpload .ui-dialog-titlebar
{
	background: #666;
	color: white;
}
.buildUpload .ui-dialog-titlebar-close
{
	display: none;
}

.buildUpload .ui-dialog-content
{
}
