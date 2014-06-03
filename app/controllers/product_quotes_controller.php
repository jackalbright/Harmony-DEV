<?php
class ProductQuotesController extends AppController {

	var $name = 'ProductQuotes';
	var $helpers = array('Html', 'Form');
	var $uses = array('ProductQuote','Quote','Product');

	function admin_index($pid = null) {
		# View for juist product, 
		# view for just quote...

		if (!$pid) { $this->redirect("/admin/products"); }
		$product = $this->Product->read(null,$pid);
		$maxLength = $product['Product']['quote_limit'];
		$this->set("product", $product);

		if (!empty($this->data['keywords']))
		{
			$kw = $this->data['keywords'];
			$quotes = $this->Quote->findAll(" (text LIKE '%$kw%' OR attribution LIKE '%$kw%' OR subjects LIKE '%$kw%') " . ($maxLength > 0 ? " AND (LENGTH(text)+LENGTH(attribution)) <= '$maxLength' " : ""));
			$this->set("quotes", $quotes);
		}
		#$this->ProductQuote->recursive = 0;
		#$this->set('productQuotes', $this->paginate());
		$this->set("product_quotes", $this->ProductQuote->findAll(" product_type_id = '$pid' "));

		$products = $this->Product->findAll(" available = 'yes' AND buildable = 'yes' ");
		$product_map = Set::combine($products, "{n}.Product.code", "{n}.Product");
		$this->set("products", $product_map);
	}

	function admin_update($pid = null)
	{
		if (!$pid) { $this->redirect("/admin/products"); }
		$product = $this->Product->read(null, $pid);

		if (!empty($this->data['quote_id']))
		{
			$this->ProductQuote->deleteAll(" product_type_id = '$pid' ");

			$quotes = array();
			foreach($this->data['quote_id'] as $quote_id)
			{
				$quotes[] = array('ProductQuote'=>
					array(
						'quote_id'=>$quote_id,
						'product_type_id'=>$pid
					)
				);
			}

			$this->ProductQuote->saveAll($quotes);
			$this->redirect("/admin/product_quotes/index/$pid");
		}
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ProductQuote.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('productQuote', $this->ProductQuote->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->ProductQuote->create();
			if ($this->ProductQuote->save($this->data)) {
				$this->Session->setFlash(__('The ProductQuote has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ProductQuote could not be saved. Please, try again.', true));
			}
		}
		$products = $this->ProductQuote->Product->find('list');
		$quotes = $this->ProductQuote->Quote->find('list');
		$this->set(compact('products', 'quotes'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ProductQuote', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->ProductQuote->save($this->data)) {
				$this->Session->setFlash(__('The ProductQuote has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ProductQuote could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ProductQuote->read(null, $id);
		}
		$products = $this->ProductQuote->Product->find('list');
		$quotes = $this->ProductQuote->Quote->find('list');
		$this->set(compact('products','quotes'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ProductQuote', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ProductQuote->del($id)) {
			$this->Session->setFlash(__('ProductQuote deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
