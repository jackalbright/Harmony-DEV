<?php
class Faq extends AppModel {

	var $name = 'Faq';
	var $primaryKey = 'faq_id';
	var $order = 'Faq.sort_index ASC';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'FaqTopic' => array('className' => 'FaqTopic',
								'foreignKey' => 'faq_topic_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Product' => array('className' => 'Product',
								'foreignKey' => 'product_type_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Part' => array('className' => 'Part',
								'foreignKey' => 'part_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>
