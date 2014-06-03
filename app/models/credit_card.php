<?php
include_once(dirname(__FILE__)."/../../includes/encdecclass.php");

class CreditCard extends AppModel {

	var $name = 'CreditCard';
	var $useTable = 'credit_card';
	var $primaryKey = 'credit_card_id';
	var $encdec = null;

	function encrypt($cardnum)
	{
		if(!$this->encdec) { $this->encdec = new EncDec(); }
		$encrypted = $this->encdec->phpEncrypt($cardnum);
		return $encrypted;
	}

	function decrypt($encrypted)
	{
		if(!$this->encdec) { $this->encdec = new EncDec(); }
		$cardnum = $this->encdec->phpDecrypt($encrypted);
		return $cardnum;
	}

	function get_card_type($ccNum)
	{
			$prefix = substr ($ccNum, 0, 2);
			$prefixLg = substr ($ccNum, 0, 4);
			if ($prefix >= 40 && $prefix < 50) { return "Visa"; }
			if ($prefix == 34 || $prefix == 37) { return "American Express"; }
			if ($prefix >= 51 && $prefix <= 55) { return "Mastercard"; }
			if ($prefixLg == 6011) { return "Discover"; }


			return null;
	}

	function is_valid_credit_card($ccNum)
	{
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

}
?>
