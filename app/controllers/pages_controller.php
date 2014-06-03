<?php
/* SVN FILE: $Id: pages_controller.php 7118 2008-06-04 20:49:29Z gwoo $ */
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package			cake
 * @subpackage		cake.cake.libs.controller
 * @since			CakePHP(tm) v 0.2.9
 * @version			$Revision: 7118 $
 * @modifiedby		$LastChangedBy: gwoo $
 * @lastmodified	$Date: 2008-06-04 13:49:29 -0700 (Wed, 04 Jun 2008) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package		cake
 * @subpackage	cake.cake.libs.controller
 */
class PagesController extends AppController {
/**
 * Controller name
 *
 * @var string
 * @access public
 */
	var $name = 'Pages';
/**
 * Default helper
 *
 * @var array
 * @access public
 */
	var $helpers = array('Html','Javascript','Ajax');
/**
 * This controller does not use a model
 *
 * @var array
 * @access public
 */
	var $uses = array('StaticPage');
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @access public
 */
	function display() { # File on disk...
		$path = func_get_args();

		if (!count($path)) {
			$this->redirect('/');
		}
		$count = count($path);
		$page = $subpage = $title = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title'));
		$this->render(join('/', $path));
	}

	function view($path)
	{
		$page = $this->StaticPage->find(" path = '$path' OR static_page_id = '$path' ");

		if (!empty($page['StaticPage']['page_title'])) { $this->page_title = $page['StaticPage']['page_title']; }
		if (!empty($page['StaticPage']['body_title'])) { $this->body_title = $page['StaticPage']['body_title']; }

		if (!empty($page['StaticPage']['meta_keywords'])) { $this->meta_keywords = $page['StaticPage']['meta_keywords']; }
		if (!empty($page['StaticPage']['meta_desc'])) { $this->meta_description = $page['StaticPage']['meta_desc']; }

		$this->set("page", $page);
	}

	function admin_index() {
		$this->StaticPage->recursive = 0;
		$this->set('staticPages', $this->paginate());
	}

	function admin_view($path = null) {

		$page = $this->StaticPage->find(" path = '$path' OR static_page_id = '$path' ");

		if (!empty($page['StaticPage']['page_title'])) { $this->page_title = $page['StaticPage']['page_title']; }
		if (!empty($page['StaticPage']['body_title'])) { $this->body_title = $page['StaticPage']['body_title']; }

		if (!empty($page['StaticPage']['meta_keywords'])) { $this->meta_keywords = $page['StaticPage']['meta_keywords']; }
		if (!empty($page['StaticPage']['meta_desc'])) { $this->meta_description = $page['StaticPage']['meta_desc']; }

		$this->set("page", $page);
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->StaticPage->create();
			if ($this->StaticPage->save($this->data)) {
				$this->Session->setFlash(__('The StaticPage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The StaticPage could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid StaticPage', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->StaticPage->save($this->data)) {
				$this->Session->setFlash(__('The StaticPage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The StaticPage could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->StaticPage->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for StaticPage', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->StaticPage->del($id)) {
			$this->Session->setFlash(__('StaticPage deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
}

?>
