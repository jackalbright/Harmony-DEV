<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $title?></title>
<?php
$isSecure = false;
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $isSecure = true;
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
    $isSecure = true;
}
$REQUEST_PROTOCOL = $isSecure ? 'https' : 'http';
?>
<link href="<?php echo $REQUEST_PROTOCOL?>://<?php echo $_SERVER['SERVER_NAME']?>/stylesheets/adminstyle.css" rel="stylesheet" type="text/css">