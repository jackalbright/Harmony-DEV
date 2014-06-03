<?php
class SavedItemsController extends AppController {

	var $name = 'SavedItems';
	var $helpers = array('Html', 'Form');

	function beforeFilter()
	{
		$this->Auth->allow('*');
		$this->Auth->deny('index','add','delete');
		#$this->Auth->allow();#("add","index"); # For account users only.
		parent::beforeFilter();
	}

	function index() {
		$customer_id = $this->get_customer_id();
		$this->body_title = "My Account &mdash; Saved Designs";
		$this->SavedItem->recursive = 0;
		$savedItems = $this->SavedItem->findAll("SavedItem.customer_id = '$customer_id'",null,"saved_item_id DESC");
		foreach($savedItems as &$item)
		{
			$build_data = unserialize($item['SavedItem']['build_data']);
			$code = !empty($build_data['Design']['productCode']) ? $build_data['Design']['productCode'] : $build_data['code'];
			$product = $this->Product->find(" code = '$code' ");
			$name = $product['Product']['name'];
			if(!empty($build_data['catalog_number']))
			{
				$gallery_image = $this->GalleryImage->find(" GalleryImage.catalog_number = '{$build_data['catalog_number']}' ");
				if(!empty($gallery_image['GalleryImage']['stamp_name']))
				{
					$name = '"'.$gallery_image['GalleryImage']['stamp_name'].'"' . " $name";
				} else {
					$name = "Custom $name";
				}
			} else if (!empty($build_data['image_id'])) {
				$custom_image = $this->CustomImage->find(" Image_ID = '{$build_data['image_id']}' ");
				if(!empty($custom_image['CustomImage']['Title']))
				{
					$name = '"'.$custom_image['CustomImage']['Title'].'"' . " $name";
				} else {
					$name = "Custom $name";
				}

			}
			$item['name'] = $name;
		}
		$this->set("savedItems", $savedItems);
	}

	function view($id = null) {
		# Restore and go to build???

		if (!$id) {
			$this->Session->setFlash(__('Invalid saved item.', true));
			$this->redirect(array('action'=>'index'));
		}

		$saved_item = $this->SavedItem->read(null, $id);
		if(!empty($saved_item['SavedItem']['new_build']))
		{
			$this->redirect("/designs/saved_edit/$id"); # New build takes over.
		}

		$build_data = unserialize($saved_item['SavedItem']['build_data']);

		$this->build = $build_data;
	#	error_log("BUILD_DATA=".print_r($this->build,true));
		$code = $build_data['code'];
		$product = $this->Product->find(" code = '$code' ");
		$this->build['Product'] = $product['Product'];
		if(!empty($build_data['catalog_number']))
		{
			$catnum = $build_data['catalog_number'];
			$gallery_image = $this->GalleryImage->find("GalleryImage.catalog_number = '$catnum'");
			$this->build["GalleryImage"] = $gallery_image['GalleryImage'];
		}
		if(!empty($build_data['image_id']))
		{
			$image_id = $build_data['image_id'];
			$custom_image = $this->CustomImage->find("Image_ID = '$image_id'");
			$this->build["CustomImage"] = $custom_image['CustomImage'];
		}
		$this->Session->write("Build", $this->build);

		$this->redirect("/build/customize");
	}

	function add() { # really should just do a total snapshot.....
		$this->data['SavedItem']['customer_id'] = $this->get_customer_id();

		$build_data = array();
		$build_data['code'] = $this->build['Product']['code'];
		$build_data['catalog_number'] = !empty($this->build['GalleryImage']) ? $this->build['GalleryImage']['catalog_number'] : null;
		$build_data['image_id'] = !empty($this->build['CustomImage']) ? $this->build['CustomImage']['Image_ID'] : null;
		$build_data['options'] = $this->build['options'];
		$build_data['quantity'] = $this->build['quantity'];
		if(!empty($this->build['quantity_size']))
		{
			$build_data['quantity_size'] = $this->build['quantity_size'];
		}
		$build_data['template'] = $this->build['template'];
		$build_data['rotate'] = $this->build['rotate'];
		$build_data['crop'] = $this->build['crop'];

		$this->data['SavedItem']['build_data'] = serialize($build_data);

		if (!empty($this->data)) {

			$this->SavedItem->create();
			if ($this->SavedItem->save($this->data)) {
				$things = strtolower(Inflector::pluralize($this->build['Product']['name']));
				$this->Session->setFlash("Your design has been saved for later. You'll be able to retrieve your saved items by going to your <a href='/account'>My Account</a> page.");
				$this->Session->write("Build.saved", true);
				#if(!empty($goto))
				#{
				#	$this->Session->delete("savegoto");
				#	$this->redirect($goto);
				##}
				#$this->redirect(array('action'=>'index'));
				$vars = array('savedItem'=>$this->SavedItem->read());
				$this->sendAdminEmail("A design has been saved", "admin_saved_item", $vars);

				$this->redirect("/build");
			} else {
				$this->Session->setFlash(__('The SavedItem could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid SavedItem', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->SavedItem->save($this->data)) {
				$this->Session->setFlash(__('The SavedItem has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The SavedItem could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->SavedItem->read(null, $id);
		}
	}

	function delete($id = null) {
		$customer_id = $this->get_customer_id();
		if (!$id || !$this->SavedItem->findCount(" SavedItem.saved_item_id = '$id' AND SavedItem.customer_id = '$customer_id'")) {
			#$this->Session->setFlash(__('Invalid item', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->SavedItem->del($id)) {
			$this->Session->setFlash(__('Item removed', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->SavedItem->recursive = 1;
		$savedItems = $this->paginate();

		foreach($savedItems as &$item)
		{
			$build_data = unserialize($item['SavedItem']['build_data']);
			$code = !empty($build_data['Design']['productCode']) ? $build_data['Design']['productCode'] : $build_data['code'];
			$product = $this->Product->find(" code = '$code' ");
			$name = $product['Product']['name'];
			if(!empty($build_data['catalog_number']))
			{
				$gallery_image = $this->GalleryImage->find(" GalleryImage.catalog_number = '{$build_data['catalog_number']}' ");
				if(!empty($gallery_image['GalleryImage']['stamp_name']))
				{
					$name = '"'.$gallery_image['GalleryImage']['stamp_name'].'"' . " $name";
				} else {
					$name = "Custom $name";
				}
			} else if (!empty($build_data['image_id'])) {
				$custom_image = $this->CustomImage->find(" Image_ID = '{$build_data['image_id']}' ");
				if(!empty($custom_image['CustomImage']['Title']))
				{
					$name = '"'.$custom_image['CustomImage']['Title'].'"' . " $name";
				} else {
					$name = "Custom $name";
				}

			}
			$item['name'] = $name;
		}
		$this->set("savedItems", $savedItems);
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid SavedItem.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('savedItem', $this->SavedItem->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->SavedItem->create();
			if ($this->SavedItem->save($this->data)) {
				$this->Session->setFlash(__('The SavedItem has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The SavedItem could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid SavedItem', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->SavedItem->save($this->data)) {
				$this->Session->setFlash(__('The SavedItem has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The SavedItem could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->SavedItem->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for SavedItem', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->SavedItem->del($id)) {
			$this->Session->setFlash(__('SavedItem deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
