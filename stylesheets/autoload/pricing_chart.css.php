<? include(dirname(__FILE__)."/config.php"); ?>

#pricing_chart_small
{
	/*border: solid #CCC 1px;*/
	border-collapse: collapse;
	width: 200px;
	background-color: white;
}


#pricing_chart_small th
{
	text-align: left;
	border-bottom: solid #CCC 1px !important;
	/*background-color: <?= $css['colors']['medium']; ?>;*/
}

#pricing_chart_small td, #pricing_chart_small th
{
	border: solid #CCC 1px;
}


#pricing_chart_horizontal
{
	border: solid #000 1px;
	/*width: 225px;*/
	font-size: 10px;
}


#pricing_chart_horizontal th
{
	text-align: left;
	border-right: solid #000 2px !important;
	background-color: <?= $css['colors']['medium']; ?>;
}

#pricing_chart_horizontal td, #pricing_chart_horizontal th
{
	text-align: left;
	border: solid #CCC 1px;
	padding: 3px;
}

