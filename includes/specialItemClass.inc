<?php
	class SpecialItem {
		var
			$id,
			$catalogPrefix,
			$title,
			$description,
			$personalization,
			$customBorder,
			$customCharm,
			$customQuote,
			$customRibbon,
			$customTassel,
			$borders,
			$charms,
			$quotes,
			$ribbons,
			$tassels,
			$pricing,
			$product;
			
		function SpecialItem () {
			$this->product = new ProductType;
			$this->borders = array();
			$this->charms = array();
			$this->quotes = array();
			$this->ribbons = array();
			$this->tassels = array();
			$this->pricing = array();
		}
		function initItem ($dbItem) {
			$this->id = $dbItem->specialID;
			$this->catalogPrefix = $dbItem->catalogPrefix;
			$this->title = $dbItem->title;
			$this->description = $dbItem->description;
			$this->customBorder = ($dbItem->customBorder == 'yes' ? true : false );
			$this->customCharm = ($dbItem->customCharm == 'yes' ? true : false );
			$this->customQuote = ($dbItem->customQuote == 'yes' ? true : false );
			$this->customRibbon = ($dbItem->customRibbon == 'yes' ? true : false );
			$this->customTassel = ($dbItem->customTassel == 'yes' ? true : false );
			$this->personalization = ($dbItem->personalization == 'yes' ? true : false );
	}
	
	class ProductType {
		var
			$id,
			$name,
			$description,
			$weight,
			$height,
			$width,
			$depth,
			$code,
			$sort_index,
			$quote_limit,
			$stampUse;
	}
	
	class Border {
		var
			$id,
			$name,
			$imageLocation;
	}
	class Charm {
		var
			$id,
			$name,
			$imageLocation;
	}
	class Ribbon {
		var
			$id,
			$name,
			$color;
	}
	class Tassel {
		var
			$id,
			$name,
			$color;
	}
	class Quote {
		var
			$id,
			$title,
			$text,
			$attribution,
			$textLength,
			$attributionLength,
			$useQuotes;
	}
?>