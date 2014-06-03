<?php
class CustomersController extends AppController {

	var $name = 'Customers';
	var $helpers = array('Html', 'Form');
	var $components = array('Upload');
	var $uses = array('Customer','CustomImage');


	function beforeFilter()
	{
		#$this->Auth->allow('forgot','signup','index'); # Anonymous pages....
		parent::beforeFilter();
	}

	function index() {
		$this->body_title = "My Account";
		#$this->Customer->recursive = 0;
		#$this->set('customers', $this->paginate());
		$this->set("customer", $this->get_customer());
	}


	function signup() {
		exit(1);
		if (!empty($this->data)) {
			$this->Customer->create();
			if ($this->Customer->save($this->data)) {
				$this->Session->setFlash(__('The Customer has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Customer could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		exit(1);
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Customer', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Customer->save($this->data)) {
				$this->Session->setFlash(__('The Customer has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Customer could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Customer->read(null, $id);
		}
	}

	function delete($id = null) {
		exit(1);
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Customer', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Customer->del($id)) {
			$this->Session->setFlash(__('Customer deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function admin_import()
	{
		if(!empty($this->data))
		{
			#print_r($this->data);
			if(!empty($this->data['Customer']['file']['size']))
			{
				$fileobj = $this->data['Customer']['file'];
				$csv = file_get_contents($fileobj['tmp_name']);
				$lines = preg_split("/[\r|\n]/", $csv);
				$header = split("\t", array_shift($lines));

				$customers = array();

				foreach($lines as $line)
				{
					$data = array();
					$values = split("\t", $line); 
					if(empty($values[0])) { continue; } # Skip line if 1st col blank.
					for($i = 0; $i < count($header); $i++)
					{
						$data[$header[$i]] = $values[$i];
					}
					$customers[] = $data;
				}
				$this->set("customers", $customers);
			} else if(!empty($this->data['MYOBCustomer'])) { # Parse records...
				foreach($this->data['MYOBCustomer'] as $c => $customer)
				{
					if(!empty($customer['ignore'])) { continue; } # Skip!

					$billing = $this->data['BillingAddress'][$c];
					$shipping = $this->data['ShippingAddress'][$c];

					#$customer = array('Customer'=>$customer);
					$customer['is_wholesale'] = 1;
					$customer['pricing_level'] = 100;
					$customer['dateAdded'] = date('Y-m-d');
					$email = $customer['eMail_Address'];

					$recid = $customer['myob_record_id'];
					$existing = $this->Customer->find(" myob_record_id = '$recid' ". (!empty($email)? "OR eMail_Address = '$email'" :"") );
					if(empty($existing))
					{
						$this->Customer->create();
					} else {
						$this->Customer->id = $existing['Customer']['customer_id'];
					}

					#echo "SAVING=".print_r($customer,true);

					$this->Customer->save(array('Customer'=>$customer)); # Always update, override existing.
					$customer_id = $this->Customer->id;
					$billing['Customer_ID'] = $customer_id; # Link to customer.
					$shipping['Customer_ID'] = $customer_id; # Link to customer.

					# Save billing/shipping.
					# Check if they have existing addresses.
					$existing_addresses = $this->ContactInfo->find(" ContactInfo.Customer_ID = '$customer_id' ");
					$billing_found = $shipping_found = false;
					foreach($existing_addresses as $address)
					{

						# There's NO way to update the address thru this and still know it's the same one w/o an ID.
						# But at least we can NOT duplicate.
						# Any changes will force a duplicate entry.
						if( $address['ContactInfo']['Address1'] == $billing['Address1'] && $address['ContactInfo']['Zip_Code'] == $billing['Zip_Code'] )
						# Assume same.
						{
							$billing_found = true;
							$billing_id = $address['ContactInfo']['Contact_ID'];
						}

						if( $address['ContactInfo']['Address1'] == $shipping['Address1'] && $address['ContactInfo']['Zip_Code'] == $shipping['Zip_Code'] )
						# Assume same.
						{
							$shipping_found = true;
							$shipping_id = $address['ContactInfo']['Contact_ID'];
						}

					}
					if(empty($billing_found))
					{
						$this->ContactInfo->save(array('ContactInfo'=>$billing));
						$billing_id = $this->ContactInfo->id;
					}
					$this->Customer->saveField("billing_id_pref", $billing_id);

					if($billing != $shipping && empty($shipping_found))
					{
						$this->ContactInfo->save(array('ContactInfo'=>$shipping));
						$shipping_id = $this->ContactInfo->id;
					}
					$this->Customer->saveField("shipping_id_pref", $shipping_id);

					#break; # Only do one for now.
				}
				$this->Session->setFlash("Wholesale accounts created.");
				$this->redirect("/admin/customers/index/myob");
			}
		}
	}


	function admin_index($type = '') {
		$this->paginate['order'] = "Customer.customer_id DESC";
		$this->paginate['limit'] = 50;
		$this->Customer->recursive = 0;
		$cond = "";
		if($type == 'myob')
		{
			$cond = "myob_record_id != '' AND ";
		}
		else if ($type == 'wholesale') {
			$cond = "is_wholesale = 1 AND";
		}
		$this->set('customers', $this->paginate("Customer", "$cond eMail_Address != '' "));
		$this->set('incomplete_customers', $this->Customer->findAll("$cond eMail_Address = '' "));
		$this->set("customer_type", $type);
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Customer.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('customer', $this->Customer->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Customer->create();
			$this->data['Customer']['dateAdded'] = date('Y-m-d');
			# Don't duplicate.
			$email = $this->data['Customer']['eMail_Address'];
			if($existing = $this->Customer->find("eMail_Address = '$email'"))
			{
				$this->Session->setFlash("Account seems to already exist. Try <a href='/admin/account/edit/{$existing['Customer']['customer_id']}'>modifying the other account</a>");
				return;
			}

			if ($this->Customer->save($this->data)) {
				$this->Session->setFlash(__('The Customer has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Customer could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Customer', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Customer->save($this->data)) {
				$this->Session->setFlash(__('The Customer has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Customer could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Customer->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Customer', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Customer->del($id)) {
			$this->Session->setFlash(__('Customer deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
