<?php
class TestimonialsController extends AppController {

	var $name = 'Testimonials';
	var $helpers = array('Html', 'Form');
	var $paginate = array(
		'order'=>'sort_index, testimonial_id',
	);

	function index() {
		$this->Testimonial->recursive = 0;
		$this->set('testimonials', $this->Testimonial->findAll(" approved = 1",null,"sort_index,testimonial_id"));
	}


	function admin_resort()
	{
		$this->Testimonial->recursive = -2;
		if (!empty($this->params['form']))
		{
			#error_log("DATA=".print_r($this->params['form'],true));
			#$id_csv = join(", ", array_values($this->params['form']['testimonials']);
			#$testimonials = $this->Testimonial->findAll(" testimonial_id IN ($id_csv) ");

			foreach($this->params['form']['testimonials'] as $order => $id)
			{
				$testimonial = $this->Testimonial->find(" testimonial_id = '$id' ");
				$testimonial['Testimonial']['sort_index'] = $order;
				#error_log("TEST=".print_r($testimonial,true));
				$this->Testimonial->save($testimonial);
			}
		}
	}

	function OLD_admin_resort($testimonial_id, $direction = -1)
	{
		$testimonials = $this->Testimonials->findAll();
		$sorted_testimonials = array();

		for($i = 0; $i < count($testimonials); $i++)
		{
			$testimonial = $testimonials[$i];
			if($testimonial['Testimonial']['testimonial_id'] == $testimonial_id)
			{
				$other_ix = $i + $direction;
				if ($other_ix >= 0 && $other_ix < count($testimonials)) # CAN move...
				{
					#$other_testimonial = $testimonials[$
				}
				#$other_testimonial = $
				if ($direction == -1)
				{
				} 
				else if ($direction == 1)
				{
					
				}
			}
		}

		# re-index.
		for($i = 0; $i < count($testimonials); $i++)
		{
			$testimonials[$i]['Testimonial']['sort_index'] = $i;
			$this->Testimonials->save($testimonials[$i]);
		}

		$this->redirect(array('action'=>'index'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Testimonial.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('testimonial', $this->Testimonial->read(null, $id));
	}

	# ADD PAGE FOR VIEWING PAST COMMENTS????

	# Add new controller for general feedback? ie survey, etc


	function add() {
		$customer = $this->get_customer();
		if (empty($customer))
		{
			$this->Session->setFlash("Please login or signup to leave comments.");
			$this->redirect("/testimonials/add?login=1");
		}

		if (!empty($this->data)) {
			$this->Testimonial->create();
			$this->data['Testimonial']['customer_id'] = $customer['customer_id'];
			if ($this->Testimonial->save($this->data)) {
				$this->Session->setFlash(__('Thank you for your comments.',true));
				$this->redirect(array('controller'=>'account','action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Testimonial could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Testimonial', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Testimonial->save($this->data)) {
				$this->Session->setFlash(__('The Testimonial has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Testimonial could not be saved. Please, try again.', true));
			}
		}


		if (empty($this->data)) {
			$this->data = $this->Testimonial->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Testimonial', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Testimonial->del($id)) {
			$this->Session->setFlash(__('Testimonial deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->Testimonial->recursive = 1;
		#$this->set('testimonials', $this->paginate());
		$this->set('testimonials', $this->Testimonial->findAll("approved = 1",null,"sort_index,testimonial_id"));
	}

	function admin_unapproved()
	{
		$this->Testimonial->recursive = 1;
		$this->set('testimonials', $this->Testimonial->findAll(" approved = 0",null,"sort_index,testimonial_id"));
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Testimonial.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('testimonial', $this->Testimonial->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Testimonial->create();
			if ($this->Testimonial->save($this->data)) {
				$this->Session->setFlash(__('The Testimonial has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Testimonial could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Testimonial', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Testimonial->save($this->data)) {
				$this->Session->setFlash(__('The Testimonial has been saved', true));
				#$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Testimonial could not be saved. Please, try again.', true));
			}
		}

		$this->Product->recursive = -2;
		$this->SpecialtyPage->recursive = -2;
		$this->CustomerType->recursive = -2;
		$this->set("customer_types", $this->Testimonial->CustomerType->find('list',array('fields'=>array('name'),'order'=>'name')));
		$this->set("products", $this->Testimonial->Products->find('list',array('conditions'=>'parent_product_type_id IS NULL', 'order'=>'name')));
		$this->set("specialtyPages", $this->Testimonial->SpecialtyPages->find('list',array('fields'=>array('body_title'), 'order'=>'body_title, page_url')));
		#echo 'PROD='.print_r($this->viewVars['products']);

		if (empty($this->data)) {
			$this->data = $this->Testimonial->read(null, $id);
		}
	}

	function admin_product_sort($product_id = null)
	{
		$this->layout = 'ajax';
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Product', true));
		} else {
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Testimonial', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Testimonial->del($id)) {
			$this->Session->setFlash(__('Testimonial deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
