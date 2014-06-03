<?php
class SpecialtyPageSectionContent extends AppModel {

	var $name = 'SpecialtyPageSectionContent';
	var $useTable = 'specialty_page_section_content';
	var $primaryKey = 'specialty_page_section_content_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'SpecialtyPage' => array('className' => 'SpecialtyPage',
								'foreignKey' => 'specialty_page_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>
