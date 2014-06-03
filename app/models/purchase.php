<?php
class Purchase extends AppModel {

	var $name = 'Purchase';
	var $useTable = 'purchase';
	var $primaryKey = 'purchase_id';

	var $hasMany = array(
		'OrderItem'=>array('className'=>'OrderItem',
					'foreignKey' => 'purchase_id'
					),

	);

	var $belongsTo = array(
		'Customer'=>array('className'=>'Customer','foreignKey'=>'Customer_ID'),
		'ShippingMethod'=>array('className'=>'ShippingMethod','foreignKey'=>'Shipping_Method')
	);

	function getOrderDetails($purchase_id)
	{
		$result = $this->read(null, $purchase_id);

		if(!empty($result['OrderItem']))
		{
			foreach($result['OrderItem'] as &$orderItem)
			{
				if(!empty($orderItem['ItemPart']))
				{
					$orderItem[0]['itemNumber'] = $this->OrderItem->getItemNumber($orderItem);
					$orderItem[0]['itemDescription'] = $this->OrderItem->getItemDescription($orderItem);
				}
			}
		}

		return $result;
	}

}
?>
