<?php
class ProductSampleImagesController extends AppController {

	var $name = 'ProductSampleImages';
	var $title = "Product Sample Images";
	var $helpers = array('Html', 'Form');

	function generate_breadcrumbs()
	{
		$action = $this->params['action'];
		#print_r($this->params);
		$product_id = "";
		if (isset($this->data['ProductSampleImage']['product_type_id'])) {
			$product_id = $this->data['ProductSampleImage']['product_type_id'];
		} else if (isset($this->params['pass'][0]) && is_numeric($this->params['pass'][0])) {
			if ($action == 'admin_edit') {
				$product_image_id = $this->params['pass'][0];
				$image = $this->ProductSampleImage->read(null, $product_image_id);
				$product_id = $image['ProductSampleImage']['product_type_id'];
			} else {
				return; # Invalid/unknown.
				$product_id = $this->params['pass'][0];
			}
		}
		$product_name = "";
		if ($product_id)
		{
			$product = $this->Product->read(null, $product_id);
			$product_name = $product['Product']['name'];
		} else {
			$this->redirect("/admin/products");
		}

		$name = $this->name;
		if (isset($this->title)) { $name = $this->title; }

		$this->breadcrumbs = array(
			"/" . (isset($this->params['prefix']) ? $this->params['prefix'] : "") => "Home",
			"/" . (isset($this->params['prefix']) ? $this->params['prefix']."/" : "") . "products/edit/$product_id" => $product_name,
			"/" . (isset($this->params['prefix']) ? $this->params['prefix']."/" : "") . $this->params['controller'] . "/index/$product_id" => $name,
		);
	}

	function admin_index($product_id = null) {
		if (!$product_id)
		{
			$this->Session->setFlash(__('Invalid Product.', true));
			$this->redirect(array('admin'=>true,'controller'=>'products','action'=>'index'));
		}
		$this->ProductSampleImage->recursive = 0;
		$this->set('product', $this->Product->read(null, $product_id));
		$this->set("product_id", $product_id);
		$this->set('productSampleImages', $this->ProductSampleImage->findAll("ProductSampleImage.product_type_id = '$product_id'"));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ProductSampleImage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('productSampleImage', $this->ProductSampleImage->read(null, $id));
	}

	function admin_resort($product_id = null)
	{
		$this->layout = 'ajax';
		if (!$product_id)
		{
			$this->Session->setFlash(__('Invalid Product.', true));
			$this->redirect(array('admin'=>true,'controller'=>'products','action'=>'index'));
		}
		$product = $this->Product->read(null, $product_id);
		$prod = $product['Product']['prod'];
		$this->ProductSampleImage->recursive = -1;
		$order = $this->params['form']['productSampleImage_sortable'];
		##error_log("FORM=".print_r($this->params['form'],true));
		$base = APP . "/webroot/images/galleries/details/$prod";

		# Things are named productSampleImage_CODE_sortable

		foreach($this->params['form'] as $sortable => $order)
		{
			if(!preg_match("/sortable/", $sortable)) { continue; } # Not a valid sortable.

			if ($order && count($order))
			{
				$renames = array();
				foreach($order as $item_order => $image_id)
				{
					$image = $this->ProductSampleImage->find("product_image_id = '$image_id'");
					if ($image)
					{
						$index = $image['ProductSampleImage']['sort_index'];
						$ext = $image['ProductSampleImage']['file_ext'];
						$renames["$base/$index.$ext"] = "$base/$item_order.$ext";
						$image['ProductSampleImage']['sort_index'] = $item_order;
						$this->ProductSampleImage->save($image);
						# RENAME THE FILE....
					}
				}
				# Need to rename to temp files so nothing is clobbered!
				foreach($renames as $from_file => $to_file)
				{
					#error_log( "RENAMING=$from_file = $to_file");
					rename($from_file, "$to_file.tmp");
				}
				# Now rename each again.
				foreach($renames as $from_index => $to_index)
				{
					rename("$to_file.tmp", "$to_file");
				}
			}
		}
	}

	function admin_add($product_id = null) {
	
		$this->_add_or_edit_process($product_id);
		$this->action = 'admin_add_or_edit';
	}

	function _get_next_image_id($path)
	{
		$exists = true;
		$id = 0;
		#error_log("LOOKING FOR=".APP . "/webroot/$path/$id.png");
		while(file_exists(APP . "/webroot/$path/$id.jpg") || file_exists(APP . "/webroot/$path/$id.png") || file_exists(APP . "/webroot/$path/$id.gif"))
		{
			$id++;
		}
		return $id;
	}

	function _add_or_edit_process($product_id, $id = null)
	{
		if (!$product_id && !empty($this->data)) { $product_id = $this->data['ProductSampleImage']["product_type_id"]; }
		if (!$id && !empty($this->data)) { $id = $this->data['ProductSampleImage'][$this->ProductSampleImage->primaryKey]; }
		$mode = "";
		
		$path = "";
		$prefix = "";

		$image = null;

		if (!$id)
		{
			$this->body_title = "Add Your Image";
			$mode = 'add';
			$this->ProductSampleImage->create();
		} else {
			$this->body_title = "Edit Your Image";
			$mode = 'edit';
			# Look up record, make sure id matches session_id.
			$image = $this->ProductSampleImage->read(null, $id);

			if (!$product_id)
			{
				$product_id = $image['ProductSampleImage']['product_type_id'];
			}

		}
		$this->set("mode", $mode);
		#error_log("PREF=$prefix");

		if (!$product_id)
		{
			$this->Session->setFlash("No product selected");
			$this->redirect(array("controller"=>"products", "action"=>'index'));
		}

		$product = $this->Product->read(null, $product_id);
		$this->set("product_id", $product_id);
		$this->set("product", $product);
		
		$parent_id = !empty($product['Product']['parent_product_type_id']) ? $product['Product']['parent_product_type_id'] : $product_id;

		$path = "/images/galleries/products/".$product['Product']['prod']; # May want to change once logged in.

		#$filefield = "data[ProductSampleImage][file]";
		$filefield = "file";

		if (!empty($this->data))
		{
			# Get next sort_index....

			if ($this->Image->didSupplyUpload($filefield))
			{
				if($mode == 'add') { $this->data['ProductSampleImage']['sort_index'] = $this->get_next_sort_index($product_id); }
				$this->data['ProductSampleImage']['file_ext'] = $this->Image->getFileExtension($filefield);
			}
			if ($this->ProductSampleImage->save($this->data))
			{
				$prefix = $this->ProductSampleImage->id;

				#error_log("MODE=$mode");
				if ($mode == 'add' && !$this->Image->didSupplyUpload($filefield))
				{
					$this->Session->setFlash("Please choose an image to upload");
				} else {
					$return = $this->Image->saveUpload('file', $path, $prefix); # Done separately from actual db
					if ($return && is_array($return))
					{
						$this->Session->setFlash("Unable to save image: " .  join("<br/>\n", $return) );
					} else if ($filename = $return) {
						# Create sane sized image.
						# Scale image to thumbnail.
						#$display_width = 200;
						$display_height = 200;
						$thumb_height = 80;
	
						$this->Image->scaleFile("$path/$filename", "$path/display/$filename", null, $display_height,true);
						$this->Image->scaleFile("$path/$filename", "$path/thumbs/$filename", null, $thumb_height,true);

					}
				}
			} else {
				$this->Session->setFlash(__('Your image could not be saved. Please, try again.', true));
			}
			# go to parent product, if not self.
			$this->redirect(array('controller'=>'products','action'=>'edit', $parent_id,'#sample_gallery'));
		}
		$this->data['ProductSampleImage']['product_type_id'] = $product_id;

		$this->layout = 'default_plain';
		Configure::write('debug', 0);
	}

	function get_next_sort_index($product_id)
	{
		$this->ProductSampleImage->recursive = -1;
		$image = $this->ProductSampleImage->find("product_type_id = '$product_id'", array("MAX(sort_index)+1 AS next_sort_index"));
		#error_log("IM ($product_id)=".print_r($image,true));
		$next_index = 0;
		if ($image)
		{
			$next_index = $image[0]['next_sort_index'];
		}
		return $next_index;
	}

	function _add_or_edit_process_old($product_id, $id = null)
	{
		if (!$product_id && !empty($this->data)) { $product_id = $this->data['ProductSampleImage']["product_type_id"]; }
		if (!$id && !empty($this->data)) { $id = $this->data['ProductSampleImage'][$this->ProductSampleImage->primaryKey]; }
		$mode = "";
		
		$path = "";
		$prefix = "";

		$image = null;

		if (!$id)
		{
			$this->body_title = "Add Your Image";
			$mode = 'add';
			$this->ProductSampleImage->create();
		} else {
			$this->body_title = "Edit Your Image";
			$mode = 'edit';
			# Look up record, make sure id matches session_id.
			$image = $this->ProductSampleImage->read(null, $id);

			if (!$product_id)
			{
				$product_id = $image['ProductSampleImage']['product_type_id'];
			}

		}
		$this->set("mode", $mode);
		#error_log("PREF=$prefix");

		if (!$product_id)
		{
			$this->Session->setFlash("No product selected");
			$this->redirect(array("controller"=>"products", "action"=>'index'));
		}

		$product = $this->Product->read(null, $product_id);
		$this->set("product_id", $product_id);
		$this->set("product", $product);

		$path = "/images/galleries/products/".$product['Product']['prod']; # May want to change once logged in.

		if (!$id)
		{
			$prefix = $this->_get_next_image_id($path);
		} else {
			$prefix = $image['ProductSampleImage']['sort_index'];
		}



		if (!empty($this->data))
		{
			if (!$id)
			{
				$this->data['ProductSampleImage']['sort_index'] = $prefix;
			}
			$return = $this->Image->saveUpload('file', $path, $prefix); # Done separately from actual db
	
			#error_log("RETURNED ($path, $prefix) FROM SAVE=$return");
	
			if ($return && is_array($return))
			{
				$this->Session->setFlash("Unable to save image: " .  join("<br/>\n", $return) );
				#$this->render();
			} else if ($filename = $return) {
				# Create sane sized image.
				# Scale image to thumbnail.
				$display_width = 200;
				$thumb_height = 80;

				$file_ext = preg_replace("/.*[.](\w+)$/", '$1', $filename);
				if (!$file_ext) { $file_ext = 'jpg'; }
				$this->data['ProductSampleImage']['file_ext'] = $file_ext;
	
				$this->Image->scaleFile("$path/$filename", "$path/display/$filename", $display_width, null,true);
				$this->Image->scaleFile("$path/$filename", "$path/thumbs/$filename", null, $thumb_height,true);

				#error_log("SCALED FILES");
	
				if ($this->ProductSampleImage->save($this->data)) {
					$this->Session->setFlash(__('Your image has been saved', true));
					if ($mode == 'add')
					{
						$this->redirect(array('action'=>'index', $product_id));
					}
				} else {
					$this->Session->setFlash(__('Your image could not be saved. Please, try again.', true));
				}
			}
		}
		$this->data['ProductSampleImage']['product_type_id'] = $product_id;
	}

	function admin_edit($id = null) {

		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Image', true));
			$this->redirect(array('controller'=>'products','action'=>'index'));
			# Since we've lost the ID....
		}

		$this->_add_or_edit_process(null, $id);
		# Since we don't load all fields, load again!
		$this->data = $this->ProductSampleImage->read(null, $id);

		$this->action = 'admin_add_or_edit';
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


	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ProductSampleImage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('productSampleImage', $this->ProductSampleImage->read(null, $id));
	}

	function old_admin_add($product_id = null) {
		if (!$product_id) {
			$this->Session->setFlash(__('Invalid ProductSampleImage.', true));
			$this->redirect(array('controller'=>'products','action'=>'index'));
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
		#$products = $this->ProductSampleImage->Product->find('list');
		#$this->set(compact('products'));
		$this->data['ProductSampleImage']['product_type_id'] = $product_id;
	}

	function old_admin_edit($id = null) {
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
			$this->redirect(array('controller'=>'products','action'=>'index'));
		}
		$image = $this->ProductSampleImage->read(null, $id);
		$product_id = $image['ProductSampleImage']['product_type_id'];
		$product = $this->Product->read(null, $product_id);
		#error_log("ID=$product_id, DEL($id)");
		if ($this->ProductSampleImage->del($id)) {
			$this->Session->setFlash(__('ProductSampleImage deleted', true));
		}
		$parent_id = !empty($product['Product']['parent_product_type_id']) ? $product['Product']['parent_product_type_id'] : $product_id;
		$this->redirect(array('controller'=>'products','action'=>'edit',$parent_id,'#sample_gallery'));
	}

}
?>
