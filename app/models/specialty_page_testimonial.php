<?php
class SpecialtyPageTestimonial extends AppModel {

	var $name = 'SpecialtyPageTestimonial';
	var $primaryKey = 'specialty_page_testimonial_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'SpecialtyPage' => array('className' => 'SpecialtyPage',
								'foreignKey' => 'specialty_page_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Testimonial' => array('className' => 'Testimonial',
								'foreignKey' => 'testimonial_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>
