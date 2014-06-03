<? include(dirname(__FILE__)."/config.php"); ?>

#feature_comparison
{
	border: solid #000 1px;
}


#feature_comparison th
{
	text-align: center;
	border-bottom: solid #000 2px !important;
	background-color: <?= $css['colors']['medium']; ?>;
}

#feature_comparison td, #feature_comparison th
{
	border: solid #CCC 1px;
	padding: 3px;
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


