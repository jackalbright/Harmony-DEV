<?php
	function stripNonNumeric ($string) {
		return preg_replace ('/[.\D]/', '', $string);
	}
	
	function ccValidate ($ccNum) {

		$sum = 0;
		$length = strlen($ccNum);
		for ($i = $length-2; $i >= 0; $i -= 2) {
			$num = substr($ccNum, $i, 1);
			$sum += ( (($num * 2) % 10) + floor( ($num * 2) / 10) ); 
		}
		for ($i = $length-1; $i >= 0; $i -= 2) {
			$num = substr($ccNum, $i, 1);
			$sum += $num; 
		}
		if ( ($sum % 10) == 0 ) {
		// checksum verifies
			$prefix = substr ($ccNum, 0, 2);
			$prefixLg = substr ($ccNum, 0, 4);
			if ( $prefix >= 40 && $prefix < 50 && ( $length == 16 || $length == 13 ) ) {
			// Visa card
				return true;
			} else if ( ( $prefix == 34 || $prefix == 37 ) && $length == 15 ) {
			// American Express card
				return true;
			} else if ( $prefix >= 51 && $prefix <= 55 && $length == 16 ) {
			// Mastercard
				return true;
			} else if ( $prefixLg == 6011 && $length == 16 ) {
			// Discover card
				return true;
			} else {
			// Prefix and length do not match standards
				return false;
			}
		} else {
		// checksum does not verify
			return false;
		}
	}
	
	function ccNumCloak ($ccNum) {
		$length = strlen($ccNum);
		if ( $length == 13 ) {
			return ( '**** ***** ' . substr($ccNum, 10, 3) );
		} else if ($length == 15 ) {
			return ( '**** **** **** ' . substr($ccNum, 12, 3) );		
		} else {
			return ( '**** **** **** ' . substr($ccNum, 12, 4) );
		}
	}
	
	function ccNumFull ($ccNum) {
		$length = strlen($ccNum);
		if ( $length == 13 ) {
			return ( substr($ccNum, 0, 4) . ' ' . substr($ccNum, 4, 5) . ' ' . substr($ccNum, 9, 3) );
		} else if ($length == 15 ) {
			return ( substr($ccNum, 0, 4) . ' ' . substr($ccNum, 4, 4) . ' ' . substr($ccNum, 8, 4) . ' ' . substr($ccNum, 12, 3) );
		} else {
			return ( substr($ccNum, 0, 4) . ' ' . substr($ccNum, 4, 4) . ' ' . substr($ccNum, 8, 4) . ' ' . substr($ccNum, 12, 4) );
		}
	}
?>