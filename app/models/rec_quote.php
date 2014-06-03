<?php
class RecQuote extends AppModel {

	var $name = 'RecQuote';
	var $useTable = 'rec_quote';
	var $primaryKey = 'rec_quote_id';

	var $hasMany = array(
		'Quote'=>array(
			'foreignKey'=>'Quote_ID',
		),
	);

}
?>
