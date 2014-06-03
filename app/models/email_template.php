<?php
class EmailTemplate extends AppModel {

	var $name = 'EmailTemplate';
	var $primaryKey = 'email_template_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'EmailMessage' => array('className' => 'EmailMessage',
								'foreignKey' => 'email_template_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);

}
?>