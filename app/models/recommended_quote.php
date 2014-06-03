<?php
class RecommendedQuote extends AppModel {

	var $name = 'RecommendedQuote';
	var $useTable = 'rec_quote';
	var $primaryKey = 'rec_quote_id';

	var $belongsTo = array(
		'Quote'=>array('className'=>'Quote','foreignKey'=>'Quote_ID'),
	);

}
?>
