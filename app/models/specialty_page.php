<?php
class SpecialtyPage extends AppModel {

	var $name = 'SpecialtyPage';
	var $primaryKey = 'specialty_page_id';

	var $validate = array(
		'page_url'=>array(
			'rule' => 'notEmpty',
			'required' => true,
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasAndBelongsToMany = array(
			'Testimonials' => array('className' => 'Testimonial',
						'joinTable' => 'specialty_page_testimonials',
						'associationForeignKey' => 'testimonial_id',
						'foreignKey' => 'specialty_page_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => 'SpecialtyPageTestimonial.sort_order ASC',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			),
			'Clients' => array('className' => 'Client',
						'joinTable' => 'specialty_page_clients',
						'associationForeignKey' => 'client_id',
						'foreignKey' => 'specialty_page_id',
						'unique' => true,
						#'order' => 'SpecialtyPageTestimonial.sort_order ASC',
			)

	);
	var $hasMany = array(
			'SpecialtyPageSampleImages' => array('className' => 'SpecialtyPageSampleImage',
								'foreignKey' => 'specialty_page_id',
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
			'SpecialtyPageSectionContent' => array('className' => 'SpecialtyPageSectionContent',
								'foreignKey' => 'specialty_page_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => 'specialty_page_section_content_id',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);

}
?>
