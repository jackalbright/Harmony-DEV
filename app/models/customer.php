<?php
class Customer extends AppModel {

	var $name = 'Customer';
	var $useTable = 'customer';
	var $primaryKey = 'customer_id';

	#var $validate = array(
		#'Password'=>array(
			#'rule'=>'notEmpty',
		#	'##required'=>true,
		#),
		#'Password2'=>array(
		#	'rule'=>'notEmpty',
		#	'required'=>true,
		#),
	#);
	var $hasMany = array(
		'Purchase'=>array('className'=>'Purchase','foreignKey'=>'Customer_ID','dependent'=>false),
		'CreditCards' => array('className' => 'CreditCard', 'foreignKey' => 'Customer_ID'),
	);

	var $belongsTo = array(
			'PreferredShippingAddress' => array('className' => 'ContactInfo', # One for each max quantity...
								'foreignKey' => 'shipping_id_pref',
								'dependent' => false,
			),
			'PreferredBillingAddress' => array('className' => 'ContactInfo', # One for each max quantity...
								'foreignKey' => 'billing_id_pref',
								'dependent' => false,
			),
	);

	#function validateLogin($data)
	#{
	#	$customer = $this->find(array('eMail_Address' => $data['eMail_Address'], 'Password' => md5($data['Password'])), array('customer_id', 'eMail_Address'));
	#        if(empty($customer) == false)
	#		return $customer['Customer'];
	#	return false; 
	#}

	function verify_name($data)
	{
		$firstname = $data['Customer']['First_Name'];
		$lastname = $data['Customer']['Last_Name'];
		if (strlen($firstname) <= 0 || strlen($lastname) <= 0)
		{
			$this->errors[] = 'Must enter in your complete first and last names.';
			return false;
		}
		return true;
	}

	function verify_password($data, $required = true)
	{
		$password = $data['Customer']['Password'];
		$password2 = $data['Customer']['Password2'];

		if (!$required && $password2 == "" && $password == "") { return true; }
		else if ($password2 == "" || strlen($password2) == 0)
		{
			$this->errors[] = 'Password verification required. Please enter your password again.';
			return false;
		}
		else if (strlen($password2) < 6)
		{
			$this->errors[] = 'Password too short. Must be 6 or more characters.';
			return false;
		}
		else if ($password != $password2) 
		{
			$this->errors[] = "Passwords do not match.";
			return false;
		}

		return true;
	}

	function other_valid_existing_customer_id($data)
	# If they checked out as a guest before and using that address again.
	{
		$session_id = session_id();
		$email = $data['Customer']['eMail_Address'];
		$customer_id = !empty($data['Customer']['customer_id']) ? $data['Customer']['customer_id'] : "";
		$customer = $this->find("eMail_Address = '$email' AND Customer.customer_id != '$customer_id' AND guest = 1 AND session_id = '$session_id' ");
		if(!empty($customer['Customer']['customer_id']))
		{
			return $customer['Customer']['customer_id'];
		} else {
			return null;
		}
	}

	function verify_email($data)
	{
		$email = $data['Customer']['eMail_Address'];
		$customer_id = !empty($data['Customer']['customer_id']) ? $data['Customer']['customer_id'] : "";
		#echo "EM=$email";
		$session_id = session_id();

		if (!preg_match("/^.+@.+[.].+$/", $email)) 
		{
			$this->errors[] = "Invalid email.";
			return false;
		}
		# Allow for email duplicates if others are guest and session different.
		else if ($this->hasAny("eMail_Address = '$email' AND customer_id != '$customer_id' AND (guest = 1 AND session_id != '$session_id')"))
		{
			return true;
		}
		else if ($this->hasAny("eMail_Address = '$email' AND customer_id != '$customer_id' AND (guest = 0 OR session_id != '$session_id')"))
		# Verify email not already signed up.... existing guest with same session_id OK
		{
			#error_log("EXISTING EMAIL");
			##exit(0);
			$this->errors[] = 'Email already in use. Choose another or <a href="/account/forgot">retrieve your password</a>.';
			# Hopefully this will display on THIS page, and not require a redirect.
			return false;
		}

		return true;
	}

	function verify_phone($data)
	{
		$phone = $data['Customer']['Phone'];

		if (!$phone)
		{
			$this->errors[] = "Invalid phone number.";
			return false;
		}
		return true;
	}

	function hashPasswords($data)
	# No encrypting of passwords, since plain text in db.
	{
		return $data;
	}

	function generate_password() # A new random one.
	{
		return $this->generate_code(8);
	}

	function generate_code($length = 8) # Random codes, whether password, registration code, etc...
	{
		$chars = array();
		for ($i = ord('a'); $i < ord('z'); $i++)
		{
			$chars[] = chr($i);
		}
		for ($i = ord('A'); $i < ord('Z'); $i++)
		{
			$chars[] = chr($i);
		}
		for ($i = ord('0'); $i < ord('9'); $i++)
		{
			$chars[] = chr($i);
		}

		shuffle($chars); # randomize.

		$code = "";
		for ($ix = 0; $ix < $length; $ix++)
		{
			$code .= $chars[ rand(0, count($chars)-1) ];
		}

		return $code;
	}

	function beforeSave()
	{
		# Sanitize
		if(!empty($this->data['Customer']['eMail_Address']))
		{
			$this->data['Customer']['eMail_Address'] = trim($this->data['Customer']['eMail_Address']);
		}
		return true;
	}

	#function save($data)
	#{
	#	# Move images over whenever modify account....
	#	$custom_image = ClassRegistry::init("CustomImage");
	#	$customer_id = $this->id;
	#	if (!$customer_id) { $customer_id = $data['Customer']['customer_id']; }
	#	$session_id = session_id();
	#	$custom_image->moveAnonymousImages($session_id, $customer_id);
#
#		return parent::save($data);
#	}
}
?>
