<?php
class PageFolder extends AppModel {

	var $name = 'PageFolder';
	var $primaryKey = 'folder_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'ParentFolder' => array('className' => 'PageFolder',
								'foreignKey' => 'parent_folder_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

	var $hasMany = array(
			'ChildFolder' => array('className' => 'PageFolder',
								'foreignKey' => 'parent_folder_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
			'Pages' => array('className' => 'StaticPage',
								'foreignKey' => 'folder_id',
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