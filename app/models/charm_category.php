<?php
class CharmCategory extends AppModel {

	var $name = 'CharmCategory';
	var $primaryKey = 'charm_category_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'CharmCategoryCharm'=>array('className'=>'CharmCategoryCharm', 'foreignKey'=>'charm_category_id'),
	);
	var $hasAndBelongsToMany = array(
			'Charm' => array('className' => 'Charm',
						'joinTable' => 'charm_category_charms',
						'associationForeignKey' => 'charm_id',
						'foreignKey' => 'charm_category_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => 'Charm.name ASC',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			)
	);

}
?>
