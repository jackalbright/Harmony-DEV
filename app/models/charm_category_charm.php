<?php
class CharmCategoryCharm extends AppModel {

	var $name = 'CharmCategoryCharm';
	var $primaryKey = 'charm_category_charm_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'CharmCategory' => array('className' => 'CharmCategory',
								'foreignKey' => 'charm_category_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Charm' => array('className' => 'Charm',
								'foreignKey' => 'charm_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>
