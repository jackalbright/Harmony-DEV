<?php
	class LegacyCartItem {
		var
			$productCode,
			$specialCode,
			$quantity,
			$unitPrice,
			$comments,
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
			$frameID,
			$pinStyle,
			$personalization,
			$personalizationStyle,
			$customQuote,
			$catalogNumber,
			$reproductionStamp,
			$customImageID;
	}
	
	class CustomerImage {
		var
			$Image_ID,
			$Image_Location,
			$display_location,
			$thumbnail_location,
			$Approved,
			$approval_notes,
			$Customer_ID,
			$Title,
			$Submission_Date,
			$Approval_Date,
			$format,
			$Notes,
			$Description,
			$Show_Field,
			$send_email,
			$unix_date;
	}
?>
