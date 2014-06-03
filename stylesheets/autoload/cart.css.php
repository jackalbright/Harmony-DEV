<? include(dirname(__FILE__)."/config.php"); ?>
#cartDisplay th, #shippingEstimate th
{
	background-color: <?= $css['colors']['bg_dark'] ?>;
}

#cartDisplay h4 { margin: 0.25em 0 0.1em 0; }
#cartDisplay #empty h2		
{
	color: #C06;
	text-align: center;
}
#cartDisplay #empty { margin: 50px 0 0 0; }
.item_description td, .item_description th
{
	padding: 5px;
	vertical-align: top;
}

.item_description .productInfo		
{
	font-size: 0.9em;
	/*
	margin: 0 0 0.25em 96px;
	*/
	width: 204px;
	vertical-align: top;
}
.item_description .productInfoHeading		
{
	/*
	float: left;
	clear: both;
	text-align: right;
	width: 86px;
	*/
	width: 86px;
	text-align: left;
	font-style: italic;
	font-size: 0.9em;
	margin: 0 0 0.1em 0;
	color: gray;
	padding: 3px;
	vertical-align: top;
}

#cartDisplay .item_description
{
	width: 275px;
}

#imgProductList p.center
{
	float: left;
	width: 64px;
	height: 70px;
	margin: 0 4px 0 4px;
}
#cartDisplay
{
	border-width: 3px;
	border-style: groove;
	border-color: #FFF;
	background-color: #FFE;
	margin: 0.5em 0 0.5em 0;
}
#cartDisplay  td		
{
	/*
	padding: 3px;
	vertical-align: top;
	margin-bottom: 1em;
	*/
}
#cartDisplay td.quantity { text-align: right; }
#cartDisplay td.quantityUpdate		
{
	text-align: right;
	border-color: gray;
	border-width: 1px 1px 0 0;
	border-style: solid;
	vertical-align: middle;
	padding: 0px;
}
#cartDisplay td.price { text-align: right; }
#cartDisplay td.total		
{
	text-align: right;
	border-color: gray;
	border-width: 1px;
	border-style: solid;
	vertical-align: middle;
}
#cartDisplay  th		
{
	/*background-color: #060;*/
	color: #FFE;
	padding: 3px;
	text-align: left;
	font-family: Optima, Verdana, Helvetica,Arial, sans-serif;
	font-weight: bold;
	font-size: 0.95em;
}
#cartDisplay th.total		
{
	vertical-align: middle;
	text-align: right;
}
#cartDisplay .option		
{
	font-size: 0.88em;
	font-weight: bold;
}
#cartDisplay p.option a
{
	clear: both;
	margin: 0 0 0.33em 0;
}
#cartDisplay p.option a:visited
{
	color: #039;
}
#cartDisplay div.itemComment		
{
	margin: 0.5em 0 0.5em 0;
	clear: both;
	padding-top: 0.25em;
	border-color: gray;
	border-width: 1pt;
	border-style: solid none none none;
}
/*#cartDisplay input { text-align: right; }*/

#shippingEstimate
{
	border-width: 3px;
	border-style: groove;
	border-color: #FFF;
	background-color: #FFE;
	margin: 1em auto 1em auto;
}
#shippingEstimate  th		
{
	/*background-color: #060;*/
	color: #FFE;
	padding: 3px;
	text-align: left;
	font-family: Optima, Verdana, Helvetica,Arial, sans-serif;
	font-weight: bold;
	font-size: 0.95em;
}
#shippingEstimate button
{
	color: white;
	background-color: #039;
	border-color: #FFE;
	border-width: 3px;
	border-style: outset;
	margin: auto 0 auto 0;
	padding: 2px 4px 2px 4px;
	font-family: Optima, Verdana, Helvetica,Arial, sans-serif;
}
#shippingEstimate td
{
	padding: 3px;
	vertical-align: top;
}
#shippingEstimate #shippingOptions
{
	border-left: gray;
	border-width: 0 0 0 1px;
	border-style: none none none solid;
}
#shippingEstimate ul
{
	font-size: 0.95em;
}
#shippingEstimate #calcLink
{
	border-color: gray;
	border-width: 1px 0 0 0;
	border-style: solid;
}

.cart_even
{
	background-color: #FFF;
}

.cart_odd
{
	background-color: #FFF;
}

.youmightalsolike
{
	border: solid #CCC 1px;
	background-color: <?= $css['colors']['bg_medium']; ?>;
	padding: 5px;
	width: 200px;
}

.grandtotal
{
	font-weight: bold;
	font-size: 1.3em;
}

.grandtotal
{
	vertical-align: bottom !important;
	font-variant: small-caps;
}
