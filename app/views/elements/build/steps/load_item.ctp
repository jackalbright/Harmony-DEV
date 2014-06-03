	<?
	if ( array_key_exists ('cartID', $_REQUEST) ) 
	{
		$cartID = $_REQUEST['cartID'];
		$currentItem = $shoppingCart[$cartID];
		if (!$currentItem->parts->reproductionStamp)
		{
			$stampReproduction="Yes";
		};
		$isNewItem = false;
	} 
	elseif (array_key_exists('reorder', $_REQUEST)) 
	{
		$itemID = $_REQUEST['itemID'];
		$result = mysql_query ("SELECT item_parts.*, order_item.* FROM item_parts, order_item WHERE item_parts.order_item_id=$itemID and order_item.order_item_id=$itemID", $database);
		while ($row = mysql_fetch_object($result))
		{
			$itemCustomImageID=$row->imageID;
			$itemRibbonID=$row->ribbon_ID;
			$itemTasselID=$row->tassel_ID;
			$itemCharmID=$row->charm_ID;
			$itemQuoteID=$row->quote_ID;
			$itemBorderID=$row->border_ID;
			$itemCustomQuote=$row->custom_quote;
			$itemPersonalization=$row->personalization;
			$itemStampID=$row->stampNumber;
			$itemFrameID=$row->frameID;
			$itemPinStyle=$row->pinStyle;
			$itemShirtSize=$row->Size;
			$itemPrintSide=$row->printSide;
			$itemReproduction = $row->reproduction;
			$stampReproduction=$row->reproductionStamp;
			if ($stampReproduction == "yes")
			{
				$stampReproduction = "No";
			} 
			else 
			{
				$stampReproduction = "Yes";
			};
			$personalizationStyle=$row->personalizationStyle;
			$itemComments=$row->comments;
		};
		$cartID = null;
		$currentItem = new CartItem();
		$isNewItem = false;
		if ($itemStampID !="")
		{
			$currentItem->parts->catalogNumber = $itemStampID;
		} 
		else 
		{
			unset($currentItem->parts->catalogNumber);
		};
		if ($itemCustomImageID != "")
		{
			$currentItem->parts->customImageID = $itemCustomImageID;
		} 
		else 
		{
			unset($currentItem->parts->customImageID);
		};
		if ($itemQuoteID != "")
		{
			$currentItem->parts->quoteID = $itemQuoteID;
		} 
		else {
			unset($currentItem->parts->quoteID);
		};
		if ($itemShirtSize != "")
		{
			$currentItem->parts->shirtSize = $itemShirtSize;
		} 
		else 
		{
			unset($currentItem->parts->shirtSize);
		};
		if ($itemPrintSide != "")
		{
			$currentItem->parts->printSide = $itemPrintSide;
		} 	else 
		{
			unset($currentItem->parts->printSide);
		};
		if ($itemCustomQuote != "")
		{
			$currentItem->parts->customQuote =$itemCustomQuote;
		};
		if ($itemBorderID != "")
		{
			$currentItem->parts->borderID = $itemBorderID;
		} 
		else 
		{
			unset($currentItem->parts->borderID);
		};
		if ($itemTasselID != "")
		{
			$currentItem->parts->tasselID = $itemTasselID;
		} 
		else 
		{
			unset($currentItem->parts->tasselID);
		};
		if ($itemCharmID != "")	
		{
			$currentItem->parts->charmID = $itemCharmID;
		} else 
		{
			unset($currentItem->parts->charmID);
		};
		if ($itemFrameID != "")
		{
			$currentItem->parts->frameID = $itemFrameID;
		} 
		else 
		{
			unset($currentItem->parts->frameID);
		};
		if ($itemPinStyle != "")
		{
		  if ($itemPinStyle =="Tie Tack")
		  {
		  	$currentItem->parts->pinStyle = "Tie Tack";
		  } 
		  else 
		  {
		  	$currentItem->parts->pinStyle = "Bar";
		  };
		} 
		else 
		{
			unset($currentItem->parts->pinStyle);
		};
		if ($itemPosterFrame != "Yes")
		{
			$currentItem->parts->posterframe = true;
		} 
		else 
		{
			unset($currentItem->parts->posterframe);
		};
		if ($itemRibbonID != "")
		{
			$currentItem->parts->ribbonID = $itemRibbonID;
		} 
		else 
		{
			unset($currentItem->parts->ribbonID);
		};
		if ($itemPersonalization != "")
		{
			$tempPers=str_replace("%20", " ", $itemPersonalization);
			$currentItem->parts->personalization = str_replace("<br />", "\n", $tempPers);
			$currentItem->parts->personalizationStyle = $personalizationStyle;
		};
		if ($itemComments != "")
		{
			$currentItem->comments = $itemComments;
		}
		if (array_key_exists('quantity', $_REQUEST))
		{
			$currentItem->quantity = $_REQUEST['quantity'];
		};

	} 
	else 
	{
		$cartID = null;
		$currentItem = new CartItem();
		$isNewItem = true;
	}

?>
