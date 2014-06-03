<?
class WholesaleController extends AppController
{
	var $uses = array('WholesaleAccountRequest','Customer');

	function index()
	{
		
	}

	function add_account()
	{
		$this->layout = 'default_plain';
		if(!empty($this->data))
		{
			$this->Customer->create();
			# When we send them an email to enable, we set the password there. until then, no password = no logging in.
			$this->data['Customer']['Password'] = null;
			$this->data['Customer']['is_wholesale'] = 1;
			$this->data['Customer']['pricing_level'] = 100;

			if($this->Customer->save($this->data))
			{
				$customer = $this->Customer->read();
				$this->sendAdminEmail("Wholesale Account Signup", "wholesale_signup", array('customer'=>$customer));
				$this->action = "add_account_thanks";
			} else {
				$this->Session->setFlash("Could not submit request");
			}
		}
	}
}

?>
