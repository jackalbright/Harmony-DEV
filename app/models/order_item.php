<?php
class OrderItem extends AppModel {

	var $name = 'OrderItem';
	var $useTable = 'order_item';
	var $primaryKey = 'order_item_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Purchase' => array('className' => 'Purchase',
								'foreignKey' => 'purchase_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Product' => array('className' => 'Product',
								'foreignKey' => 'product_type_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

	var $hasOne = array(
		#'ItemPart'=>array('className'=>'ItemPart',
		#	'foreignKey'=>'order_item_id',
		#)
	);
	var $hasMany = array( # Possibly multiple sides. all future code will have to reference as list.
		'ItemPart'=>array('className'=>'ItemPart',
			'foreignKey'=>'order_item_id',
		)
	);

	function getItemNumber($orderItem) # Simplify!
	{
		$item = !empty($orderItem['OrderItem']) ? $orderItem['OrderItem'] : $orderItem;

		$productModel = $this->get_model("Product");
		$borderModel = $this->get_model("Border");
		$galleryImageModel = $this->get_model("GalleryImage");
		$quoteModel = $this->get_model("Quote");
		$customImageModel = $this->get_model("CustomImage");

		$itemNumber = "";

		$side = 1; foreach($orderItem['ItemPart'] as $part)
		{
			$product = $productModel->read(null, $item['product_type_id']);
			if(empty($product)) { return null; }
	
			$customImage = !empty($part['imageID']) ? $customImageModel->read(null, $part['imageID']) : null;
			$galleryImage = !empty($part['catalogNumber']) ? $galleryImageModel->find(" GalleryImage.catalog_number = '{$part['catalogNumber']}'") : null;
	
			$repro = (strtolower($item['reproduction']) == 'yes');
			$itemNumber .= $repro ? "R-" : "";

			$productCode = $product['Product']['code'];

			##print_r($part);
	

			if(in_array($productCode, array('B','BNT','BC','BB')) && !empty($part['charm_ID'])) 
			{
				$productCode = 'BC';
			} else if(in_array($productCode, array('B','BNT','BC','BB')) && empty($part['tassel_ID']) && $productCode != 'BB') {
				$productCode = 'BNT';
			}

			/*
			if(!empty($part['border_ID'])) 
			{
				$itemNumber .= '-B'.$part['border_ID'];
			}
	
			if(!empty($part['quote_ID'])) 
			{
				$itemNumber .= '-Q'.$part['quote_ID'];
			}
	
			if(!empty($part['personalization']))
			{
				$itemNumber .= '-P';
			}
			*/
			if($side <= 1)
			{
				$itemNumber .= $productCode;
			}

			if(!empty($galleryImage)) { $itemNumber .= '-'.$galleryImage['GalleryImage']['catalog_number']; }
			if(!empty($customImage)) { $itemNumber .= (($side > 1)?'/':'-').'CI-'.$customImage['CustomImage']['Image_ID']; }
	
			# XXX needs to match what MYOBItem says...
			# If discrepency, may cause errors (esp w/pricing, etc) - but maybe ok!

			$side++;

		}


		return $itemNumber;
	}

	function OLDgetItemNumber($orderItem)
	{
		$item = !empty($orderItem['OrderItem']) ? $orderItem['OrderItem'] : $orderItem;

		$productModel = $this->get_model("Product");
		$borderModel = $this->get_model("Border");
		$galleryImageModel = $this->get_model("GalleryImage");
		$quoteModel = $this->get_model("Quote");
		$customImageModel = $this->get_model("CustomImage");

		$itemNumber = "";



		foreach($orderItem['ItemPart'] as $part)
		{
			if(!empty($itemNumber))
			{
				$itemNumber .= " / ";
			}

			$product = $productModel->read(null, $item['product_type_id']);
			if(empty($product)) { return null; }
	
			$customImage = !empty($part['imageID']) ? $customImageModel->read(null, $part['imageID']) : null;
			$galleryImage = !empty($part['catalogNumber']) ? $galleryImageModel->find(" GalleryImage.catalog_number = '{$part['catalogNumber']}'") : null;
	
			$repro = (strtolower($item['reproduction']) == 'yes');
			$itemNumber .= $repro ? "R-" : "";
	
			$itemNumber .= $product['Product']['code'];
	
			if(!empty($galleryImage)) { $itemNumber .= '-'.$galleryImage['GalleryImage']['catalog_number']; }
			if(!empty($customImage)) { $itemNumber .= '-CI-'.$customImage['CustomImage']['Image_ID']; }
	
			if(!empty($part['charm_ID']))
			{
				$itemNumber .= '-C'.$part['charm_ID'];
			}
	
			if(!empty($part['tassel_ID']))
			{
				$itemNumber .= '-T'.$part['tassel_ID'];
			}
	
			if(!empty($part['border_ID'])) 
			{
				$itemNumber .= '-B'.$part['border_ID'];
			}
	
			if(!empty($part['quote_ID'])) 
			{
				$itemNumber .= '-Q'.$part['quote_ID'];
			}
	
			if(!empty($part['personalization']))
			{
				$itemNumber .= '-P';
			}
	
			# XXX needs to match what MYOBItem says...
			# If discrepency, may cause errors (esp w/pricing, etc) - but maybe ok!

		}


		return $itemNumber;
	}

	function getItemDescription($orderItem)
	{
		# XXX Fix for two sides, hasMany

		$item = !empty($orderItem['OrderItem']) ? $orderItem['OrderItem'] : $orderItem;

		$productModel = $this->get_model("Product");
		$charmModel = $this->get_model("Charm");
		$tasselModel = $this->get_model("Tassel");
		$quoteModel = $this->get_model("Quote");
		$galleryImageModel = $this->get_model("GalleryImage");
		$borderModel = $this->get_model("Border");
		$customImageModel = $this->get_model("CustomImage");

		$product = $productModel->read(null, $item['product_type_id']);
		if(empty($product)) { return null; }

		$itemDescription = $product['Product']['name']; # Could be stock item

		if(count($orderItem['ItemPart']) > 1)
		{
			$itemDescription .= " (Double Sided) ";
		}

		$side = 1; foreach($orderItem['ItemPart'] as $part)
		{
			if($side > 1) { $itemDescription .= " / "; }
	
			$customImage = !empty($part['imageID']) ? $customImageModel->read(null, $part['imageID']) : null;
			$galleryImage = !empty($part['catalogNumber']) ? $galleryImageModel->find(" GalleryImage.catalog_number = '{$part['catalogNumber']}'") : null;
			$repro = strtolower($item['reproduction']) == 'yes' ? " (repro) " : "";
	
			if(!empty($customImage)) { $itemDescription = "Custom $itemDescription"; }
			if(!empty($galleryImage)) { $itemDescription = $galleryImage['GalleryImage']['stamp_name'] . "$repro $itemDescription"; }
	
			if(!empty($part['charm_ID']) && $part['charm_ID'] != -1)
			{
				$charm = $charmModel->read(null, $part['charm_ID']);
				$itemDescription = $itemDescription . ", " . $charm['Charm']['name'] . " Charm";
			}
	
			if(!empty($part['tassel_ID']) && $part['tassel_ID'] != -1)
			{
				$tassel = $tasselModel->read(null, $part['tassel_ID']);
				$itemDescription = $itemDescription . ", " . ucwords($tassel['Tassel']['color_name']) . " Tassel";
			}
	
			if(!empty($part['border_ID']) && $part['border_ID'] != -1)
			{
				$border = $borderModel->read(null, $part['border_ID']);
				$itemDescription = $itemDescription . ", " . ucwords($border['Border']['name']) . " Border";
			}
	
			if(!empty($part['quote_ID']) && $part['quote_ID'] != -1)
			{
				$quote = $quoteModel->find('first', array('conditions'=>array('quote_id'=>$part['quote_ID'])));
				$itemDescription = $itemDescription . ', "' . substr($quote['Quote']['text'], 0,25) . '..."';
			}

			if($side > 1)
			{
				$itemDescription .= " (incl. printing on back \$0.20 ea)";
			}

			$side++;
		}


		return $itemDescription;
	}

}
?>
