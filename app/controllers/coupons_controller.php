<?php
class CouponsController extends AppController {

	var $name = 'Coupons';

	function admin_index() {
		$this->Coupon->recursive = 0;
		$this->set('coupons', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid coupon', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('coupon', $this->Coupon->read(null, $id));
	}

	function admin_add() {
		return $this->setAction("admin_edit");
	}

	function admin_edit($id = null) {
		if (!empty($this->data)) {
			if ($this->Coupon->save($this->data)) {
				$this->Session->setFlash(__('The coupon has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The coupon could not be saved. Please, try again.', true));
			}
		}
		if ($id) {
			$this->data = $this->Coupon->read(null, $id);
		}
		$this->set("days_of_week", $this->Coupon->getEnumValues('day_of_week'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for coupon', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Coupon->delete($id)) {
			$this->Session->setFlash(__('Coupon deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Coupon was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
