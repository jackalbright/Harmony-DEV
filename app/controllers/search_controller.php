<?
class SearchController extends AppController
{
	var $uses = array();#'SearchIndex','Product','GalleryImage','SearchStopWord'); # Etc.

	var $equivalentWordsOLD = array(
		'fdr'=>'"Franklin Delano Roosevelt"',
		'jfk'=>'"John F. Kennedy"',
	);

	function index()
	{
	}

	/*

	function OLDindex()
	{
		if(!empty($this->data['SearchIndex']['keywords']))
		{
			$keywordstring = $this->data['SearchIndex']['keywords'];
			$this->set("searchString", $keywordstring); # Input box.

			$keywords = preg_split("/\s+/", $keywordstring);

			# Add equivalent words. (XXX MESSES UP SCORING)
			foreach($keywords as &$kw)
			{
				if(!empty($this->equivalentWords[strtolower($kw)]))
				{
					$kw = "($kw OR ".$this->equivalentWords[strtolower($kw)].")";
				}
			}
			# Since extra words mess up scoring, we should rely upon keyword emphasis/duplication to shift scores manually as desired.

			$keywordstring = join(" ", $keywords);

			$stopWordResults = $this->SearchStopWord->find('all');

			$stopWords = Set::extract("/SearchStopWord/word", $stopWordResults);
			$stopWordsFilter =
			        new Zend_Search_Lucene_Analysis_TokenFilter_StopWords($stopWords);
			     
			$analyzer =
			        new Zend_Search_Lucene_Analysis_Analyzer_Common_TextNum_CaseInsensitive();
			$analyzer->addFilter($stopWordsFilter);
			     
			Zend_Search_Lucene_Analysis_Analyzer::setDefault($analyzer);

			$results = $this->SearchIndex->find('all', array('highlight'=>false, 'conditions'=>array('query'=>$keywordstring)));
			$relevant_results = array();

			$minscore = 0.30;
			# john f kennedy works fine at 0.25 (too much at less), but jfk bookmark doesnt show jfk at 0.25

			foreach($results as $result)
			{
				if($result['SearchIndex']['score'] >= $minscore) # Minimum relevance/score (otherwise too vague)
				{
					$relevant_results[] = $result;
				}
			}
			$this->set("results", $relevant_results);
			#print_r($this->SearchIndex->getDataSource()->getLog());
		}
	}
	*/
}
?>
