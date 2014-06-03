<?php
	class LegacyCartItem {
		var
			$type,
			$quantity,
			$unitPrice,
			$parts;
			
		function LegacyCartItem () {
			$this->parts = new ItemParts;
		}
	}
	
	class ItemParts {
		var
			$ribbonID,
			$tasselID,
			$charmID,
			$quoteID,
			$borderID,
			$personalization,
			$customQuote,
			$customImage,
			$handles,
			$postcardAddress;
			
	}
?>
