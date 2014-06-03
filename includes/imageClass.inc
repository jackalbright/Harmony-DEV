<?php
/////////////////////////////
//		Image Base Class			//
/////////////////////////////

	class Image {
		var
			$image,
			$thumbnail,
			$name,
			$description,
			$recBorders,
			$recCharms,
			$recQuotes,
			$recRibbons,
			$recTassels;
			
		function displayImg() {
			return $this->image;
		}
		function displayThumb() {
			return $this->thumbnail;
		}
		function displayName() {
			return $this->name;
		}
		function displayDesc() {
			return $this->description;
		}
		function listBorders() {
			return $this->recBorders;
		}
		function listCharms() {
			return $this->recCharms;
		}
		function listQuotes() {
			return $this->recQuotes;
		}
		function listRibbons() {
			return $this->recRibbons;
		}
		function listTassels() {
			return $this->recTassels;
		}
		function imageType() {
			return 'image';
		}
		
	}

/////////////////////////////
//		Stamp Image Class		//
/////////////////////////////
	class Stamp extends Image {
		var
			$catalogNumber,
			$faceValue,
			$issueDate,
			$series,
			$shortDescription,
			$keywords,
			$htmlKeywords,
			$country,
			$trivia;
			
		function Stamp () {
		
		}
		
		function availableToCustomer($customerID) {
			return true;
		}
		
		function catalogNumber() {
			return $this->catalogNumber;
		}
		function detailPageLink($linkText = 'Stamp Information Page') {
			return '<a href="/product/detail.php?catalogNumber=' . $this->catalogNumber . '">' . $linkText . '</a>';
		}
		
		function buildPageLink($productCode, $cartID = false, $linkText = 'modify this item') {
			$temp = '<a href="/product/build.php?catalogNumber=' . $this->catalogNumber;
			$temp .= '&productCode=' . $productCode . '';
			if ($cartID !== false) {
				$temp .= ('&cartID=' . $cartID);
			}
			$temp .= '">' . $linkText . '</a>';
			return $temp;
		}

		function imageType() {
			return 'stamp';
		}

		function initFromDB ($catNum, $db) {
			$stampResult = mysql_query ("Select * from stamp where catalog_number = '$catNum'", $db);
			if ($stampResult) {
				if ($tempStamp = mysql_fetch_object ($stampResult) ) {
					$this->catalogNumber = $catNum;
					$stampID = $tempStamp->stampID;
					$this->image = $tempStamp->image_location;
					$this->thumbnail = $tempStamp->thumbnail_location;
					$this->name = $tempStamp->stamp_name;
					$this->description = $tempStamp->long_description;
					$this->faceValue = $tempStamp->face_value;
					$this->issueDate = $tempStamp->issue_date;
					$this->series = $tempStamp->series;
					$this->shortDescription = $tempStamp->short_description;
					$this->keywords = $tempStamp->keywords;
					$this->htmlKeywords = $tempStamp->HTML_Keywords;
					$this->country = $tempStamp->country;
					$this->trivia = $tempStamp->trivia;
					
					$this->recBorders = array();
					$q = "Select * from border, rec_border where rec_border.stamp_id = '$stampID' and rec_border.border_id = border.border_id and border.available = 'yes'";
					$borderResult = mysql_query ($q, $db);
					if ($borderResult) {
						while ( $tempBorder = mysql_fetch_object($borderResult) ) {
							$temp = new Border;
							$temp->init($tempBorder);
							$this->recBorders[] = $temp;
						}
					}
					$this->recCharms = array();
					$charmResult = mysql_query ("Select * from charm, rec_charm where rec_charm.stamp_id = '$stampID' and rec_charm.charm_id = charm.charm_id and charm.available = 'yes'", $db);
					if ($charmResult) {
						while ( $tempCharm = mysql_fetch_object($charmResult) ) {
							$temp = new Charm;
							$temp->init($tempCharm);
							$this->recCharms[] = $temp;
						}
					}
					$this->recQuotes = array();
					$quoteResult = mysql_query ("Select * from quote, rec_quote where rec_quote.catalog_number = '$catNum' and rec_quote.quote_id = quote.quote_id", $db);
					if ($quoteResult) {
						while ( $tempQuote = mysql_fetch_object($quoteResult) ) {
							$temp = new Quote;
							$temp->init($tempQuote);
							$this->recQuotes["q$temp->id"] = $temp;
						}
					}
					$this->recRibbons = array();
					$ribbonResult = mysql_query ("Select * from ribbon, rec_ribbon where rec_ribbon.stamp_id = '$stampID' and rec_ribbon.ribbon_id = ribbon.ribbon_id and ribbon.available = 'yes'", $db);
					if ($ribbonResult) {
						while ( $tempRibbon = mysql_fetch_object($ribbonResult) ) {
							$temp = new Ribbon;
							$temp->init($tempRibbon);
							$this->recRibbons[] = $temp;
						}
					}
					$this->recTassels = array();
					$tasselResult = mysql_query ("Select * from tassel, rec_tassel where rec_tassel.stamp_id = '$stampID' and rec_tassel.tassel_id = tassel.tassel_id and tassel.available = 'yes'", $db);
					if ($tasselResult) {
						while ( $tempTassel = mysql_fetch_object($tasselResult) ) {
							$temp = new Tassel;
							$temp->init($tempTassel);
							$this->recTassels[] = $temp;
						}
					}
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}


/////////////////////////////
//		Custom Image Class	//
/////////////////////////////
	class CustomImage extends Image {
		var
			$source,
			$approvalStatus,
			$approvalNotes,
			$customerID,
			$submissionDate,
			$approvalDate,
			$imageID;
			
		function initFromDB($imageID, $db) {
			$this->imageID = $imageID;
			$imageResult = mysql_query ("Select * from custom_image where image_id = '$imageID'", $db);
			if ($imageResult) {
				$dbImage = mysql_fetch_object ($imageResult);
				$this->image = $dbImage->display_location;
				$this->thumbnail = $dbImage->thumbnail_location;
				$this->name = $dbImage->Title;
				$this->description = $dbImage->Description;
				$this->recBorders = array();
				$this->recCharms = array();
				$this->recQuotes = array();
				$this->recRibbons = array();
				$this->recTassels = array();
				$this->source = $dbImage-> Image_Location;
				$this->approvalStatus = $dbImage->Approved;
				$this->approvalNotes = $dbImage->approval_notes;
				$this->customerID = $dbImage->Customer_ID;
				$this->submissionDate = $dbImage->Submission_Date;
				$this->approvalDate = $dbImage->Approval_Date;
			} else {
				return false;
			}
		}
		
		function initFromArray($imageID) {
			$this->imageID = $imageID;
			#global $tempImages;
			$tempImages = $_SESSION['tempImages']; if (!is_array($tempImages)) { $tempImages = array(); }
			#error_log("SESS_TI=".print_r($_SESSION['tempImages'],true));

			if ( array_key_exists($imageID, $tempImages) ) {
				$tempImage = $tempImages[$imageID];
				$this->image = $tempImage->display_location;
				$this->thumbnail = $tempImage->thumbnail_location;
				$this->name = $tempImage->Title;
				$this->description = $tempImage->Description;
				$this->recBorders = array();
				$this->recCharms = array();
				$this->recQuotes = array();
				$this->recRibbons = array();
				$this->recTassels = array();
				$this->source = $tempImage->Image_Location;
				$this->approvalStatus = $tempImage->Approved;
				$this->approvalNotes = $tempImage->approval_notes;
				$this->customerID = $tempImage->Customer_ID;
				$this->submissionDate = $tempImage->Submission_Date;
				$this->approvalDate = $tempImage->Approval_Date;
				#error_log("IMGFA=".print_r($tempImage,true));
				#error_log("LOC=".$tempImage->Image_Location);
				#error_log("LOC2=".$this->source);
			} else {
				return false;
			}
		}
		
		function catalogNumber () {
			return 'CI#' . $this->imageID;
		}
		
		function detailPageLink($linkText = 'Custom Image List') {
			return '<a href="/custom/imageList.php">' .  $linkText . '</a>';
		}
		
		function buildPageLink($productCode, $cartID = false, $linkText = 'modify this item') {
			$temp = '<a href="/product/build.php?imageID=' . $this->imageID;
			if ($cartID !== false) {
				$temp .= ('&amp;cartID=' . $cartID);
			}
			$temp .= '&amp;productCode=' . $productCode . '">' . $linkText . '</a>';
			return $temp;
		}

		function imageType() {
			return 'image';
		}
		
		function availableToCustomer($customerID) {
			return ($customerID == $this->customerID);
		}
	}
	
/////////////////////////////
//		Item Part Base Class		//
/////////////////////////////
	class ItemPart {
		var
			$id;
	}
	
/////////////////////////////
//		Border Part Class			//
/////////////////////////////
	class Border extends ItemPart {
		var
			$name,
			$image;
			
		function init ($dbBorder) {
			$this->id = $dbBorder->border_id;
			$this->name = $dbBorder->name;
			$this->image = $dbBorder->location;
		}		
	}

/////////////////////////////
//		Charm Part Class			//
/////////////////////////////
	class Charm extends ItemPart {
		var
			$name,
			$image;
			
		function init ($dbCharm) {
			$this->id = $dbCharm->charm_id;
			$this->name = $dbCharm->name;
			$this->image = $dbCharm->graphic_location;
		}		
	}

/////////////////////////////
//		Quote Part Class			//
/////////////////////////////
	class Quote extends ItemPart {
		var
			$title,
			$text,
			$attribution,
			$textLength,
			$attributionLength,
			$useQuoteMarks;
			
		function init ($dbQuote) {
			$this->id = $dbQuote->quote_id;
			$this->title = $dbQuote->title;
			$this->text = $dbQuote->text;
			$this->attribution = $dbQuote->attribution;
			$this->attributionLength = $dbQuote->attrib_length;
			$this->textLength = $dbQuote->text_length;
			$this->useQuoteMarks = ( ($dbQuote->use_quote_marks == 'yes') ? true : false );
		}		
	}

/////////////////////////////
//		Ribbon Part Class			//
/////////////////////////////
	class Ribbon extends ItemPart {
		var
			$name,
			$color;
			
		function init ($dbRibbon) {
			$this->id = $dbRibbon->ribbon_id;
			$this->name = $dbRibbon->color_name;
			$this->color = $dbRibbon->color_code;
		}		
	}

/////////////////////////////
//		Tassel Part Class			//
/////////////////////////////
	class Tassel extends ItemPart {
		var
			$name,
			$color;
			
		function init ($dbTassel) {
			$this->id = $dbTassel->tassel_id;
			$this->name = $dbTassel->color_name;
			$this->color = $dbTassel->color_code;
		}		
	}

?>
