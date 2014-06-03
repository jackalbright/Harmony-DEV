<?php
class SpecialtyPageProspectsController extends AppController {

	var $name = 'SpecialtyPageProspects';
	var $components = array('Captcha.Captcha');
	var $helpers = array('Html', 'Form');
	var $paginate = array('order'=>'specialty_page_prospects_id DESC');
	var $title = 'Specialty Inquiries';

	function beforeFilter()
	{
		parent::beforeFilter();
		if(Configure::read("wholesale_site"))
		{
			$this->Auth->allow('add');
		}
	}

	function add($type = 'wholesale') {
		$this->layout = 'ajax';
		#$this->body_title = 'Wholesale Accounts';
		$testData = print_r($this->data,true); // jack test
		if($this->data['PurchaseOrder'].length < 1){
			unset($this->data['PurchaseOrder']);
		}
		if (!empty($this->data)) {
			$this->SpecialtyPageProspect->create();
			if ($this->SpecialtyPageProspect->saveAll($this->data)) {
				$prospect = $this->SpecialtyPageProspect->read();
				//if(!empty($this->malysoft))
				//{
					//$this->sendEmail("t_maly@comcast.net", "Specialty Page Inquiry", "specialty_page_submission", array('prospect'=>$prospect));
				//} else if(empty($this->malysoft))
				//{
					$type = $prospect['SpecialtyPageProspect']['type'];
					if(empty($type)) { $type = 'Wholesale'; }
					$this->sendAdminEmail("$type Inquiry", "specialty_page_submission", array('prospect'=>$prospect));
				//}
				# Send out notification email

				#$this->Session->setFlash(__('The SpecialtyPageProspect has been saved', true));
				#$this->redirect(array('action'=>'index'));
				if(!empty($this->params['isAjax']))
				{
					$this->Session->setFlash("Your information has been sent. Thank you for your inquiry.");
					$this->data = null;
				} else {
					$this->action = 'add_thanks';
				}
			} else {
				$this->Session->setFlash(__("The form could not be sent. Please, try again. ", true),'warn');
			}
		}
		$this->set("products", $this->Product->find('list', array('order'=>'pricing_name','fields'=>array('product_type_id','pricing_name'), 'conditions'=>array('available'=>'yes','NOT'=>array("code IN ('TA','CH')")))));
		$this->set("sample_products", $this->Product->find('list', array('order'=>'pricing_name','fields'=>array('product_type_id','pricing_name'), 'conditions'=>array('available'=>'yes','is_stock_item'=>0))));
		#$this->set(compact('specialtyPages'));
		$this->set("type", $type);
		
	}

	function admin_index() {
		$value = $this->data['value'];
		#Configure::write("debug",2);
		$conditions = array();
		if (isset($this->data))
		{
			if ($this->data['field'] == 'name') { 
				$conditions = array('name LIKE'=>"%$value%");;
			} else if ($this->data['field'] == 'email') { 
				$conditions = array('email LIKE'=>"%$value%");
			} else if ($this->data['field'] == 'company') { 
				$conditions = array('organization LIKE'=>"%$value%");;
			}else if ($this->data['field'] == 'zipcode') { 
				$conditions = array('zipcode LIKE'=>"%$value%");;
			}else if ($this->data['field'] == 'state') { 
				$conditions = array('state LIKE'=>"%$value%");;
			}
			//$this->Customer->recursive = 0;
			//$customers = $this->paginate('specialty_page_prospects',$conditions);
			//$this->Paginator->settings = array('conditions' => $conditions);
		}
		$this->SpecialtyPageProspect->recursive = 1;
		$this->paginate['order'] = 'specialty_page_prospects_id DESC';
		/*$this->paginate['conditions'] =array( 
                'email LIKE' => "%beachrunalpacas@gmail.com%" 
        );*/ 
		
		$this->set('testVariable', $conditions);
		$this->paginate['conditions'] = $conditions;
		if($conditions.length > 0){
			$this->set('specialtyPageProspects', $this->paginate());
		}else{
			$this->set('specialtyPageProspects', $this->paginate());
		}
		//$this->set('specialtyPageProspects', $this->paginate());
		
	}
	
	function admin_search(){
		$value = $this->data['value'];
		#Configure::write("debug",2);

		if (isset($this->data))
		{
			if ($this->data['field'] == 'name') { 
				$conditions = array('name LIKE'=>"%$value%");;
			} else if ($this->data['field'] == 'email') { 
				$conditions = array('email LIKE'=>"%$value%");
			} else if ($this->data['field'] == 'company') { 
				$conditions = array('organization LIKE'=>"%$value%");;
			}
			//$this->Customer->recursive = 0;
			//$customers = $this->paginate('specialty_page_prospects',$conditions);
			$this->Paginator->settings = array('conditions' => $conditions);
		}
		$this->paginate['conditions'] = array( 
                'name' => "%albright%" 
        ); 
		$this->SpecialtyPageProspect->recursive = 1;
		$this->set('specialtyPageProspects', $this->paginate() );
		$this->redirect(array('action'=>'admin_index')); # Use same template...
	}
	
	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid SpecialtyPageProspect.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('specialtyPageProspect', $this->SpecialtyPageProspect->read(null, $id));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for SpecialtyPageProspect', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->SpecialtyPageProspect->del($id)) {
			$this->Session->setFlash(__('SpecialtyPageProspect deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
