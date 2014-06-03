<?php
class EmailMessageRecipient extends AppModel {

	var $name = 'EmailMessageRecipient';
	var $primaryKey = 'email_message_recipient_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'EmailMessage' => array('className' => 'EmailMessage',
								'foreignKey' => 'email_message_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Customer' => array('className' => 'Customer',
								'foreignKey' => 'customer_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>