<?php
class SpecialtyPageClient extends AppModel {

	var $name = 'SpecialtyPageClient';
	var $primaryKey = 'specialty_page_client_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'SpecialtyPage' => array('className' => 'SpecialtyPage',
								'foreignKey' => 'specialty_page_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Client' => array('className' => 'Client',
								'foreignKey' => 'client_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>