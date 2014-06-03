<?

$config['Captcha'] = array(
	'code' => '',
	'min_length' => 5,
	'max_length' => 5,
	'png_backgrounds' => array(dirname(__FILE__) . '/../vendors/default.png'),
	#'fonts' => array(dirname(__FILE__) . '/../vendors/times_new_yorker.ttf'),
	'fonts' => array(dirname(__FILE__) . '/../vendors/new_baskerville.ttf'),
	'characters' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',
	'padding' => null,#"5", # In percent, IF randomized
	'center' => true, # Don't randomize placement
	'min_font_size' => 24,
	'max_font_size' => 30,
	'color' => '#000',
	'angle_min' => 10,
	'angle_max' => 15, # 15 default
	'shadow' => false,
	'shadow_color' => '#CCC',
	'shadow_offset_x' => -2,
	'shadow_offset_y' => 2
);

