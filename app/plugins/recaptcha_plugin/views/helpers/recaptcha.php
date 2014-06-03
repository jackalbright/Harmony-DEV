<?php
class RecaptchaHelper extends Helper {
	public $helpers = array('Form');

	function show($options = array()) {
		if (isset($options['theme'])) {
			if (!in_array($options['theme'], array('red', 'white', 'blackglass', 'clean'))) {
				$options['theme'] = 'red';
			}
		}
		App::import('Vendor', 'RecaptchaPlugin.recaptchalib');
		Configure::load('RecaptchaPlugin.key');
		#error_log("RC=".print_r(Configure::read('Recaptcha'),true));
		$publickey = Configure::read('Recaptcha.Public');
		$html = '<script type="text/javascript">var RecaptchaOptions = ';
		$html .= json_encode($options);
		$html .= ';</script>';

		if (isset($recaptcha_error)) {
			$html .= $recaptcha_error . '';
		}
		return $html .= recaptcha_get_html($publickey, null, true);
	}

	function error() {
		return $this->Form->error('recaptcha_response_field');
	}
}
