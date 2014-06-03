<?php
class Quote extends AppModel {

	var $name = 'Quote';
	var $useTable = 'quote';
	var $primaryKey = 'quote_id';
	#var $hasOne = 'RecommendedQuote';

	var $hasMany = array(
		#'RecommendedQuote'=>array('className'=>'RecommendedQuote','foreignKey'=>'Quote_ID')
		# NOT has one! 
	);

}
?>
