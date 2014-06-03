<?php
if ( isset($_SERVER['HTTPS'])  && (strtoupper($_SERVER['HTTPS'])=='ON')){
	$host = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : "";
	
}else{
	$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : "";
}
  
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : "";
if (preg_match("/dev[.]harmonydesigns[.]com/", $host) ){
?>

body
{
background-color: #990000;

}



<?php
} // end if host is DEV server
?>
