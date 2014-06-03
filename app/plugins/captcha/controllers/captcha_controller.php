<?php

class CaptchaController extends CaptchaAppController
{
	var $uses = array();

	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('*');
	}

	function image() # Display image from generated version... using GD
	{
		Configure::load("Captcha.captcha");
		$captcha_config = Configure::read("Captcha");

		$code = $this->generate();
		#$this->Session->delete("Captcha.code");

		// Use milliseconds instead of seconds
		srand(microtime() * 100);
		
		// Pick random background, get info, and start captcha
		$background = $captcha_config['png_backgrounds'][rand(0, count($captcha_config['png_backgrounds']) -1)];
		list($bg_width, $bg_height, $bg_type, $bg_attr) = getimagesize($background);
		
		// Create captcha object
		$captcha = imagecreatefrompng($background);
	    imagealphablending($captcha, true);
	    imagesavealpha($captcha , true);
		
		$color = $this->hex2rgb($captcha_config['color']);
		$color = imagecolorallocate($captcha, $color['r'], $color['g'], $color['b']);
	        
		// Determine text angle
		$angle = rand( $captcha_config['angle_min'], $captcha_config['angle_max'] ) * (rand(0, 1) == 1 ? -1 : 1);
		
		// Select font randomly
		$font = $captcha_config['fonts'][rand(0, count($captcha_config['fonts']) - 1)];
		
		// Verify font file exists
		if( !file_exists($font) ) throw new Exception('Font file not found: ' . $font);
		
		//Set the font size.
		$font_size = rand($captcha_config['min_font_size'], $captcha_config['max_font_size']);
		$text_box_size = imagettfbbox($font_size, $angle, $font, $code);

		$padding = !empty($captcha_config['padding']) ? $captcha_config['padding'] : 0;
		$padding_width = $padding*$bg_width/100;
		$padding_height = $padding*$bg_height/100;
		
		// Determine text position
		$box_width = abs($text_box_size[6] - $text_box_size[2]);
		$box_height = abs($text_box_size[5] - $text_box_size[1]);
		$text_pos_x_min = 0+$padding_width;
		$text_pos_x_max = ($bg_width) - ($box_width) - $padding_width;
		$text_pos_x = rand($text_pos_x_min, $text_pos_x_max);			
		$text_pos_y_min = $box_height + $padding_height;
		$text_pos_y_max = ($bg_height) - ($box_height / 2) - $padding_height;
		$text_pos_y = rand($text_pos_y_min, $text_pos_y_max);

		if(!empty($captcha_config['center']))
		{
			$text_pos_x = ($bg_width - $box_width)/2;
			$text_pos_y = $bg_height/2 + $box_height/3; # Since lowercase letters are only half the box height, we need to add more
		}

		// Draw shadow
		if( $captcha_config['shadow'] ){
			$shadow_color = $this->hex2rgb($captcha_config['shadow_color']);
		 	$shadow_color = imagecolorallocate($captcha, $shadow_color['r'], $shadow_color['g'], $shadow_color['b']);
			imagettftext($captcha, $font_size, $angle, $text_pos_x + $captcha_config['shadow_offset_x'], $text_pos_y + $captcha_config['shadow_offset_y'], $shadow_color, $font, $code);	
		}

		// Draw text
		imagettftext($captcha, $font_size, $angle, $text_pos_x, $text_pos_y, $color, $font, $code);	
		
		// Output image
		header("Content-type: image/png");
		imagepng($captcha);
		exit(0);

	}

	function generate() # MUST be i ncontroller. views cant write to session.
	{
		Configure::load("Captcha.captcha");
		$captcha_config = Configure::read("Captcha");
		$code = '';
		$length = rand($captcha_config['min_length'], $captcha_config['max_length']);
		while( strlen($code) < $length ) {
			$code .= substr($captcha_config['characters'], rand() % (strlen($captcha_config['characters'])), 1);
		}
		$this->Session->write("Captcha.code", $code);
		return $code;
	}

	function hex2rgb($hex_str, $return_string = false, $separator = ',') {
		$hex_str = preg_replace("/[^0-9A-Fa-f]/", '', $hex_str); // Gets a proper hex string
		$rgb_array = array();
		if( strlen($hex_str) == 6 ) {
			$color_val = hexdec($hex_str);
			$rgb_array['r'] = 0xFF & ($color_val >> 0x10);
			$rgb_array['g'] = 0xFF & ($color_val >> 0x8);
			$rgb_array['b'] = 0xFF & $color_val;
		} elseif( strlen($hex_str) == 3 ) {
			$rgb_array['r'] = hexdec(str_repeat(substr($hex_str, 0, 1), 2));
			$rgb_array['g'] = hexdec(str_repeat(substr($hex_str, 1, 1), 2));
			$rgb_array['b'] = hexdec(str_repeat(substr($hex_str, 2, 1), 2));
		} else {
			return false;
		}
		return $return_string ? implode($separator, $rgb_array) : $rgb_array;
	}
	
}

?>
