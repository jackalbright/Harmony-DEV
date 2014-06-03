<?
class CaptchaComponent extends Object
{
	function startup(&$controller)
	{
		if(!in_array("Captcha.Captcha", $controller->helpers)) { $controller->helpers[] = "Captcha.Captcha"; }

		# always require captcha, could be deleted from bot hack
		#if(isset($controller->data[$controller->modelClass]['captcha_response']))#&& $this->Session->read("Captcha.code"))
		#{
			$controller->{$controller->modelClass}->Behaviors->attach("Captcha.Validation");
		#}
	}
}
