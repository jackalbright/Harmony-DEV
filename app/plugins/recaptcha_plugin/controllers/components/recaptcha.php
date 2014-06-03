<?php
class RecaptchaComponent extends Object {
	function startup(&$controller) {
		if (isset($controller->params['form']['recaptcha_challenge_field']) && isset($controller->params['form']['recaptcha_response_field'])) {
			$modelClass = $controller->modelClass;
			$controller->data[$modelClass]['recaptcha_challenge_field'] = $controller->params['form']['recaptcha_challenge_field'];
			$controller->data[$modelClass]['recaptcha_response_field'] = $controller->params['form']['recaptcha_response_field'];
			$controller->$modelClass->Behaviors->attach('RecaptchaPlugin.Validation');
		}
	}
}
