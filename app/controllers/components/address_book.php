<?

class AddressBookComponent extends Object
{
	var $components = array('Session');
	function startup(&$controller)
	{
		$this->controller = &$controller;
		$this->data = & $controller->data;
	}

	function save_address()
	{
		$customer_id = $this->Session->read("Auth.Customer.customer_id");
		$customer = $this->Session->read("Auth.Customer");
		if(!empty($this->data['ContactInfo']))
		{
			$contact_id = $this->data['ContactInfo']['Contact_ID'];
			#if (!$contact_id || !$this->controller->ContactInfo->findCount("Contact_ID = '$contact_id' AND Customer_ID = '$customer_id'"))
			#{
			#	unset($this->data['ContactInfo']['Contact_ID']);
			#	$this->controller->ContactInfo->create();
			#}
			$this->data['ContactInfo']['Customer_ID'] = $customer_id;

			if (empty($this->data['ContactInfo']['In_Care_Of']) && empty($this->data['ContactInfo']['Name']))
			{
				$this->Session->setFlash("Missing name on address");
				return;
			} else if (!$this->data['ContactInfo']['Address_1']) {
				$this->Session->setFlash("Missing street for address");
				return;
			} else if (!$this->data['ContactInfo']['City']) {
				$this->Session->setFlash("Missing city for address");
				return;
			} else if (!$this->data['ContactInfo']['Zip_Code']) {
				$this->Session->setFlash("Missing zip code for address");
				return;
			}

			$this->controller->ContactInfo->save($this->data);
			$contact_id = $this->controller->ContactInfo->id;

			if(empty($customer['Company']) && !empty($this->data['ContactInfo']['Company']))
			{
				$this->controller->Customer->saveField('Company', $this->data['ContactInfo']['Company']);
			}

		}
		return $contact_id;
	}
}

?>
