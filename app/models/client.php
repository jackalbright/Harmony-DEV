<?php
class Client extends AppModel {

	var $name = 'Client';
	var $primaryKey = 'client_id';
	var $order = 'sort_index ASC, client_id ASC';

	var $hasMany = array(
		"SpecialtyPageClient" => array('className'=>'SpecialtyPageClient',
			'foreignKey' => 'client_id',
		),
	);

	var $hasAndBelongsToMany = array(
			'SpecialtyPages' => array('className' => 'SpecialtyPage',
						'joinTable' => 'specialty_page_clients',
						'associationForeignKey' => 'specialty_page_id',
						'foreignKey' => 'client_id',
						'unique' => true,
						'order' => 'SpecialtyPages.body_title ASC, SpecialtyPages.page_url ASC',
			)
	);

}
?>
