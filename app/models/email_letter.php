<?php
class EmailLetter extends AppModel {

	var $name = 'EmailLetter';
	var $primaryKey = 'email_letter_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'EmailTemplate' => array('className' => 'EmailTemplate', 'foreignKey' => 'email_template_id'),
			#'Ribbon'=>array('className'=>'Ribbon','foriegnKey'=>'ribbon_id'),
			#'Charm'=>array('className'=>'Charm','foriegnKey'=>'charm_id'),
			#'Tassel'=>array('className'=>'Tassel','foriegnKey'=>'tassel_id'),
			#'Border'=>array('className'=>'Border','foriegnKey'=>'border_id')
	);
}
?>
