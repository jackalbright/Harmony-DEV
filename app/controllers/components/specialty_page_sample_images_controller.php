<?php
class SpecialtyPageSampleImagesController extends AppController {

	var $name = 'SpecialtyPageSampleImages';
	var $title = "Specialty Page Sample Images";
	var $helpers = array('Html', 'Form');
	var $uses = array('SpecialtyPageSampleImage','SpecialtyPage','Product');

	function generate_breadcrumbs()
	{
		$action = $this->params['action'];
		#print_r($this->params);
		$specialty_page_id = "";
		if (isset($this->data['SpecialtyPageSampleImage']['specialty_page_id'])) {
			$specialty_page_id = $this->data['SpecialtyPageSampleImage']['specialty_page_id'];
		} else if (isset($this->params['pass'][0]) && is_numeric($this->params['pass'][0])) {
			if ($action == 'admin_edit') {
				$specialty_page_image_id = $this->params['pass'][0];
				$image = $this->SpecialtyPageSampleImage->read(null, $specialty_page_image_id);
				$specialty_page_id = $image['SpecialtyPageSampleImage']['specialty_page_id'];
			} else {
				$specialty_page_id = $this->params['pass'][0];
			}
		}
		$specialtyPage_name = "";
		if ($specialty_page_id)
		{
			$specialtyPage = $this->SpecialtyPage->read(null, $specialty_page_id);
			$specialtyPage_name = $specialtyPage['SpecialtyPage']['body_title'];
		} else {
			$this->redirect("/admin/specialty_pages");
		}

		$name = $this->name;
		if (isset($this->title)) { $name = $this->title; }

		$this->breadcrumbs = array(
			"/" . (isset($this->params['prefix']) ? $this->params['prefix'] : "") => "Home",
			"/" . (isset($this->params['prefix']) ? $this->params['prefix']."/" : "") . "specialty_pages/edit/$specialty_page_id" => $specialtyPage_name,
			"/" . (isset($this->params['prefix']) ? $this->params['prefix']."/" : "") . $this->params['controller'] . "/index/$specialty_page_id" => $name,
		);
	}

	function admin_index($specialty_page_id = null) {
		if (!$specialty_page_id)
		{
			$this->Session->setFlash(__('Invalid SpecialtyPage.', true));
			$this->redirect(array('admin'=>true,'controller'=>'specialty_pages','action'=>'index'));
		}
		$this->SpecialtyPageSampleImage->recursive = 0;
		$this->set('specialtyPage', $this->SpecialtyPage->read(null, $specialty_page_id));
		$this->set("specialty_page_id", $specialty_page_id);
		$this->set('specialtyPageSampleImages', $this->SpecialtyPageSampleImage->findAll("SpecialtyPageSampleImage.specialty_page_id = '$specialty_page_id'"));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid SpecialtyPageSampleImage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('specialtyPageSampleImage', $this->SpecialtyPageSampleImage->read(null, $id));
	}

	function admin_resort($specialty_page_id = null)
	{
		$this->layout = 'ajax';
		if (!$specialty_page_id)
		{
			$this->Session->setFlash(__('Invalid SpecialtyPage.', true));
			$this->redirect(array('admin'=>true,'controller'=>'specialty_pages','action'=>'index'));
		}
		$product = $this->SpecialtyPage->read(null, $specialty_page_id);
		$page_url = $product['SpecialtyPage']['page_url'];
		$this->SpecialtyPageSampleImage->recursive = -1;
		$order = $this->params['form']['specialtyPageSampleImage_sortable'];
		#error_log("FORM=".print_r($this->params['form'],true));
		$base = APP . "/webroot/images/galleries/specialties/$page_url";

		if ($order && count($order))
		{
			$renames = array();
			foreach($order as $item_order => $image_id)
			{
				$image = $this->SpecialtyPageSampleImage->find("product_image_id = '$image_id'");
				if ($image)
				{
					$index = $image['SpecialtyPageSampleImage']['sort_index'];
					$ext = $image['SpecialtyPageSampleImage']['file_ext'];
					$renames["$base/$index.$ext"] = "$base/$item_order.$ext";
					$image['SpecialtyPageSampleImage']['sort_index'] = $item_order;
					$this->SpecialtyPageSampleImage->save($image);
					# RENAME THE FILE....
				}
			}
			# Need to rename to temp files so nothing is clobbered!
			foreach($renames as $from_file => $to_file)
			{
				error_log( "RENAMING=$from_file = $to_file");
				rename($from_file, "$to_file.tmp");
			}
			# Now rename each again.
			foreach($renames as $from_index => $to_index)
			{
				rename("$to_file.tmp", "$to_file");
			}
		}
	}

	function admin_add($specialty_page_id = null) {
	
		$this->_add_or_edit_process($specialty_page_id);
		$this->action = 'admin_add_or_edit';
	}

	function _get_next_image_id($path)
	{
		$exists = true;
		$id = 0;
		error_log("LOOKING FOR=".APP . "/webroot/$path/$id.png");
		while(file_exists(APP . "/webroot/$path/$id.jpg") || file_exists(APP . "/webroot/$path/$id.png") || file_exists(APP . "/webroot/$path/$id.gif"))
		{
			$id++;
		}
		return $id;
	}

	function _add_or_edit_process($specialty_page_id, $id = null)
	{
		if (!$specialty_page_id && !empty($this->data)) { $specialty_page_id = $this->data['SpecialtyPageSampleImage']["specialty_page_id"]; }
		if (!$id && !empty($this->data)) { $id = $this->data['SpecialtyPageSampleImage'][$this->SpecialtyPageSampleImage->primaryKey]; }
		$mode = "";
		
		$path = "";
		$prefix = "";

		$image = null;

		if (!$id)
		{
			$this->body_title = "Add Your Image";
			$mode = 'add';
			$this->SpecialtyPageSampleImage->create();
		} else {
			$this->body_title = "Edit Your Image";
			$mode = 'edit';
			# Look up record, make sure id matches session_id.
			$image = $this->SpecialtyPageSampleImage->read(null, $id);

			if (!$specialty_page_id)
			{
				$specialty_page_id = $image['SpecialtyPageSampleImage']['specialty_page_id'];
			}

		}
		$this->set("mode", $mode);
		error_log("PREF=$prefix");
		error_log("SPID=$specialty_page_id");

		if (!$specialty_page_id)
		{
			$this->Session->setFlash("No specialty page selected");
			$this->redirect(array("controller"=>"specialty_pages", "action"=>'index'));
		}

		$specialtyPage = $this->SpecialtyPage->read(null, $specialty_page_id);
		$this->set("specialty_page_id", $specialty_page_id);
		$this->set("specialtyPage", $specialtyPage);

		$path = "/images/galleries/specialties/".$specialtyPage['SpecialtyPage']['page_url']; # May want to change once logged in.

		#$filefield = "data[ProductSampleImage][file]";
		$filefield = "file";

		if (!empty($this->data))
		{
			if ($this->Image->didSupplyUpload($filefield))
			{
				if($mode == 'add') { $this->data['SpecialtyPageSampleImage']['sort_index'] = $this->get_next_sort_index($specialty_page_id); }
				$this->data['SpecialtyPageSampleImage']['file_ext'] = $this->Image->getFileExtension($filefield);
			}
			if ($this->SpecialtyPageSampleImage->save($this->data))
			{
				$prefix = $this->SpecialtyPageSampleImage->id;

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
						$display_width = 200;
						$thumb_height = 80;

						$this->data['ProductSampleImage']['sort_index'] = $this->get_next_sort_index($specialty_page_id);
						$this->data['ProductSampleImage']['file_ext'] = $this->Image->getFileExtension($filefield);
	
		
						$this->Image->scaleFile("$path/$filename", "$path/display/$filename", $display_width, null);
						$this->Image->scaleFile("$path/$filename", "$path/thumbs/$filename", null, $thumb_height);
	
						if ($mode == 'add')
						{
							$this->redirect(array('action'=>'index', $specialty_page_id));
						}
					}
				}
			} else {
				$this->Session->setFlash(__('Your image could not be saved. Please, try again.', true));
			}
		}
		$this->data['SpecialtyPageSampleImage']['specialty_page_id'] = $specialty_page_id;
		#$this->set("products", $this->Product->find('list',array('order'=>'name')));
		#$this->set("products", $this->Product->find('list',array('fields'=>array('name'), 'order'=>'name')));
		$this->set("products", $this->Product->create_dropdown_list('name', 'None'));
	}

	function get_next_sort_index($specialty_page_id)
	{
		$this->SpecialtyPageSampleImage->recursive = -1;
		$image = $this->SpecialtyPageSampleImage->find("specialty_page_id = '$specialty_page_id'", array("MAX(sort_index)+1 AS next_sort_index"));
		error_log("IM ($specialty_page_id)=".print_r($image,true));
		$next_index = 0;
		if ($image)
		{
			$next_index = $image[0]['next_sort_index'];
		}
		return $next_index;
	}

	function admin_edit($id = null) {

		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Image', true));
			$this->redirect(array('controller'=>'specialty_pages','action'=>'index'));
			# Since we've lost the ID....
		}

		$this->_add_or_edit_process(null, $id);
		# Since we don't load all fields, load again!
		$this->data = $this->SpecialtyPageSampleImage->read(null, $id);

		$this->action = 'admin_add_or_edit';
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid SpecialtyPageSampleImage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('specialtyPageSampleImage', $this->SpecialtyPageSampleImage->read(null, $id));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for SpecialtyPageSampleImage', true));
			$this->redirect(array('controller'=>'specialty_pages','action'=>'index'));
		}
		$image = $this->SpecialtyPageSampleImage->read(null, $id);
		$specialty_page_id = $image['SpecialtyPageSampleImage']['specialty_page_id'];
		error_log("ID=$specialty_page_id, DEL($id)");
		if ($this->SpecialtyPageSampleImage->del($id)) {
			$this->Session->setFlash(__('SpecialtyPageSampleImage deleted', true));
		}
		$this->redirect(array('action'=>'index',$specialty_page_id));
	}

}
?>
