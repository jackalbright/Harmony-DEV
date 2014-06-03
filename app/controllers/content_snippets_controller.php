<?php
class ContentSnippetsController extends AppController {

	var $name = 'ContentSnippets';
	var $helpers = array('Html', 'Form');

	# Allow for inline edit and inline view.

	# For now, just for plain text, not rich....

	function admin_inline_edit($key = null)
	{
		if(!empty($this->data))
		{
			error_log("D=".print_r($this->data,true));
			$this->ContentSnippet->save($this->data);
			# Save 

			return $this->setAction("admin_inline_view", $key);
		}
		$this->set("code", $key);
		$this->data = $this->ContentSnippet->findBySnippetCode($key);
	}


	function admin_inline_view($key)
	{
		$snippet = $this->ContentSnippet->findBySnippetCode($key);
		Configure::write('debug',0);
		$this->set("snippet", $snippet);
	}

	function admin_index() {
		$this->ContentSnippet->recursive = 0;
		$this->set('contentSnippets', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ContentSnippet.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('contentSnippet', $this->ContentSnippet->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->ContentSnippet->create();
			if ($this->ContentSnippet->save($this->data)) {
				$this->Session->setFlash(__('The ContentSnippet has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ContentSnippet could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ContentSnippet', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->ContentSnippet->save($this->data)) {
				$this->Session->setFlash(__('The ContentSnippet has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ContentSnippet could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ContentSnippet->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ContentSnippet', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ContentSnippet->del($id)) {
			$this->Session->setFlash(__('ContentSnippet deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
