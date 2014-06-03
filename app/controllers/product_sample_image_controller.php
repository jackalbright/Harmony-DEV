<?php
class ProductSampleImageController extends AppController {

	var $name = 'ProductSampleImage';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->ProductSampleImage->recursive = 0;
		$this->set('productSampleImages', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ProductSampleImage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('productSampleImage', $this->ProductSampleImage->read(null, $id));
	}

	function edit_list($product_id = null)
	{
		if (!$product_id)
		{
			$this->Session->setFlash(__('Invalid Product.', true));
			$this->redirect(array('admin'=>true,'controller'=>'products','action'=>'index'));
		}
		$this->ProductSampleImage->recursive = 0;
		$this->set('productSampleImages', $this->ProductSampleImage->findAll("product_type_id = '$product_id'"));
	}

	function sort_list($product_id = null)
	{
		if (!$product_id)
		{
			$this->Session->setFlash(__('Invalid Product.', true));
			$this->redirect(array('admin'=>true,'controller'=>'products','action'=>'index'));
		}
	}

	function add($product_id) {

		$this->add_or_edit_process($product_id);

		$this->action = 'add_or_edit';
	}

	function add_or_edit_process($id = null)
	{
		$session_id = session_id();

		if (!$id && !empty($this->data)) { $id = $this->data['CustomImage'][$this->CustomImage->primaryKey]; }
		$mode = "";

		$path = "";
		$prefix = "";

		if (!$id)
		{
			$this->body_title = "Add Your Image";
			$mode = 'add';
			$this->CustomImage->create();
			$path = "/images/custom/anon/$session_id"; # May want to change once logged in.
			$prefix = time() . rand(0, 10000);

		} else {
			$this->body_title = "Edit Your Image";
			$mode = 'edit';
			# Look up record, make sure id matches session_id.
			$image = $this->CustomImage->read(null, $id);
			if ($image['CustomImage']['session_id'] != $session_id)
			# XXX TODO OR customer_id mismatch.
			{
				$this->Session->setFlash("Invalid image");
				$this->redirect(array('action'=>'index'));
				return;
			}

			$path = dirname($image['CustomImage']['Image_Location']);
			$prefix = preg_replace("/[.]\w+$/", "", basename($image['CustomImage']['Image_Location']));
		}
		$this->set("mode", $mode);

		if (!empty($this->data))
		{
			$return = $this->Image->saveUpload('file', $path, $prefix); # Done separately from actual db
	
			#error_log("RETURNED ($path, $prefix) FROM SAVE=$return");
	
			if ($return && is_array($return))
			{
				$this->Session->setFlash("Unable to save image: " .  join("<br/>\n", $return) );
				#$this->render();
			} else if ($filename = $return) {
				# Create sane sized image.
				# Scale image to thumbnail.
				$display_width = 350;
				$thumb_height = 80;
	
				$this->Image->scaleFile("$path/$filename", "$path/display/$filename", $display_width, null);
				$this->Image->scaleFile("$path/$filename", "$path/thumbs/$filename", null, $thumb_height);
	
				# Now update Image_location
				$this->data['CustomImage']['session_id'] = $session_id;
				# If logged in, use their customer_id instead.
				# XXX TODO
	
				$this->data['CustomImage']['Image_Path'] = "$path"; 
	
				$this->data['CustomImage']['Image_Location'] = "$path/$filename"; # Could be gigantic here
				$this->data['CustomImage']['display_location'] = "$path/display/$filename"; # What we'll bother showing on browser for sanity.
				$this->data['CustomImage']['thumbnail_location'] = "$path/thumbs/$filename";
	
				# XXX TODO NEED TO RECONFIGURE SO HANDLES ERRORS APPROPRAITELY
		
				# REALLY SHOULD BE FIGURED ON THE FLY, but oh well...
				# when switch over, must change these paths too...
		
				if ($this->CustomImage->save($this->data)) {
					$this->Session->setFlash(__('Your image has been saved', true));
					if ($mode == 'add')
					{
						$this->redirect(array('action'=>'index'));
					}
				} else {
					$this->Session->setFlash(__('Your image could not be saved. Please, try again.', true));
				}
			}
		}

	}

	function edit($id = null) {

		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Image', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->add_or_edit_process($id);

		# Since we don't load all fields, load again!
		$this->data = $this->CustomImage->read(null, $id);

		$this->action = 'add_or_edit';
	}

	function add($product_id = null) {
		if (!$product_id)
		{
			$this->Session->setFlash(__('Invalid Product.', true));
			$this->redirect(array('admin'=>true,'controller'=>'products','action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->ProductSampleImage->create();
			if ($this->ProductSampleImage->save($this->data)) {
				$this->Session->setFlash(__('The ProductSampleImage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ProductSampleImage could not be saved. Please, try again.', true));
			}
		}
		$products = $this->ProductSampleImage->Product->find('list');
		$this->set("product_type_id", $product_id);
		$this->set(compact('products'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ProductSampleImage', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->ProductSampleImage->save($this->data)) {
				$this->Session->setFlash(__('The ProductSampleImage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ProductSampleImage could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ProductSampleImage->read(null, $id);
		}
		$products = $this->ProductSampleImage->Product->find('list');
		$this->set(compact('products'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ProductSampleImage', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ProductSampleImage->del($id)) {
			$this->Session->setFlash(__('ProductSampleImage deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->ProductSampleImage->recursive = 0;
		$this->set('productSampleImages', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ProductSampleImage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('productSampleImage', $this->ProductSampleImage->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->ProductSampleImage->create();
			if ($this->ProductSampleImage->save($this->data)) {
				$this->Session->setFlash(__('The ProductSampleImage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ProductSampleImage could not be saved. Please, try again.', true));
			}
		}
		$products = $this->ProductSampleImage->Product->find('list');
		$this->set(compact('products'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ProductSampleImage', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->ProductSampleImage->save($this->data)) {
				$this->Session->setFlash(__('The ProductSampleImage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ProductSampleImage could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ProductSampleImage->read(null, $id);
		}
		$products = $this->ProductSampleImage->Product->find('list');
		$this->set(compact('products'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ProductSampleImage', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ProductSampleImage->del($id)) {
			$this->Session->setFlash(__('ProductSampleImage deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
