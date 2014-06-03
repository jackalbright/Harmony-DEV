<?php
class EmailMessage extends AppModel {

	var $name = 'EmailMessage';
	var $primaryKey = 'email_message_id';
	var $order = 'email_message_id DESC';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'EmailTemplate' => array('className' => 'EmailTemplate',
								'foreignKey' => 'email_template_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

	var $hasMany = array(
			'EmailMessageRecipient' => array('className' => 'EmailMessageRecipient',
								'foreignKey' => 'email_message_id',
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
