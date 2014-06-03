<?
class ValidationBehavior extends ModelBehavior
{
	function beforeValidate(&$model, $options = array())
	{
		if($options['validate'] === 'first')
		{
			return true;
		}
		error_log("BEFORE VALID");

		$model->validate['captcha_response'] = array(
			'checkCaptcha'=>array(
				'required'=>'create',
				'allowEmpty'=>false,
				'rule'=>array('checkCaptcha'),
				'message'=>'Security characters do not match picture. Please try again.',
			)
		);

	}

	function beforeSave(&$model)
	{
		error_log("SHITTY=".print_r($model->data,true));
		if(empty($model->id) && empty($model->data[$model->alias]['captcha_response']))
		{
			$model->validationErrors['captcha_response'] = 'Missing CAPTCHA validation';
			return false;
		}
		return true;
	}

	function checkCaptcha(&$model, $data)
	{
		$sessionCode = !empty($_SESSION['Captcha']['code']) ?
			$_SESSION['Captcha']['code'] : null;

		if(empty($sessionCode)) { return false; }

		#error_log("CAPTCHA MATCH, $sessionCode == {$data['captcha_response']}");
		return ($sessionCode == $data['captcha_response']);
	}
}
