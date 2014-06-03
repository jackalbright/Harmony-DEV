<?php
class CompletedProjectsController extends AppController {

	var $name = 'CompletedProjects';
	var $components = array('Captcha.Captcha');

	function beforeFilter()
	{
		$this->Product->virtualFields = $this->Product->virtualFields2;
		return parent::beforeFilter();
	}

	function index() {
		return $this->redirect(array('action'=>'add'));

		$this->CompletedProject->recursive = 0;
		$this->set('completedProjects', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid completed image', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->CompletedProject->recursive = 1;
		$completedProject = $this->CompletedProject->read(null, $id);
		if(empty($completedProject))
		{
			$this->Session->setFlash("Could not find project");
			$this->redirect(array('action'=>'add'));
		}
		$this->set('completedProject', $completedProject);
	}

	function reset()
	{
		$this->Session->delete("completed_image_id");
		$this->redirect("/custom_images#completedart");
	}

	function send($id = null)
	{
		#$this->CompletedProject->detach("Upload"); # Don't worry about files with 'save'.
		$completed_project = $this->CompletedProject->read(null, $id);

		# Send email to admin
		if(empty($this->malysoft))
		{
			$this->sendAdminEmail("Completed Art Sent", "admin_completed_art_sent", array('completed_project'=>$completed_project));
		}
		$this->Session->delete("completed_image_id");
		$this->Session->setFlash("Thank you for your completed art. We will contact you shortly to discuss your project. <br/>You can <a href='javascript:window.print();'>print a copy of this page</a> for your records.");
		$this->set("sent", true);
		$this->set("completedProject", $completed_project);
		$this->set("product", $this->Product->read(null, $completed_project['CompletedProject']['product_type_id']));
		#error_log("ID=$id, SAVING...");
		$rc = $this->CompletedProject->saveField("sent", true);
		$hasField = $this->CompletedProject->hasField("sent");
		#error_log("HAS=$hasField, RC=$rc");
		$this->action = 'view';
	}

	function get_product($id)
	{
		$product = $this->Product->read(null, $id);
		header("Content-Type: application/json");
		echo json_encode($product['Product']);
		exit(0);
	}

	function thumb($id, $side2 = false)
	{
		# XXX TODO
		$image = $this->CompletedProject->read(null, $id);
		$abspath = 
			!empty($side2) ? 
			APP."/webroot/".$image['CompletedProject']['file2_path'].'/'.$image['CompletedProject']['file2_filename']
			: APP."/webroot/".$image['CompletedProject']['path'].'/'.$image['CompletedProject']['filename'];

		$exec = "convert $abspath -resize 250x png:-";

		header("Content-Type: image/png");
		echo shell_exec($exec);
		exit(0);
	}

	# XXX combine add and edit...

	function add()
	{
		$this->setAction("edit", func_get_args());
	}
	
	function edit($id = null) 
	{
		$prod = !empty($_REQUEST['prod']) ? $_REQUEST['prod'] : null;
		if(!empty($prod)) { $this->set("product", $this->Product->findByCode($prod)); }
		if (!empty($this->data)) {
			#error_log("SUBMIT");
			if(!empty($id))
			{
				$this->CompletedProject->id = $id;
				$this->CompletedProject->file_required(false);
			} else {
				$this->CompletedProject->create();
			}
			$this->data['CompletedProject']['session_id'] = session_id();
			if ($this->CompletedProject->saveAll($this->data)) {
				$this->Session->write("completed_image_id", $this->CompletedProject->id);
				#$this->Session->setFlash(__('The completed image has been saved', true));
				#$this->redirect(array('action' => 'index'));

				error_log("SAVING=".print_r($this->data,true));

				$id = $this->CompletedProject->id;
				$this->send($id);
				$this->redirect(array('action'=>'view',$this->CompletedProject->id));
			} else {
				$this->Session->setFlash(__('The form could not be sent. '.join(" ", $this->CompletedProject->validationErrors), true), 'warn');
				#$this->render("/custom_images/index"); # Keep form filled in
				# Can't keep form filled in without triggering this piece again! since requestAction called
				#$this->redirect("/custom_images");
			}
		} else if(!empty($id)) {
			#error_log("LOAD=$id");
			$this->data = $this->CompletedProject->read(null, $id);
		} else {
			# See if there is one pending, and load that instead...
			#error_log("LOOKING FOR PENDING @ ".session_id());
			$pending_id = $this->Session->read("completed_image_id");
			if(!empty($pending_id))
			{
				$this->data = $this->CompletedProject->read(null, $pending_id);
			}
		}
		$products = $this->Product->find('all', array('conditions'=>array('is_stock_item'=>0,'available'=>'yes',"image_type LIKE '%custom%'"),'order'=>'long_name'));
		$product_names = Set::combine($products, "{n}.Product.product_type_id", "{n}.Product.long_name");
		$products_by_id = Set::combine($products, "{n}.Product.product_type_id", "{n}.Product");
		$this->set("products", $product_names);
		$this->set("products_by_id", $products_by_id);
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for completed image', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CompletedProject->delete($id)) {
			$this->Session->setFlash(__('Completed image deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Completed image was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function admin_index() {
		$this->CompletedProject->recursive = 0;
		$this->set('completedProjects', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid completed image', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('completedProject', $this->CompletedProject->read(null, $id));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for completed image', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CompletedProject->delete($id)) {
			$this->Session->setFlash(__('Completed image deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Completed image was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
