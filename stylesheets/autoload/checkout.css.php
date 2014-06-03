<?  include(dirname(__FILE__)."/config.php"); ?>


#checkoutDisplay th, td#divider, .boldHead
{
	background-color: <?= $css['colors']['bg_dark'] ?>;
}

td div.section
{
	border-color: <?= $css['colors']['bg_dark'] ?>;
}


.checkout_progress
{
	/*border: solid #CCC 1px;
	background-color: #FFF;*/
	padding: 5px;
	border-collapse: collapse;
}
.checkout_progress .checkout_step, .checkout_progress .empty
{
	border-left: solid #CCC 1px;
	border-right: solid #CCC 1px;
	border-right: solid #CCC 1px;
}

.checkout_progress .empty
{
}

.checkout_progress td
{
	position: relative;
	padding: 5px 10px 1px 10px;
	
}

.checkout_progress .checkout_step_first
{
	
}

.checkout_progress .checkout_step_num
{
	font-weight: bold;
	/*font-size: 1.5em;*/
	/*float: left;*/
	display: inline;
}

.checkout_progress .checkout_step
{
	vertical-align: bottom;
	border-bottom: solid #CCC 1px;
}

.checkout_progress .checkout_step_complete 
{
	/*font-size: 1.3em;*/
	font-weight: bold;
	background-color: #FCC1B2;
	border-bottom-width: 3px;
}


#billing_info label,
#shipping_info label
{
	white-space: nowrap;
}
