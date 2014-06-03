<?php
class CompletedArtImagesController extends AppController {

	var $name = 'CompletedArtImages';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->CompletedArtImage->recursive = 0;
		$this->set('completedArtImages', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CompletedArtImage', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('completedArtImage', $this->CompletedArtImage->read(null, $id));
	}

	function add($prod = '') {
		$this->layout = 'default_plain';
		if(empty($_REQUEST['debug'])) { Configure::write("debug", 0); }

		if(!empty($prod))
		{
			$product = $this->Product->find(" code = '$prod' ");
			$this->set("product", $product);
		}
		$this->set("product_types", $this->Product->find('list',array('conditions'=>"buildable = 'yes' AND available = 'yes' AND is_stock_item=0",'order'=>'name ASC')));


		if (!empty($this->data)) {
			if(!empty($this->data['preview']))
			{
				if(!$this->Image->didSupplyUpload('file'))
				{
					$this->Session->setFlash("Please specify a file to send");
				}
			}

			if ($this->Image->didSupplyUpload('file'))
			{
				$session_id = session_id();
				$path = "/images/completed_art/$session_id";
	
				$this->Image->allowed = $this->Image->all_types;
				$return = $this->Image->saveUpload('file', $path, "original"); # Done separately from actual db
				if ($return && is_array($return))
				{
					$this->Session->setFlash("Sorry, we are unable to save your image: " .  join("<br/>\n", $return) );
					return;
				}
	
				if ($filename = $return) # Now save db portion. Create thumbnails.
				{
					# Before we save to db, scale down files and convert to viewable format.
					$viewable_filename = $this->Image->viewable_filename($filename);
	
					####################
					# XXX TODO
					# We MAY change our mind  to make 'display' file full-sized....
					# Since we'd use that image for previews....
	
					# Now save smaller images.
					$thumb_height = 80;
	
					$rc = $this->Image->scaleFile("$path/$filename", "$path/display.png", 350, null, 1);
	                                if (is_array($rc)) { $this->Session->setFlash(join("<br/>", $rc)); return; }
	                                $rc = $this->Image->scaleFile("$path/$filename", "$path/thumb.png", null, 80, 1);
	                                if (is_array($rc)) { $this->Session->setFlash(join("<br/>", $rc)); return; }
	
					$this->data['CompletedArtImage']['original_path'] = "$path/$filename";
					$this->data['CompletedArtImage']['display_path'] = "$path/display.png";
					$this->data['CompletedArtImage']['thumb_path'] = "$path/thumb.png";
				}
			} 
			if(empty($this->data['preview']))
			{
				if(!empty($this->data['CompletedArtImage']['original_path']))
				{
					$this->CompletedArtImage->create();
	
					# Now save.
					if ($this->CompletedArtImage->save($this->data)) {
						#$this->Session->setFlash(__('The CompletedArtImage has been saved', true));
						$id = $this->CompletedArtImage->id;
	
					if(!$this->malysoft)
					{
						$this->sendAdminEmail("Completed Art Submitted", "forms/completed_art_image", array('id'=>$id));
					}
	
						$this->action = "add_thankyou";
					} else {
						$this->Session->setFlash(__('Your completed art could not be saved. Please, try again.', true));
					}

				} else { 
					$this->Session->setFlash("Please specify a file to send");
				}
			}
		}
		if(!empty($product)) { 
			$this->data['CompletedArtImage']['product_id'] = $pid = $product['Product']['product_type_id']; 
			$ppid = $product['Product']['parent_product_type_id']; 
			$products = $this->Product->find('all',array('conditions'=>" (product_type_id = '$pid' OR parent_product_type_id = '$pid' OR product_type_id = '$ppid' OR parent_product_type_id = '$ppid') AND available = 'yes'",'order'=>'choose_index ASC'));
			$related_products = array();
			foreach($products as $p)
			{
				$name = strip_tags($p['Product']['pricing_name']);
				$id = $p['Product']['product_type_id'];
				$desc = $p['Product']['pricing_description'];
				if(!empty($desc)) { $name = "$name $desc"; }
				$related_products[$id] = $name;
			}
			$this->set("related_products", $related_products);
		}

	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CompletedArtImage', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->CompletedArtImage->save($this->data)) {
				$this->Session->setFlash(__('The CompletedArtImage has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The CompletedArtImage could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CompletedArtImage->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CompletedArtImage', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->CompletedArtImage->del($id)) {
			$this->Session->setFlash(__('CompletedArtImage deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The CompletedArtImage could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}


	function admin_index() {
		$this->CompletedArtImage->recursive = 0;
		$this->set('completedArtImages', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CompletedArtImage', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('completedArtImage', $this->CompletedArtImage->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->CompletedArtImage->create();
			if ($this->CompletedArtImage->save($this->data)) {
				$this->Session->setFlash(__('The CompletedArtImage has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The CompletedArtImage could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CompletedArtImage', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->CompletedArtImage->save($this->data)) {
				$this->Session->setFlash(__('The CompletedArtImage has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The CompletedArtImage could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CompletedArtImage->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CompletedArtImage', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->CompletedArtImage->del($id)) {
			$this->Session->setFlash(__('CompletedArtImage deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The CompletedArtImage could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>
