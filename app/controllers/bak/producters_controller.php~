<?php
class ProductersController extends AppController {

	var $name = 'Producters';
	var $helpers = array('Html', 'Form');

	function beforeFilter()
	{
		parent::beforeFilter();

		switch($this->action)
		{
			case 'admin_add':
			case 'admin_edit':
			case 'add':
			case 'edit':
				if (!empty($this->data['Product']['image_type'])) { $this->data['Product']['image_type'] = join(",", $this->data['Product']['image_type']); }

				break;
		}
	}

	function beforeRender()
	{
		parent::beforeRender();

		switch($this->action)
		{
			case 'admin_add':
			case 'admin_edit':
			case 'add':
			case 'edit':
				#$this->set("image_types", $this->Product->getSetValues('image_type'));
				$this->set("stamp_types", $this->Product->getEnumValues('stamp'));


				break;
		}
	}

	function index() {
error_log("CAKE!");
		$this->Product->recursive = 0;
		$this->set("body_title", "Select a Product:");
		#$this->set('products', $this->paginate());
		$this->set("items_per_row", 6);
		$this->set("rightbar_disabled", true);

		$this->set("popular_products", $this->Product->findAll("available = 'yes' AND is_popular = 1 AND buildable = 'yes' AND parent_product_type_id IS NULL", array(), 'sort_index, name'));
		$this->set("stock_products", $this->Product->findAll("available = 'yes' AND is_stock_item = 1 AND parent_product_type_id IS NULL", array(), 'sort_index, name'));
		$this->set("all_products", $this->Product->findAll("available = 'yes' AND is_stock_item = 0 AND buildable = 'yes' AND parent_product_type_id IS NULL", array(), 'sort_index, name'));
	}

	function select() 
	{
		$this->Product->recursive = 0;

		$catalog_number = $this->Session->read("Build.catalog_number");
		$image_id = $this->Session->read("Build.image_id");

		$image_name = "";
		if ($catalog_number)
		{
			$image = $this->GalleryImage->find("catalog_number = '$catalog_number'");
			$image_name = "'" . $image['GalleryImage']['stamp_name'] . "'";
			$this->set("products", $this->getImageAvailableProducts($catalog_number));

			$this->action = "select_stamp_products";
		} else if ($image_id) { 
			# XXX TODO

		} else { # Haven't chosen one yet.
			$this->set("popular_products", $this->Product->find("is_popular = '1'", array(), 'sort_index, name'));
			$this->set("all_products", $this->Product->find("is_popular = '0' OR is_popular IS NULL", array(), 'sort_index, name'));
		}

		$this->set("body_title", "Choose a product for your $image_name gift:");
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Product.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Product->recursive = 2;
		if (!is_numeric($id))
		{
			$product = $this->Product->findByName($id);
		} else {
			$product = $this->Product->read(null, $id);
		}

		$this->breadcrumbs["/products/view/".$product['Product']['prod']] = ($product['Product']['name']);

		$this->set('product', $product);
		$this->set('product_pricings', $this->Product->generate_pricing_list($product));
		$this->set("product_plural_name", $this->Product->plural_name($product));
		$this->set("body_title", $product['Product']['body_title']);
		$this->pageTitle = $product['Product']['page_title']; 
		$this->set("rightbar_template", "products/rightbar");
	}

	function admin_index() {
		$this->Product->recursive = 0;
		$this->set('products', $this->paginate());
		#$this->set('products', $this->Product->findAll());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Product.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('product', $this->Product->read(null, $id));
	}

	function admin_add() {
		$this->action = 'admin_edit';
		if (!empty($this->data)) {
			$this->Product->create();
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(__('The Product has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Product could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Product', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set("product_id", $id);
		if (!empty($this->data)) {
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(__('The Product has been saved', true));
				#$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Product could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Product->read(null, $id);
			#$this->data['product_pricing_matrix'] = $this->Product->create_pricing_matrix($this->data);
			#print_r($this->data['product_pricing_matrix']);
		}

		$product_count = $this->Product->find('count', array('conditions'=>array('buildable' => 'yes')));
		$popularity_options = array(''=>'N/A');
		for($i = 0; $i <$product_count; $i++)
		{
			$popularity_options[$i] = $i;
		}
		$this->set("popularity_ranking_options", $popularity_options);
		$this->set("parent_product_types", $this->Product->get_product_option_list($id));

		include_once("includes/image_gallery.php");
		$count = get_gallery_file_count("details/".$this->data['Product']['name'], 'jpg');
		#echo "C=$count, P=".$this->data['Product']['name'];
		$this->set("gallery_image_count", $count);
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Product', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Product->del($id)) {
			$this->Session->setFlash(__('Product deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
