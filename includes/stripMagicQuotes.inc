<?php
//	if ( get_magic_quotes_gpc() ) {
		foreach ($_POST as $key => $item) {
			$_POST[$key] = stripMagicQuotes ($_POST[$key]);
		}
		foreach ($_GET as $key => $item) {
			$_GET[$key] = stripMagicQuotes ($_GET[$key]);
//		}
	};
function stripMagicQuotes ($variable) {
	if ( is_array($variable) ) {
		foreach ($variable as $element) {
			$element = stripMagicQuotes ($element);
		}
		return $variable;
	} else {
		return stripslashes($variable);
	}
}

?>