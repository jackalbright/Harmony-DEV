<?
class SearchIndex extends AppModel
	# STUPID datasource only lets this be called search_indices
{
	var $useDbConfig = 'zendSearchLucene';
	#var $useTable = false;
	#The datasource should work... w/o throwing table error.

}

?>
