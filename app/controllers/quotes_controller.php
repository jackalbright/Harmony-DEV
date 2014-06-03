<?php
class QuotesController extends AppController {

	var $name = 'Quotes';
	var $helpers = array('Html', 'Form');
	var $uses = array('Quote','GalleryImage','GalleryCategory','ProductQuote','RecommendedQuote');

	function index($code = '', $catalog_number = '')
	{
		$maxLength = 0;

		if(!empty($code))
		{
			$product = $this->Product->find(" code = '$code' ");
			$maxLength = $product['Product']['quote_limit'];
		}

		if(!empty($product))
		{
			$product_id = $product['Product']['product_type_id'];
			$this->ProductQuote->recursive = 1;
			$product_quotes = $this->ProductQuote->findAll(" ProductQuote.product_type_id = '$product_id' ");
			$this->set("productQuotes", $product_quotes);
		}

		if(!empty($catalog_number))
		{
			$this->load_recommended_quotes($catalog_number);
		}

		$keywords = null;

		if(!empty($this->data['keywords']))
		{
			$keywords = $this->data['keywords'];
		} else if (!empty($this->params['form']['keywords'])) { 
			$keywords = $this->params['form']['keywords'];
		} else if (!empty($this->passedArgs['keywords'])) { 
			$keywords = $this->passedArgs['keywords'];
		}

		$this->set("keywords", $keywords);

		if (!empty($keywords))
		{
			# Do search.
			$keyword_list = split(" ", $keywords);

			$keyword_where_list = array();
			foreach($keyword_list as $kw)
			{
				$keyword_where_list[] = "CONCAT(text,attribution,subjects)  LIKE '%$kw%'";
			}
			$keyword_where = join(" AND ", $keyword_where_list);

			$kw = mysql_escape_string($keywords);
			#$quotes = $this->Quote->find('all', array('conditions'=>" (text LIKE '%$kw%' OR attribution LIKE '%$kw%' OR subjects LIKE '%$kw%') " . ($maxLength > 0 ? " AND (LENGTH(text)+LENGTH(attribution)) <= '$maxLength' " : "")) );
			#$quotes = $this->paginate('Quote', array( " (text LIKE '%$kw%' OR attribution LIKE '%$kw%' OR subjects LIKE '%$kw%') " . ($maxLength > 0 ? " AND (LENGTH(text)+LENGTH(attribution)) <= '$maxLength' " : "")) );
			# Look for words in any order, with text in between keywords, etc....

			# How do we find whether text, attribution OR subjects has all keywords, when could be mixed????
			$quotes = $this->paginate('Quote', array( " ($keyword_where) " . ($maxLength > 0 ? " AND (LENGTH(text)+LENGTH(attribution)) <= '$maxLength' " : "")) );
			$this->set("quotes", $quotes);
		}

		$category_stack = array();
		$this->set("category_stack", $category_stack);

		$parent_node_id = 1; # Default..

		#print_r($this->data);

		if (!empty($this->params['form']['browse_node_id']))
		{
			$this->set("browse_node_id", $this->params['form']['browse_node_id']);
			$browse_node_id = $this->params['form']['browse_node_id'];
			$parent_node_id = $browse_node_id;
			$this->set("browse_node_id", $browse_node_id);
		}
		else if (!empty($this->passedArgs['browse_node_id']))
		{
			$this->set("browse_node_id", $this->passedArgs['browse_node_id']);
			$browse_node_id = $this->passedArgs['browse_node_id'];
			$parent_node_id = $browse_node_id;
			$this->set("browse_node_id", $browse_node_id);
		}

		$all_categories = $this->GalleryCategory->findAll("",array(),"GalleryCategory.browse_name");
		$categories_by_parent_id = array();
		foreach($all_categories as $ac)
		{
			$pid = $ac['GalleryCategory']['parent_node'];
			if (empty($categories_by_parent_id[$pid])) { $categories_by_parent_id[$pid] = array(); }
			$categories_by_parent_id[$pid][] = $ac;
		}
		$categories_by_node_id = Set::combine($all_categories, '{n}.GalleryCategory.browse_node_id', '{n}');

		$this->set("all_categories", $all_categories);
		#$this->set("categories_by_parent_id", $categories_by_parent_id);
		#$this->set("categories_by_node_id", $categories_by_node_id);

		$base_categories = Set::combine($categories_by_parent_id[1], "{n}.GalleryCategory.browse_node_id", "{n}.GalleryCategory.browse_name");
		$this->set("categories", $base_categories);

		if (!empty($browse_node_id) && $browse_node_id > 1)
		{
			#$browse_node_id = $this->params['url']['browse_node_id'];
			$parent_node_id = $browse_node_id;

			$kw = $categories_by_node_id[$browse_node_id]['GalleryCategory']['browse_name'];

			$quotes = $this->paginate('Quote', array(" (subjects LIKE '%$kw%') " . ($maxLength > 0 ? " AND (LENGTH(text)+LENGTH(attribution)) <= '$maxLength' " : "")));
			$this->set("browse_quotes", $quotes);
		}

		if(!empty($this->build['options']['quoteID']))
		{
			$quote = $this->Quote->read(null, $this->build['options']['quoteID']);
			$this->set("current_quote", $quote);
		}

		$category_stack = array();

		$cid = $parent_node_id;
		do
		{
			array_unshift($category_stack, $cid);
			$cat = $categories_by_node_id[$cid];
			$cid = $cat['GalleryCategory']['parent_node'];
		} while($cid >= 1);
		#print_r($category_stack);

		$this->set("category_stack", $category_stack);

		$this->set("parent_node_id", $parent_node_id);

		$this->set("code", $code);
		$this->set("keywords", $keywords);
		$this->set("prod", $code);
	}

	function load_recommended_quotes($catalogNumber)
	{
		$maxLength = $this->build['Product']['quote_limit'];
		$this->RecommendedQuote->recursive = -1;

		$stamp = $this->GalleryImage->find("GalleryImage.catalog_number = '$catalogNumber' ");

		$stampID = $stamp['GalleryImage']['stampID'];

		#$recommended = $catalogNumber != "" ? $this->RecommendedQuote->findAll("RecommendedQuote.Catalog_Number = '$catalogNumber'") : array();
		$recommended = $stampID != "" ? $this->RecommendedQuote->findAll("RecommendedQuote.stamp_id = '$stampID'") : array();
		$quote_id = array();
		foreach($recommended as $rec)
		{
			$quote_id[] = $rec['RecommendedQuote']['Quote_ID'];
		}
		$quote_id_csv = join(",", $quote_id);
		$recommendedQuotes = $quote_id_csv ? $this->Quote->findAll(" Quote.quote_id IN ($quote_id_csv) AND LENGTH(Quote.text)+LENGTH(Quote.attribution) <= '$maxLength'") : null;
		$this->set("recommendedQuotes", $recommendedQuotes);
	}

	function search_ajax()
	{
		$this->layout = 'ajax';
		Configure::write("debug", 0);
	}

	function search()
	{
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Quote.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('quote', $this->Quote->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Quote->create();
			if ($this->Quote->save($this->data)) {
				$this->Session->setFlash(__('The Quote has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Quote could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Quote', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Quote->save($this->data)) {
				$this->Session->setFlash(__('The Quote has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Quote could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Quote->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Quote', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Quote->del($id)) {
			$this->Session->setFlash(__('Quote deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->Quote->recursive = 0;
		$this->set('quotes', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Quote.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('quote', $this->Quote->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Quote->create();
			if ($this->Quote->save($this->data)) {
				$this->Session->setFlash(__('The Quote has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Quote could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Quote', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Quote->save($this->data)) {
				$this->Session->setFlash(__('The Quote has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Quote could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Quote->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Quote', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Quote->del($id)) {
			$this->Session->setFlash(__('Quote deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
