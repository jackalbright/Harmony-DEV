<?php
	class CreditCard extends CustomerInfo {
		var
			$type,
			$number,
			$expirationDate,
			$cardHolder;
			
		function initFromDB ( $cardID, $db ) {
			$result = mysql_query ("Select credit_card.*, UNIX_TIMESTAMP(expirationDate) as expirationCoded from credit_card where credit_card_id = $cardID", $db);
			if ( $temp = mysql_fetch_object($result) ) {
				$this->type = $temp->Card_Type;
				$this->number = $temp->Number;
				$this->expirationDate = $temp->expirationCoded;
				$this->cardHolder = $temp->Cardholder;
				$this->ID = $cardID;
				$this->customerID = $temp->Customer_ID;
				
				return true;
			} else {
				return false;
			}
		}
		
		function customerAuthorized ($customerID) {
			return ($customerID == $this->customerID);
		}
		
		function type() {
			return $this->type;
		}
		
		function number() {
			
	}


	class CustomerInfo {
		var
			$ID,
			$customerID;
	}
?>