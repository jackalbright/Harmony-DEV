<?php
class FaqRequest extends AppModel {

	var $name = 'FaqRequest';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'FaqTopic' => array(
			'className' => 'FaqTopic',
			'foreignKey' => 'faq_topic_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>