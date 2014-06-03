<?
#header('Content-Type: text/css');
# We don't print out individually anymore...

# For importing to reference colors, etc...

$host = $_SERVER['HTTP_HOST'];
$malysoft = preg_match("/malysoft/", $host);
$hdtest = preg_match("/hdtest/", $host);

$css = array(
	'color1'=>'#99CC66',
	'color2'=>'#8484BA',
	'colors'=>array(
		#'dark'=>'#b597c3',
		#'dark_fg'=>'#000000',
		#'dark'=>'#8277a0',
		'dark'=>'#09225B',
		'dark_fg'=>'#FFFFFF',
		#'medium'=>'#dfd2e5',
		'medium'=>'#EEEEFF',
		'light'=>'#e6e4e7',
		'bg_medium'=>'#EEE',
		'bg_light'=>'#F0F0F0',
		'bg_dark'=>'#AAA',
		#'secondary_dark'=>'#FF9900',
		'secondary_dark'=>'#F9967A',
	),
);

?>
