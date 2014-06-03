<?php
class CartItem extends AppModel {

	var $name = 'CartItem';
	var $primaryKey = 'cart_item_id';

	var $hasOne = array(
	);

	function assignToCustomer($session_id, $customer_id)
	{
		$items = $this->findAll(" session_id = '$session_id' ");
		$customer_model = $this->get_model('Customer');
		$product_model = $this->get_model('Product');
		$surcharge_model = $this->get_model('StampSurcharge');

		$customer = $customer_model->read(null, $customer_id);
		$pricing_level = $customer['Customer']['pricing_level'];

		foreach($items as $item)
		{
			$item['CartItem']['customer_id'] = $customer_id;
			# No longer attach customer_id, so they don't get items days/months later when log in another time.
			$code = $item['CartItem']['productCode'];
			$quantity = $item['CartItem']['quantity'];
			
			$product = $product_model->find('first', array('conditions'=>array('code'=>$code)));

			$parts = unserialize($item['CartItem']['parts']);
			$catalogNumber = !empty($parts['catalogNumber']) ? $parts['catalogNumber'] : null;
			$repro = !empty($parts['reproductionStamp']) ? strtolower($parts['reproductionStamp']) : null;
			$stamp_surcharge = null;
			#error_log("REPRO=$repro, CN=$catalogNumber");
			#error_log("PARTS=".print_r($parts,true));
			if ($catalogNumber && $repro != 'yes')
			{
				#error_log("FINDING $catalogNumber IN=". $surcharge_model->name);
				$stamp_surcharge = $surcharge_model->find("Catalog_number = '$catalogNumber'");
			}
			# FAILING TO CONSIDER STAMP_SURCHARGE...
			#error_log("SURCHARGE=".print_r($stamp_surcharge,true));

			#error_log("CODE=$code, Q=$quantity, C=".print_r($customer['Customer'],true));
			#error_log("CN=$catalogNumber, REPRO=$repro, SS=".print_r($stamp_surcharge,true));
			#error_log("PARTS=".print_r($parts,true));

			$unitPrice = $product_model->get_effective_base_price($code, $quantity, $customer['Customer'], $stamp_surcharge, $parts, $catalogNumber);

			#error_log("UNITPRICE=".print_r($unitPrice,true));

			$item['CartItem']['unitPrice'] = $unitPrice['total'];

			# ALSO switch pricing over to wholesale, if set....


			$this->save($item);
		}
	}
}
?>
