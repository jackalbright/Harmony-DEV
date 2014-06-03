<?php
class FaqTopic extends AppModel {

	var $name = 'FaqTopic';
	var $primaryKey = 'faq_topic_id';
	var $displayField = 'topic_name';
	var $order = 'FaqTopic.sort_index ASC';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'Faq' => array('className' => 'Faq',
								'foreignKey' => 'faq_topic_id',
								'dependent' => false,
								'conditions' => 'enabled = 1',
								'fields' => '',
								'order' => 'Faq.sort_index ASC',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);

}
?>
