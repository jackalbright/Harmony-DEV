<?
App::import("Vendor", "authnetcim", array('file'=>'authorizenet.cim.class.php'));

class CimComponent extends Object
{
	var $controller = null;

	var $mode = 'test'; # test,live,testlive (set below automatically based on site)
	var $login = null;
	var $password = null;
	var $cim = null;
	var $error = null;
	var $debug = array();
	var $duplicate_window = 1; # minutes.
	var $expired = false;

	function startup(&$controller)
	{
		$this->controller = $controller;
		$this->modelClass = $controller->modelClass;

		$is_admin = $this->controller->Session->read("Auth.Customer.is_admin");

		$this->mode = (preg_match("/harmonydesigns.com/", $_SERVER['HTTP_HOST']) && empty($is_admin) ? "live" : "testlive");
		# Admins always work with test system.

		if(preg_match("/malysoft/", $_SERVER['HTTP_HOST'])) { $this->mode = 'test'; }

		Configure::load("authorize_net");
		$mode = ($this->mode == 'test' ? "test":"live"); # allow testlive to be considered as live.

	#	error_log("MODE=$mode, ADMIN=$is_admin");

		$this->login = Configure::read("AuthorizeNet.{$mode}.login");
		$this->password = Configure::read("AuthorizeNet.{$mode}.password");
	}

	function connect()
	{
		if(empty($this->cim))
		{
			$this->debug[] = "CONNECT {$this->login}, {$this->password}";
			$this->cim = new AuthNetCim($this->login, $this->password, ($this->mode == 'test'));
			# Check to make sure it's available.
			preg_match("@https://([^/]+)@", $this->cim->url, $matches);
			$hostname = $matches[1];
			$ip = gethostbyname($hostname);
			if($ip == '0.0.0.0' || $ip == '127.0.0.1' || $ip == $hostname)
			{
				$this->error = "Unable to resolve $hostname for billing. Maybe network devices needs to be reloaded.";
				return false;
			}
		}
		return true;
	}

	# Need to store profile_id, payment_id in own system.
	# if either of those are missing, redirect to form.

	function create_profile($cust_id, $email, $description)
	{ # {email, id}, { }
		$this->debug[] = "CREATE PROFILE";
			# XXX store in local system? (later) - all this can be under one record. easy retrieval
			if(!$this->connect()) { return null; }
	
			$this->cim->setParameter('merchantCustomerId', $cust_id);
			$this->cim->setParameter('refId', $cust_id);
			$this->cim->setParameter('email', $email);
			if(empty($description)) { $description = $email; } 
			$this->cim->setParameter('description', $description);
	
			$this->cim->createCustomerProfileRequest();
			if($this->cim->isSuccessful())
			{
				$profile_id = (string) $this->cim->customerProfileId;
			#	error_log("PROFILE=$profile_id");
				$this->controller->log("AUTH.NET create profile=$profile_id");
				return $profile_id;
			} else if (preg_match("/duplicate record with ID (\d+) already exists/", $this->cim->text, $matches)) {
				$this->cim->success = true;
				$this->cim->text = $this->cim->error_messages = null;
				$profile_id = $matches[1]; # Already there, re-use.
				$this->controller->log("AUTH.NET existing profile=$profile_id");
				return $profile_id;
			}
			$this->error = !empty($this->cim->text) ? $this->cim->text : join(". ", $this->cim->error_messages);
			return null;
	}

	function get_profile($profile_id) # By profile id
	{
		$this->debug[] = "GET PROFILE $profile_id";
			# XXX store in local system? (later) - all this can be under one record. easy retrieval
			if(!$this->connect()) { return null; }
	
			$this->cim->setParameter('customerProfileId', $profile_id);
	
			$this->cim->getCustomerProfileRequest();
			if($this->cim->isSuccessful())
			{
				#print_r($this->cim);
				$profile = $this->getResponseData('profile');
				$this->debug[] = "PROFILE=".print_r($profile,true);
				return !empty($profile[0]) ? $profile[0] : $profile;
			}
			$this->error = join(". ", $this->cim->error_messages);
			return null;
	}

	function getResponseData($key = '')
	{
		$response = str_replace('xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd"', '', $this->cim->response);
		$xml = new SimpleXMLElement($response);
		$data = $key && $xml ? $xml->xpath($key) : $xml;
		if(is_array($data) && count($data) == 1) { return $data[0]; } else { return $data; } # Data just one item, we probably don't want a list.
	}

	function debug()
	{
		return $this->debug_request().$this->debug_response();
	}

	function debug_request()
	{
		return "<div class='bold'>Request</div><textarea style='width: 100%;' rows=8>".$this->cim->xml."</textarea>";
	}

	function debug_response()
	{
		return "<div class='bold'>Response</div><textarea style='width: 100%;' rows=8>".$this->cim->response."</textarea>";
	}

	function create_payment_profile($profile_id, $card, $exp, $billing = null)
	{ 
		$this->debug[] = "CREATING PAYMENT PROFILE... $profile_id, $card, $exp";
			# billing (optl): first_name, last_name, address, city, state, zip, country, phone_number, fax_number
			# credit_card, expiration (YYYY-MM)
	
			# XXX store in local system? (later) - all this can be under one record. easy retrieval
			if(!$this->connect()) { return null; }
	
			$this->cim->setParameter('paymentType', 'creditCard');
			$this->cim->setParameter('customerProfileId', $profile_id);
			$this->cim->setParameter('cardNumber', $card);
			$this->cim->setParameter('expirationDate', date('Y-m', strtotime($exp)));
			#$mode = ($this->mode == 'test' ? "test":"live"); 
			$mode = ($this->mode == 'live' ? "live" : "test");
		#	error_log("ADDING CARD, validation MODE=$mode");
			$this->cim->setParameter('validationMode', "{$mode}Mode");

			error_log("CREATE_PAY, VALIDMODE=$mode");
	
			if(!empty($billing)) # take in underscore_version, send as camelCase
			{
				foreach($billing as $k=>$v)
				{
					$pk = "billTo_".Inflector::variable($k);
					$this->cim->setParameter($pk, $v);
				}
			}

			$this->cim->error_messages = array(); # Clear
			$this->cim->text = null;
	
			$this->cim->createCustomerPaymentProfileRequest();
	
			if($this->cim->isSuccessful())
			{
				$this->controller->log("AUTH.NET pay profile=".$this->cim->customerPaymentProfileId);
				return $this->cim->customerPaymentProfileId;
			}
			$this->error = !empty($this->cim->text) ? $this->cim->text : join(". ", $this->cim->error_messages);
			$this->controller->log("AUTH.NET get payment profile FAIL={$this->error}");
			return null;
	}

	function raw()
	{
		if(!$this->controller->Session->read("Auth.Customer.is_admin")) { return; } # Dont debug unless site admin.

		return 
			"<h4>Request</h4><textarea style='width: 100%;' rows=8>".$this->cim->xml."</textarea>" .
			"<h4>Response</h4><textarea style='width: 100%;' rows=8>".$this->cim->response."</textarea>";
	}

	function update_payment_profile($profile_id, $payment_id, $card, $exp, $billing = null)
	{ 
	#	error_log("UPDATEPAY= $profile_id, $payment_id; C=$card, EX=$exp, B=".print_r($billing,true));
		$this->debug[] = "UPDATING PAYMENT PROFILE... $profile_id, $card, $exp";
			# billing (optl): first_name, last_name, address, city, state, zip, country, phone_number, fax_number
			# credit_card, expiration (YYYY-MM)
	
			# XXX store in local system? (later) - all this can be under one record. easy retrieval
			if(!$this->connect()) { return null; }
	
			$this->cim->setParameter('customerProfileId', $profile_id);
			$this->cim->setParameter('customerPaymentProfileId', $payment_id);
			$this->cim->setParameter('paymentType', 'creditCard'); # NEED!
			$this->cim->setParameter('cardNumber', $card);
			$this->cim->setParameter('expirationDate', date('Y-m', strtotime($exp)));
	
			if(!empty($billing)) # take in underscore_version, send as camelCase
			{
				foreach($billing as $k=>$v)
				{
					$pk = "billTo_".Inflector::variable($k);
					$this->cim->setParameter($pk, $v);
				}
			}
	
			$this->cim->updateCustomerPaymentProfileRequest();
	
			if($this->cim->isSuccessful())
			{
				return true; # Doesnt get pay_id back...
			}
			$this->error = join(". ", $this->cim->error_messages);
			$this->controller->log("AUTH.NET update payment profile FAIL={$this->error}");
			return null;
	}

	function delete_payment_profile($profile_id, $payment_id)
	{ 
		$this->debug[] = "DELETE PAYMENT PROFILE... $profile_id, $payment_id";
			if(!$this->connect()) { return null; }
	
			$this->cim->setParameter('customerProfileId', $profile_id);
			$this->cim->setParameter('customerPaymentProfileId', $payment_id);
	
			$this->cim->deleteCustomerPaymentProfileRequest();
	
			if($this->cim->isSuccessful())
			{
				$this->cim->error_messages = array(); # Clear
				$this->cim->text = null;
				return true;
			}
			$this->error = join(". ", $this->cim->error_messages);
			return null;
	}

	function valid_profile($profile_id)
	{
		if(empty($profile_id)) { return null; }

			if(!$this->connect()) { return null; }
	
			$this->cim->setParameter('customerProfileId', $profile_id);
	
			$this->cim->getCustomerProfileRequest();
			$this->cim->error_messages = array(); # Clear, in case not found.
			$this->cim->text = null;
			if($this->cim->isSuccessful())
			{
				#print_r($this->cim);
				$profile_id = (string) $this->getResponseData('profile/customerProfileId');
				#error_log("VALID PAZYMENT? =".print_r($profile_id,true));
				return $profile_id;
			}
			return null;
	}

	function valid_payment_profile($profile_id, $payment_profile_id)
	{
		if(empty($profile_id)) { return null; }
		if(empty($payment_profile_id)) { return null; }

			if(!$this->connect()) { return null; }
	
			$this->cim->setParameter('customerProfileId', $profile_id);
			$this->cim->setParameter('customerPaymentProfileId', $payment_profile_id);
	
			$this->cim->getCustomerPaymentProfileRequest();
			$this->cim->error_messages = array(); # Clear, in case not found.
			$this->cim->text = null;
			if($this->cim->isSuccessful())
			{
				#print_r($this->cim);
			#	error_log("VALID_PAYTMENT=".$this->cim->response);
				$payment_profile_id = (string) $this->getResponseData('paymentProfile/customerPaymentProfileId');
				$this->debug[] = "VALID PAZYMENT? =$payment_profile_id";
				return $payment_profile_id;
			}
			return null;
	}

	function get_payment_profile($profile_id, $payment_profile_id)
	{
		if(empty($profile_id)) { return null; }
		if(empty($payment_profile_id)) { return null; }

			if(!$this->connect()) { return null; }
	
			$this->cim->setParameter('customerProfileId', $profile_id);
			$this->cim->setParameter('customerPaymentProfileId', $payment_profile_id);
	
			$this->cim->getCustomerPaymentProfileRequest();
			$this->cim->error_messages = array(); # Clear, in case not found.
			$this->cim->text = null;
			if($this->cim->isSuccessful())
			{
				#print_r($this->cim);
				$payment_profile = $this->getResponseData('paymentProfile');
				return $payment_profile;
			}
			return null;
	}

	function create_shipping_address() { } # TODO someday, maybe

	function charge($profileId, $paymentId, $amount, $description, $refId = null, $desc = null)
	{
		$this->controller->log("AUTH.NET CIM CHARGING profile_id=$profileId, payment_id=$paymentId, amount=$amount, desc=$description, refId=$refId");

			if(!$this->connect()) { return null; }
	
			$this->cim->setParameter('transaction_amount', $amount);
			$this->cim->setParameter('transactionType', "profileTransAuthCapture");
			$this->cim->setParameter('refId', $refId);
			$this->cim->setParameter('customerProfileId', $profileId);
			$this->cim->setParameter('customerPaymentProfileId', $paymentId);
			$this->cim->setParameter('order_invoiceNumber', $refId);
			$this->cim->setParameter('order_description', $desc);
			#error_log("SETTING INVNUM=$refId");
		#	error_log("PROFID=$profileId, PAYID=$paymentId"); # Not creating?


			$test_request = ($this->mode == 'testlive')?1:0;
		#	error_log("CHECKING TEST MODE, SHOULD NOT ALLOW BOGUS CARD NUMBER, TEST_REQ=$test_request, MODE={$this->mode}");

			$this->cim->setParameter("extraOptions", "x_duplicate_window={$this->duplicate_window}&x_test_request=$test_request");
			#$this->cim->setParameter("extraOptions", "x_duplicate_window={$this->duplicate_window}");#&x_test_request=$test_request");
			# 
			# Todo shipping info.
	
			$this->cim->createCustomerProfileTransactionRequest();

			$this->expired = false; # Clear.

			# Fake an error.
			if(false)
			{
			$this->error = $this->debug();
			return null;
			}
			
	
			if($this->cim->isSuccessful())
			{
				$trans = (string) $this->getResponseData("directResponse");
				# Check if approved, declined, or error...
				$this->debug[] = "CHARGE: ".print_r($trans,true);

				$this->controller->log("AUTH.NET CIM TRANSACTION RESPONSE=".print_r($trans,true));

				if($trans[0] == 3 && $trans[2] == 11) # Duplicate. Pretend ok. (BUT SHUT OFF!)
				{
					$this->controller->log("AUTH.NET - TRANSACTION ALREADY SENT (OK)");
					return true; # SKIP!
				} else if($trans[0] > 1) {
					if($trans[2] == '8' || $trans[2] == '7')
					{
						$this->controller->log("AUTH.NET - CARD IS EXPIRED");
						$this->expired = true;
					}
					$this->controller->log("FAIL AUTH.NET CIM ERROR={$this->error}");
					$this->error = $trans[4];
					return null;
				}
				#echo 'T='.print_r($trans,true);
			#	error_log("CHARGED=".print_r($trans,true));

				$this->controller->log("AUTH.NET SUCCESS=".$trans[3]);
				
				return $trans[50]; # Last 4 digits of card.
			}
			$this->error = !empty($this->cim->error_messages) ? join(". ", $this->cim->error_messages) : $this->cim->text;
			$this->controller->log("FAIL AUTH.NET CIM ERROR={$this->error}");

			return null;
	}
}
