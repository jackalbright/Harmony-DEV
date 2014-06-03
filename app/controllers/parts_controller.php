<?php
class PartsController extends AppController {

	var $name = 'Parts';
	var $helpers = array('Html', 'Form');
	var $uses = array('Part','Ribbon','Tassel','Charm','Border');
	var $paginate = array(
		'limit'=>50
	);

	function index() {
		$this->Part->recursive = 0;
		$this->set('parts', $this->paginate());
	}

	function view($partcode)
	{
		Configure::write("debug", 0);
		$this->layout = "default_plain";

		if ($partcode == 'ribbon')
		{
			$this->Ribbon->recursive = 0;
			$this->set("ribbons", $this->Ribbon->findAll("available = 'yes'", null, "color_name"));
		} else if ($partcode == 'charm') {
			$this->Charm->recursive = 0;
			$this->set("charms", $this->Charm->findAll("available = 'yes'", null, "name"));
		} else if ($partcode == 'tassel') {
			$this->Tassel->recursive = 0;
			$this->set("tassels", $this->Tassel->findAll("available = 'yes'", null, "color_name"));
		} else if ($partcode == 'border') {
			$this->Border->recursive = 0;
			$this->set("borders", $this->Border->findAll("available = 'yes'", null, "name"));
		}
		$this->set("part", $this->Part->find("part_code = '$partcode'"));
		$this->set("partcode", $partcode);
	}

	function view_old($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Part.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('part', $this->Part->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Part->create();
			if ($this->Part->save($this->data)) {
				$this->Session->setFlash(__('The Part has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Part could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Part', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Part->save($this->data)) {
				$this->Session->setFlash(__('The Part has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Part could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Part->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Part', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Part->del($id)) {
			$this->Session->setFlash(__('Part deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		Configure::write('debug', 1);
		$this->Part->recursive = 0;
		$this->set('parts', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Part.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('part', $this->Part->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Part->create();
			if ($this->Part->save($this->data)) {
				$this->Session->setFlash(__('The Part has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Part could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Part', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Part->save($this->data)) {
				$this->Session->setFlash(__('The Part has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Part could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Part->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Part', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Part->del($id)) {
			$this->Session->setFlash(__('Part deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
