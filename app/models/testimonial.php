<?php
class Testimonial extends AppModel {

	var $name = 'Testimonial';
	var $useTable = 'testimonial';
	var $primaryKey = 'testimonial_id';

	var $belongsTo = array(
			"CustomerType" => array('className'=>'CustomerType',
				'foreignKey' => 'customer_type_id',
			),
	);

	var $hasMany = array(
			"ProductTestimonial" => array('className'=>'ProductTestimonial',
				'foreignKey' => 'testimonial_id',
			),
			"SpecialtyPageTestimonial" => array('className'=>'SpecialtyPageTestimonial',
				'foreignKey' => 'testimonial_id',
			),
		);

	var $hasAndBelongsToMany = array(
			'Products' => array('className' => 'Product',
						'joinTable' => 'product_testimonials',
						'associationForeignKey' => 'product_type_id',
						'foreignKey' => 'testimonial_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => 'Products.name ASC',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			),
			'SpecialtyPages' => array('className' => 'SpecialtyPage',
						'joinTable' => 'specialty_page_testimonials',
						'associationForeignKey' => 'specialty_page_id',
						'foreignKey' => 'testimonial_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => 'SpecialtyPages.body_title ASC, SpecialtyPages.page_url ASC',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			)
	);

}
?>
