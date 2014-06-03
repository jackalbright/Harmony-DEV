<?php
class ValidationBehavior extends ModelBehavior {
	function beforeValidate(&$model, $options = array()) {
		if($options['validate'] === 'first')
		{
			return true; 
		}
		#error_log("BEFORE_VALIDATE=".print_r($options,true));

		#error_log("PARMS=".print_r(func_get_args(),true));
		$bt = debug_backtrace();
		for($i = 0; $i < 10; $i++)
		{
			#error_log("      {$bt[$i]['function']}, {$bt[$i]['line']}, {$bt[$i]['file']} ");
		}
		#error_log("VALID {$model->alias}");
		$model->validate['recaptcha_response_field'] = array(
			'checkRecaptcha' => array(
				'rule' => array('checkRecaptcha', 'recaptcha_challenge_field'),
				'required' => true,
				'allowEmpty'=>false,
				'message' => 'You did not enter the words correctly. Please try again.',
			),
		);
	}

	function beforeSave(&$model)
	{
		if(empty($model->id) && empty($model->data[$model->alias]['recaptcha_response_field'])) # Addin w/o captcha
		{
			$model->validationErrors['recaptcha_response_field'] = 'Missing CAPTCHA validation'; # Won't show, but oh well.
			return false;
		}
		return true;
	}

	function checkRecaptcha(&$model, $data, $target) {
		App::import('Vendor', 'RecaptchaPlugin.recaptchalib');
		Configure::load('RecaptchaPlugin.key');
		$privatekey = Configure::read('Recaptcha.Private');
		$res = recaptcha_check_answer(
			$privatekey, 							$_SERVER['REMOTE_ADDR'],
			$model->data[$model->alias][$target], 	$data['recaptcha_response_field']
		);
		error_log("SENDING TO {$model->alias} ($privatekey) {$model->data[$model->alias][$target]}, {$data['recaptcha_response_field']}, RES=".print_r($res,true));
		return $res->is_valid;
	}
}
