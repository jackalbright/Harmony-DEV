<?
session_start();
unset($_SESSION['UName']);
error_log("SE=".print_r($_SESSION,true));
header("Location: /admin38/index.php");
exit(0);

?>
