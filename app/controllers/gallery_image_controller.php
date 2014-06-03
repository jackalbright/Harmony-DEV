<?php
class GalleryImageController extends AppController {

	var $name = 'GalleryImage';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->GalleryImage->recursive = 0;
		$this->set('galleryImages', $this->paginate());
	}

	function view($id = null) {
		$cn = preg_replace("/[.]gif$/", "", $id);
		$stamp = $this->GalleryImage->find("GalleryImage.catalog_number = '$cn'");
		if(!empty($_REQUEST['debug']))
		{
			header("Content-Type: text/plain");
		} else {
			header("Content-Type: image/gif");
		}

		$path = APP."/../".$stamp['GalleryImage']['image_location'];

		$img = imagecreatefromgif($path);

		# Add border.
		$w = imagesx($img);
		$h = imagesy($img);

		$border = 10;

		$outimg = imagecreatetruecolor($w+$border*2, $h+$border*2);
		imagefilledrectangle($outimg, 0, 0, $w+$border*2, $h+$border*2, 0x000000);

		imagecopyresampled($outimg, $img, $border,$border, 0,0,$w,$h,$w,$h);

		# Print.
		imagegif($outimg);

		exit(0);
		
	}

	function add() {
		if (!empty($this->data)) {
			$this->GalleryImage->create();
			if ($this->GalleryImage->save($this->data)) {
				$this->Session->setFlash(__('The GalleryImage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The GalleryImage could not be saved. Please, try again.', true));
			}
		}
		$galleryCategories = $this->GalleryImage->GalleryCategory->find('list');
		$this->set(compact('galleryCategories'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid GalleryImage', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->GalleryImage->save($this->data)) {
				$this->Session->setFlash(__('The GalleryImage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The GalleryImage could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->GalleryImage->read(null, $id);
		}
		$galleryCategories = $this->GalleryImage->GalleryCategory->find('list');
		$this->set(compact('galleryCategories'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for GalleryImage', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->GalleryImage->del($id)) {
			$this->Session->setFlash(__('GalleryImage deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->GalleryImage->recursive = 0;
		$this->set('galleryImages', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid GalleryImage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('galleryImage', $this->GalleryImage->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->GalleryImage->create();
			if ($this->GalleryImage->save($this->data)) {
				$this->Session->setFlash(__('The GalleryImage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The GalleryImage could not be saved. Please, try again.', true));
			}
		}
		$galleryCategories = $this->GalleryImage->GalleryCategory->find('list');
		$this->set(compact('galleryCategories'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid GalleryImage', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->GalleryImage->save($this->data)) {
				$this->Session->setFlash(__('The GalleryImage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The GalleryImage could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->GalleryImage->read(null, $id);
		}
		$galleryCategories = $this->GalleryImage->GalleryCategory->find('list');
		$this->set(compact('galleryCategories'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for GalleryImage', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->GalleryImage->del($id)) {
			$this->Session->setFlash(__('GalleryImage deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
