<?
/*
general stuff, like site-wide thresholds, etc...

*/

include_once(dirname(__FILE__)."/../../includes/global_functions.php");

return array(
	# thresholds
	#'admin_email'=>'admin@firstfashionsite.com', # Send emails from, to.
	#'admin_email'=>'tomas@localhost', # Send emails from, to.
	#'admin_email'=>'admin',#localhost', # Send emails from, to.
	##'admin_email'=>'admin@'.$_SERVER['HTTP_HOST'],#localhost', # Send emails from, to.
	#####'admin_email'=>'info@'.get_domain(),
	'admin_email'=>'Harmony Designs <harmonydesigns@earthlink.net>',
	#'admin_email'=>'t_maly@comcast.net',
	#$_SERVER['HTTP_HOST'],#localhost', # Send emails from, to.
	'smtp_server'=>array(
		'timeout'=>10,
		'username'=>'orders@harmonydesigns.com',
		'password'=>'!bookmark#2014',
		'host'=>'mail.harmonydesigns.com',
		'port'=>25,
	),


);
?>
