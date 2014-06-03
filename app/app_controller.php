<?php
/* SVN FILE: $Id: app_controller.php 6311 2008-01-02 06:33:52Z phpnut $ */
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package			cake
 * @subpackage		cake.app
 * @since			CakePHP(tm) v 0.2.9
 * @version			$Revision: 6311 $
 * @modifiedby		$LastChangedBy: phpnut $
 * @lastmodified	$Date: 2008-01-01 22:33:52 -0800 (Tue, 01 Jan 2008) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Short description for class.
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		cake
 * @subpackage	cake.app
 */

#include_once(dirname(__FILE__)."/../includes/classDefinitions.inc");
include_once(dirname(__FILE__)."/../includes/product_pricing.php");

class AppController extends Controller 
{
	var $helpers = array('Html','Session','Form','Javascript','Ajax','Hd','Js'=>array('HdJquery'));#,'TidyFilter');
	var $uses = array("GalleryImage", "Product", "Customer","ProductPricing","CustomImage","StampSurcharge","TrackingArea","TrackingRelease","TrackingTask","TrackingEntry","TrackingVisit","ContentSnippet",'PurchaseStep','Quote','Ribbon','Border','Tassel','Charm','Frame','Config',"ContactInfo","ShippingPricePoint","ProductPart",'CreditCard','ProductQuote','RecommendedQuote','Coupon');
	#var $helpers = array('Html','Session','Form','Javascript','Firstfashion','Ajax','Time');
	#var $components = array('Auth','Upload','Email','Payment');
	#var $uses = array('MemberFriend','Member','MemberMessage','MemberSession');
	#var $appconfig = null;
	var $breadcrumbs = array();
	var $components = array('Session','Upload','Image','Auth','Email','RequestHandler','Cim');
	var $body_title = null;
	var $body_title_crumbs = true; # Auto generate crumbs from body_title
	var $bread_title = null;
	var $build = array();
	var $build_page = false;
	var $database = false;
	var $scripts = array();
	var $styles = array();
	var $js_required_functions = array();
	var $js_required_script = array();
	var $js_required_fields = array(); # List of id's...
	var $js_required_fields_if = array(); # List of condition => idlist's
	var $js_required_conditions = null;
	var $livesite = false;
	var $is_admin = false;
	var $steps_incomplete = array();
	var $option_list = array();
	var $config = array();

	var $imgonlys = array('imageonly','imageonly_nopersonalization');

	var $controller_crumbs = true;
	var $malysoft = false;
	var $hdtest = false;
	var $internal_ips = array('71.224.15.91', '71.224.15.94', '69.139.23.131','24.127.150.29','71.224.1.11','69.139.23.21','69.253.57.132');
	var $tracking_entry_id = null;
	var $paypal_enabled = true;

	var $meta_keywords = "custom gifts, personalized gifts, stamp gifts, custom bookmarks, custom laminated bookmarks, bookmarks, bookmark, custom paperweights, personalized paperweights, paperweights, custom coffee mugs, custom mugs, personalized coffee mugs, personalized mugs, mugs";
	var $meta_description = "Custom gifts - bookmarks, paperweights, magnet, mugs, tote bags, keychains, mousepads, puzzles, postcards, rulers and more. No setup or design charges. Low minimums. Fast service. Made in USA. Premium quality.";
	var $pageTitle = "Custom Gifts, Personalized Gifts ";# by Harmony Designs";#Custom Gifts by Harmony Designs&reg; | Made in USA | Bookmarks, Paperweights, Magnets and more | Top quality | Low minimums";
	var $rightbar_disabled = null;

	var $javascript_sets = array();
	var $appconfig = array();

	var $proctimer = array();
	var $jsonResponse = array();

	function proctime() # Adds timestamp to list and prints difference from last one.
	{
		return; # OFF FOR NOW.

		$time = microtime(true);
		$bt = debug_backtrace();
		$caller = $bt[0];
		$caller2 = $bt[1];
		$file = basename($caller['file']);
		$line = $caller['line'];
		$class = $caller2['class'];
		$function = $caller2['function'];
		$url = !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : "?";

		$diff = (!empty($this->proctimer) ? $time - $this->proctimer[count($this->proctimer)-1] : 0);
		$total = (!empty($this->proctimer) ? $time - $this->proctimer[0] : 0);

		error_log("$url : $class->$function: $time ($diff / $total) @ $file:$line");
		$this->proctimer[] = $time;
	}
	
	function beforeFilter()
	{
		$this->proctime();

		Configure::write("wholesale_site", $this->wholesale_site = preg_match("/^(www[.])?(wholesale)[.]/", $_SERVER['HTTP_HOST']));
		#error_log("WHOLE=".Configure::read("wholesale_site"));

		#error_log("CALLED {$this->params['url']['url']}");
		#error_log("PORT=".print_r($_SERVER['SERVER_PORT'],true));
		#error_log("BEFORE_FILTER");
		//$this->malysoft = preg_match("/malysoft/", $_SERVER['HTTP_HOST']);
		$this->malysoft = FALSE;
		$this->hdtest = preg_match("/hdtest/", $_SERVER['HTTP_HOST']);
		#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());
		##error_log("AUTH_REDIR=".$this->Auth->redirect());
		##error_log("SESS (FOR CHECKING AUTH=".print_r($this->Session->read('Auth'),true));

		#error_log("PARAMS=".print_r($this->params,true));

		if (isset($this->params['isAjax']))
		{
			$this->set("is_ajax",true);
			$this->layout = "default_plain";
			if (empty($_REQUEST['debug']))
			{
				#Configure::write("debug", 0); # Shut off for ajaxcalls.
				# We hide, so it's okay no matter what.
			}
			Configure::write("debug", 0);
		}
		include(dirname(__FILE__)."/../includes/database.inc");
		$this->database = $database;

		$this->load_appconfig();

		$this->setup_access_control();

		$this->livesite = preg_match("/harmonydesigns[.]com$/", $_SERVER['HTTP_HOST']);

		##error_log("ACT=".print_r($this->params,true));
		if(!empty($this->params['admin']))
		{
			$this->layout = "default_admin";
			if(!empty($this->params['isAjax']) || $this->Auth->user('eMail_Address') == 't_maly@comcast.net')
			{
				Configure::write('debug', 2);
			} else if (empty($_REQUEST['debug']) && $this->livesite) {
				Configure::write("debug",0);
			}
		#} else if ($this->livesite) {
		} else if (!$this->malysoft) { 
			Configure::write('debug', 0);
		}
		if(empty($this->params['isAjax']) && $this->Auth->user('eMail_Address') == 't_maly@comcast.net')
		{
			Configure::write('debug', 2);
		}
		# Intialize session variables...
		$this->initialize_session();
		$this->generate_breadcrumbs();

		Configure::write("internal_ips", $this->internal_ips);

		$host = $_SERVER['HTTP_HOST'];

		$host_parts = preg_split("/[.]/", $host);

		#error_log("HOST=$host, HP=".print_r($host_parts,true));

		if (!$this->malysoft && !preg_match("/^www[.]/", $host) && count($host_parts) <= 2 && preg_match("/^[A-Za-z]/", $host)) # NOT AN IP!
		{
			#error_log("SERVER REDIR TO WWW=$host");
			# Needs to work for any secure https ajax, etc.
			
			$this->redirect("http://www.$host".$_SERVER['REQUEST_URI'], 301); # force www
		}

		if (isset($this->params['url']['session_debug']))
		{
			print_r($this->Session->read());
		}

		if (isset($this->params['url']['debug']))
		{
			Configure::write('debug', 2);
		}

		if (isset($this->params['url']['start_over']))
		{
			#error_log("BUILD STARTOVER!");
			$this->Session->delete("Build");
			##error_log("DEL");
		}

		if(!empty($_REQUEST['goto']))
		{
			$this->Session->write("goto", $_REQUEST['goto']);
		}

		if(!empty($_REQUEST['session_id'])) # Auto-login link, ie via email.
		{
			$session_id = $_REQUEST['session_id'];
			$customer = $this->Customer->find(" session_id = '$session_id' ");
			$this->manual_login($customer);
		}

		if (isset($this->params['url']['layout']))
		{
			$this->build['preview_layout'] = $this->params['url']['layout'];
			#if($this->build['preview_layout'] == 'imageonly' && empty($_REQUEST['nobleed']))
			#{
			#	$this->build['preview_layout'] = 'fullbleed';
			#}
			$this->Session->write("Build", $this->build);
		}

		#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());

		$this->params['action'] = preg_replace("/[.]php$/", "", $this->params['action']);

		$this->set_global_variables();
		#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());

		include_once(dirname(__FILE__)."/../includes/tracking.inc"); # WE WANT TO TRACK EVEN REQUESTS THAT DONT RENDER (but redirect...)
		#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());
	}

	function get_all_shipping_options($shipping_id, $product_list, $order_cost = 0)
	{
		$shippingAddress = $this->ContactInfo->read(null, $shipping_id);
		$customer = $this->Session->read("Auth.Customer");
		if(!empty($shippingAddress['ContactInfo']['Zip_Code']))
		{
			$country = $shippingAddress['ContactInfo']['Country'];
			$zipCode = $shippingAddress['ContactInfo']['Zip_Code'];
			#echo "SHIP=$zipCode";
		} else { return array(); }
		$shippingOptions = $this->ShippingPricePoint->calculate_shipping_options_list(array($zipCode, $country), $product_list, $order_cost, !empty($customer['is_wholesale']));
		return $shippingOptions;
	}

	function require_secure() { $this->require_https(); }
	function require_https($secure = true) # Lets us switch to http version.
	{
		#error_log("PORT=".print_r($_SERVER['SERVER_PORT'],true));
		if (empty($_SERVER['HTTPS']))
		{
			$host = $_SERVER['HTTP_HOST'];
			if (preg_match("/dev[.]harmonydesigns[.]com/", $host) ){
				// these lines were commented out because there were problems the Checkout from the DEV site.
				// Eventually we do want to be able to go through the entire Checkout process from DEV, for testing purposes, but
				// for now we will comment this out to avoid unforseen problems. 
				//$host = "dev.harmonydesigns.com";
				$secure = false;
				return;
				//$host = "www.harmonydesigns.com"; // comment this out if you decide to try to do Checkouts from the DEV site again
				
			} else if (preg_match('/harmonydesigns[.]com$/', $host) && !preg_match("/^(www|vps|wholesale)[.]/",$host))
			{
				$host = "www.harmonydesigns.com";
				
			}
			$prefix = $secure ? "https://" : "http://";
			$goto = "$prefix$host".$_SERVER['REQUEST_URI']; # FORCE SECURE!
			#error_log("GOTO=$goto");
			#exit(0);
			$this->redirect($goto);
		}
	}

	# STUFF TO TRACK/RECORD
	#
	# product views: 
	#
	# purchases:
	#
	# ??? what stuff can be retrieved on the spot in reporting, instead of recorded when the event happens?
	#

	function log_event($event, $data = null)
	{
		# Get url.


		$xml = "<data>";
		foreach($data as $key => $value)
		{
			$xml .= "<$key>$value</$key>";
		}
		$xml .= "</data>";
	}

	function anonymous_login()
	# Guest.
	{

	}

	function manual_login($data)
	# MAKE SURE WERE PASSED email, so we can look up.... since legacy needs customer_id
	{
		$customer = null;
		if (is_array($data) && empty($data['Customer']['customer_id']) && !empty($data['Customer']['eMail_Address'])) # Don't use data if missing customer_id
		{
			$customer = $this->Customer->find(array('eMail_Address'=>$data['Customer']['eMail_Address']));
		} else if (is_array($data)) {
			$customer = $data;
		} else { #
			$customer = $this->Customer->find(array('eMail_Address'=>$data));
		}
		$this->Auth->login($customer['Customer']['customer_id']); # Pass ID since passing whole hash may cause problems when password is empty/null (encrypting?)
		#$this->Session->write("Auth.Customer", $customer['Customer']);
		$this->legacy_login($customer); # MUSTdo this first!
	}

	function update_session($data)
	{
		foreach($data as $k=>$v)
		{
			$this->Session->write("Auth.Customer.$k", $v);
		}
		$customer = $this->Session->read("Auth.Customer");
		$this->Customer->save(array('Customer'=>$customer));
	}

	function legacy_login($customer, $password = null) # TO register session in legacy systm
	{
		if (!$password && !empty($customer['Customer']['Password'])) { $password = $customer['Customer']['Password']; }
		$email_pass = $customer['Customer']['eMail_Address'] . $password;
		$form_password = !empty($this->data['Customer']['Password']) ? $this->data['Customer']['Password'] : null; # Password only available in form...
		#error_log("EMAIL_PASS = $email_pass");
		$cookieText = $customer['Customer']['customer_id'] . 'x' . md5($email_pass);
		#$this->Cookie->write("customerlogin", $cookieText);
		$this->set_legacy_cookie("customerlogin", $cookieText);

		$this->Session->write('customerRecord', $this->Session->read("Auth.Customer"));

		# IF we're an admin, auth for admin38, too...
		if ($customer['Customer']['is_admin'])
		{
			$this->Session->write('UName' , "sfranklin");
			$this->Session->write('canManageOrders' , 'Yes');
			$this->Session->write('canManageParts' , 'Yes');
			$this->Session->write('canManageUsers' , 'Yes');
			$this->Session->write('canManageItems' , 'Yes');
			$this->Session->write('canManageEvents' , 'Yes');
			$this->Session->write('canManageDatabase' , 'Yes');
			$this->Session->write('canManageTestimonials' , 'Yes');
		}
	}

	function set_global_variables()
	{
		if (!defined('HTTPHOST')) 
		{
	        	define('HTTPHOST', "http://" . $_SERVER['HTTP_HOST']); # for urls esp in emails.
		}
		# Set default body title...

		# Set account.
		$customer = $this->Session->read("Auth.Customer");
		$customer_id = $this->Session->read("Auth.Customer.customer_id");
		$this->set("customer", $customer);
		$this->set("customer_id", $customer_id);
		$this->is_admin = !empty($customer['is_admin']);
		$this->set("is_admin", $this->is_admin);

		#$this->paypal_enabled = ($this->malysoft || $this->hdtest || $this->is_admin);
		$this->set("paypal_enabled", $this->paypal_enabled);

		$this->set("params", $this->params);
		#$this->set("preview_layout", !empty($this->build['preview_layout']) ? $this->build['preview_layout'] : 'standard');
		$customer_object = new Object();
		#foreach($customer as $key => $value) { $customer_object->$key = $value; }
		$customer_object = (object) $customer;
		$this->set("my_account", $customer);

		$this->config = Set::combine($this->Config->find('all'), "{n}.Config.name", "{n}.Config.value");

		ClassRegistry::addObject('account', $customer_object);

		$snippets = $this->ContentSnippet->find('all');
		$this->snippets = Set::combine($snippets, "{n}.ContentSnippet.snippet_code", "{n}.ContentSnippet.content");
		$this->snippet_titles = Set::combine($snippets, "{n}.ContentSnippet.snippet_code", "{n}.ContentSnippet.snippet_title");

		$this->set("secure_base", $this->get_url_host(true));

		Configure::load("background_colors");
		$this->set("backgroundColors", Configure::read("BackgroundColors"));
	}

	function set_goto($url = '')
	{
		if (!$url) { $url = $_SERVER['HTTP_REFERER']; }
		$this->set_legacy_cookie("goto", $url);
	}

	function clear_goto()
	{
		$goto = $_COOKIE['goto'];
		$this->set_legacy_cookie("goto", null);
		return $goto;
	}

	function set_legacy_cookie($key, $value)
	{
		$cookieServer = $_SERVER['HTTP_HOST'];
		$cookieServerParts = explode(".", $cookieServer);
		#error_log("PARTS=".print_r($cookieServerParts,true));
		if (count($cookieServerParts) > 2) 
		{ 
			array_shift($cookieServerParts); # Remove last element.
		}
		$cookieHost = join(".", $cookieServerParts);
		$cookieDomain = ".$cookieHost";
		$www_cookieDomain = "www.$cookieHost";

		#$cookieServer = preg_replace("/^\w+(([.]\w+){2,})$/", "\\1", $cookieServer);
		$cookieExpiration = 0;
		if ($value === null)
		{
			$cookieExpiration = -1;
		}

		$_COOKIE[$key] = $value;

		#error_log( "SET_COOKIE $key = $value, EXP=$cookieExpiration, SER=$cookieHost, DOM=$cookieDomain");
		setcookie($key, $value, $cookieExpiration, '/', $www_cookieDomain);
		setcookie($key, $value, $cookieExpiration, '/', $cookieHost);
		setcookie($key, $value, $cookieExpiration, '/', $cookieDomain);
	}

	function redirect($url = '')
	{
		#error_log("CALLED REDIRECT(".print_r($url,true).")");
		return parent::redirect($url);
		#debug_print_backtrace();
	}

	function clear_build()
	{
			#error_log("BUILD CLEAR!");
		$this->Session->delete("Build");
	}

	function clear_build_options()
	{
			#error_log("BUILD CLEAROPT!");
		$this->Session->delete("Build.options");
	}

	function get_build_crop_coords($layout = 'standard', $product_config = null, $build = null, $defaults_only = false, $no_pers = false)
	{
		if(empty($build['CustomImage'])) { return null; }
		
		if($layout == 'imageonly_nopersonalization') { $layout = 'imageonly'; }

		#if (empty($build)) { $build = $this->build; }
		# NEVER mix up what we're doing right now with previewing other stuff....

		#error_log("GBCC, DEFONLYCROP ($layout)=$defaults_only");
		#error_log("BUILD_CROP=".print_r(!empty($build['crop'])?$build['crop']:null,true));

		$crop_coords = empty($defaults_only) && !empty($build['crop'][$layout]) ? $build['crop'][$layout] : null;

		#error_log("EXISTING CROP_COORDS=". (!empty($build['crop']) ? print_r($build['crop'],true) : null));



		$img_path = APP."/webroot/".$build['CustomImage']['display_location'];
		list($w,$h) = getimagesize($img_path);
		if(!empty($build['CustomImage']['orient']) && ($build['CustomImage']['orient'] == 90 || $build['CustomImage']['orient'] == 270))
		{
			$old_w = $w;
			$w = $h;
			$h = $old_w;
		} # So get proper orient for product, dont want prod to rotate along with image!

		if (!empty($crop_coords) && count($crop_coords) < 4) # Bogus, erase.
		{
			#error_log("ERASE OLD=".print_r($crop_coords,true));
			$crop_coords = null;
			unset($build['crop']);
		}

		if (empty($crop_coords)) # Bogus data. show Default.
		# We always take no matter the width/height, since we might scale larger!
		{
			#error_log("EMPTY OLD, CLEAR");
			$crop_coords = null;
		}

		if (!$crop_coords || !empty($_REQUEST['reset_coords'])) # Get defaults. (standard has none)
		{
			#error_log("DEFAULT NO CROP CORDS");
			#error_log("GETTING DEFAULTS ($defaults_only)=");
			# This is returning wrong default coords for new std on fullbleed
			$crop_info = $this->get_build_crop_info($layout, $product_config, $build, $defaults_only, $build, $no_pers);

			#error_log("DEFAULT_CROP=".print_r($crop_info,true));

			#error_log("GET_BUILD_CROP_INFO=".print_r($crop_info,true));

			##error_log("GETTING CROP DEFAULTS, LAY=$layout, CAN_DO_FB={$build['Product']['fullbleed']} (else, bestfit) = ".print_r($crop_info,true));

			# Default positioning/cropping for image only (esp on 20 products page) should be fullbleed.
			if(!empty($layout) && (in_array($layout, $this->imgonlys) || $layout == 'fullbleed'))
			{
				#error_log("USING FULLBLEED (DEF=$defaults_only, LAY=$layout)=".print_r($crop_info['bestfit'],true));
				$can_do_fullbleed = !empty($build['Product']['fullbleed']);
				$coords = $can_do_fullbleed ? $crop_info['bestfit'] : $crop_info['imageonly'];
				#error_log("RETURNING ($can_do_fullbleed=CDFB)=".print_r($coords,true));
				return $coords;
			} else {
				#error_log("USING STANDARD=".print_r($crop_info['crop'],true));
				return $crop_info['crop'];
			}
		} else {
			#error_log("CUSTOM_CROPS");
		}

		#error_log("USING CROP COORDS=".print_r($crop_coords,true));

		return $crop_coords;
	}

	function get_build_crop_info($layout = 'standard', $product_config = null, $image = null, $defaults_only = false, $build = array(), $no_pers = false)
	{
		$cropdata = array();
		if($layout == 'imageonly_nopersonalization') { $layout = 'imageonly'; }

		if (empty($product_config))
		{
			$product_config = $this->get_product_config($build['Product']['code'], null, (in_array($layout, $this->imgonlys) || $layout == 'fullbleed'), $build); # Doesn't pass other stuff.
		}

		if (empty($image)) { $image = $build; }
		#$image_path = APP."/webroot/".$this->build['CustomImage']['Image_Location'];

		if(!empty($image['CustomImage']))
		{
			$image_path = APP."/webroot/". $image['CustomImage']['display_location'];
		} else if (!empty($image['GalleryImage'])) {
			$image_path = APP."/../".$image['GalleryImage']['image_location'];
		}

		if(empty($image_path)) { return null; }
		list($upload_width, $upload_height) = getimagesize($image_path);

		$rotate = !empty($build['rotate']) ? $build['rotate'] : null;

		if(!empty($rotate) && ($rotate == 90 || $rotate == 270))
		{
			$old_upload_width = $upload_width;
			$upload_width = $upload_height;
			$upload_height = $old_upload_width;
			#exit(0);
		} # So get proper orient for product, dont want prod to rotate along with image!

		$upload_w2h = $upload_width / $upload_height;

		$scaled_width = 175; # Hardcoded.

		$scale_factor = $scaled_width / $upload_width; # Multiply to get the smaller version.

		#####################################
		# 
		$crop_coords = empty($defaults_only) && !empty($build['crop'][$layout]) ? $build['crop'][$layout] : null;
		# This causes default to load whole image.
		#array(0,0,$upload_width,$upload_height);

		#error_log("EXST_CROP_CORDS=".print_r($crop_coords,true));

		$crop = array();

		if(!empty($crop_coords))
		{
			#error_log("YUES CROP_CORDS");

		$crop['x'] = $crop_coords[0];
		$crop['y'] = $crop_coords[1];
		$crop['w'] = $crop_coords[2];
		$crop['h'] = $crop_coords[3];

		# Now scale down.
		$crop['scaled_x'] = ceil($crop['x'] * $scale_factor);
		$crop['scaled_y'] = ceil($crop['y'] * $scale_factor);
		$crop['scaled_w'] = ceil($crop['w'] * $scale_factor);
		$crop['scaled_h'] = ceil($crop['h'] * $scale_factor);

		} else {
			# Default crop coords.... 
			#error_log("NO CROP_CORDS, calc");
			# CENTER.
			$box = 'image';
			if(empty($build['options']['personalizationInput']) && !empty($product_config['image.nopersonalization']) && !empty($no_pers))
			{
				$box = 'image.nopersonalization';
			} else if(in_array($layout, $this->imgonlys) &&!empty($product_config['fullbleed']) && !empty($build['Product']['fullbleed'])) {
				$box = 'fullbleed';
			} else if (in_array($layout, $this->imgonlys) &&!empty($product_config['fullview'])) { 
				$box = 'fullview';
			}
			# Dont' default to fullbleed unless product says so...

			#error_log("DEFAULT COORD BOX = $box !!!!!");

			list($canvas_x,$canvas_y,$canvas_w,$canvas_h) = $product_config[$box];
			#echo "Cw2h=$canvas_w / $canvas_h";
			$canvas_w2h = $canvas_w/$canvas_h;


			$fit_width = $upload_width;
			$fit_height = $fit_width / $canvas_w2h;
	
			if ($fit_height < $upload_height)
			{
				$fit_height = $upload_height;
				$fit_width = $fit_height * $canvas_w2h;
			}
			$fit_x = ($upload_width - $fit_width)/2;
			$fit_y = ($upload_height - $fit_height)/2;

			$crop['x'] = $fit_x;
			$crop['y'] = $fit_y;
			$crop['w'] = $fit_width;
			$crop['h'] = $fit_height;

		}

		$cropdata['crop'] = $crop;

		#error_log("SETTING CROP WSTD=".print_r($crop,true));


		######################################
		# bestfit

		# HERE WE DETERMINE DEFAULT COORDINATES/POSITIONING FOR imageonly (imageonly_nopers) AND imageonly(+personalization)

		$box = 'image';

		$perstext = !empty($build['options']['personalizationInput']) ? $build['options']['personalizationInput'] : null;

		#error_log("PERSTEXT?={$perstext}, PC_IMNOP={$product_config['image.nopersonalization']}, NOP=$no_pers");

		if(!empty($product_config['fullbleed']) && in_array($layout, $this->imgonlys) && !empty($build['Product']['fullbleed'])) {
			$box = 'fullbleed';
		} else if(empty($perstext) && !empty($product_config['image.nopersonalization']) && !empty($no_pers)) { # && !empty($build['Product']['fullbleed'])) {
			$box = 'image.nopersonalization';
		} else if (!empty($product_config['fullview'])) { 
			$box = 'fullview';
		}
		#error_log("DEFAULT 2 I/O COORD BOX = $box !!!!!");

		list($canvas_x,$canvas_y,$canvas_w,$canvas_h) = $product_config[$box];
		##error_log("BOX=$box");
		#echo "Cw2h=$canvas_w / $canvas_h";
		$canvas_w2h = $canvas_w/$canvas_h;

		# Fit things relative to the iamge itself, ie best fit matches w or h of IMAGE, not canvas (so large and small pics ok). fits whole image, 'just right'

		# Area selected is same ratio as canvas.

		# Fit by width.
		$fit_width = $upload_width;
		$fit_height = $fit_width / $canvas_w2h;

		if ($fit_height > $upload_height)
		{
			$fit_height = $upload_height;
			$fit_width = ceil($fit_height * $canvas_w2h);
		}

		$fit_x = ($upload_width - $fit_width)/2;
		$fit_y = ($upload_height - $fit_height)/2;

		$bestfit = array();
		$bestfit['x'] = ceil($fit_x);
		$bestfit['y'] = ceil($fit_y);
		$bestfit['w'] = ceil($fit_width);
		$bestfit['h'] = ceil($fit_height);

		$bestfit['scaled_x'] = ceil($bestfit['x']*$scale_factor);
		$bestfit['scaled_y'] = ceil($bestfit['y']*$scale_factor);
		$bestfit['scaled_w'] = ceil($bestfit['w']*$scale_factor);
		$bestfit['scaled_h'] = ceil($bestfit['h']*$scale_factor);

		$cropdata['bestfit'] = $bestfit;

		##################################
		# Now create 'imageonly' (full image) version, where no bleed. just in case.
		$imageonly_width = $upload_width;
		$imageonly_height = $imageonly_width / $canvas_w2h;

		if ($imageonly_height < $upload_height)
		{
			$imageonly_height = $upload_height;
			$imageonly_width = ceil($imageonly_height * $canvas_w2h);
		}

		#error_log("BEFORE W=$imageonly_width, H=$imageonly_height");

		# Shrink so has padding on image only (user can stretch later)
		############$imageonly_width /= 0.80; # divide by fraction will shrink, multiply will expand
		# Since this shrinking wasnt on the live zoom tool, it was never accurate!
		# NO MORE AUG16-2012

		$imageonly_height = $imageonly_width / $canvas_w2h;

		#error_log("AFTER W=$imageonly_width, H=$imageonly_height");

		# NO MORE: Move image only pic to 1/3 up
		# 9/27/12: STILL KEEP CENTERED... (since live preview does that)
		$imageonly_x = ($upload_width - $imageonly_width)/2;
		$imageonly_y = ($upload_height - $imageonly_height)/2; # Change to larger number to move up.

		$imageonly = array();
		$imageonly['x'] = ceil($imageonly_x);
		$imageonly['y'] = ceil($imageonly_y);
		$imageonly['w'] = ceil($imageonly_width);
		$imageonly['h'] = ceil($imageonly_height);

		$imageonly['scaled_x'] = ceil($imageonly['x']*$scale_factor);
		$imageonly['scaled_y'] = ceil($imageonly['y']*$scale_factor);
		$imageonly['scaled_w'] = ceil($imageonly['w']*$scale_factor);
		$imageonly['scaled_h'] = ceil($imageonly['h']*$scale_factor);

		$cropdata['imageonly'] = $imageonly;
		$cropdata['imageonly_nopersonalization'] = $imageonly;
		#$cropdata['imageonly'] = array(0,0,$upload_width,$upload_height);

		# Really should be in proportion to product and container
		# so properly offset to middle, etc.

		#error_log("CROP_D=".print_r($cropdata,true));

		return $cropdata;

		# INCONSISTENCIES WITH LIVE VERSION OF FIT POSSIBLY CAUSED
		# BY MIXING UP IMAGE/IMAGE.NOPERS BOXES AND THUS SCALE RATIOS
		# ie not getting no_pers properly passed...

	}

	function get_effective_base_price_list($productCode = null, $build_pricing = true)
	{
		if (!$productCode) { $productCode = $this->Session->read("Build.Product.code"); }
		$catalogNumber = $this->Session->read("Build.GalleryImage.catalog_number");
		$parts = $this->load_build_parts();
		$stamp_surcharge = !empty($catalogNumber) ? $this->GalleryImage->find("GalleryImage.catalog_number = '$catalogNumber'") : null;
		#echo "BP=$build_pricing... CN=$catalogNumber";
		$price_list = $build_pricing ? 
			$this->Product->get_effective_base_price_list($productCode, $this->get_customer(), $stamp_surcharge, $parts, $catalogNumber) : 
			$this->Product->get_effective_base_price_list($productCode, $this->get_customer());
		#print_r($price_list);
		return $price_list;
	}

	function set_build_custom_image($id = '')
	{
		if (!$id)
		{
			unset($this->build['CustomImage']);
		} else {
			$custom_image = $this->CustomImage->read(null, $id);
			$this->set_build_gallery_image(null);
			$this->build['CustomImage'] = $custom_image['CustomImage'];
		}
		$this->Session->write("Build", $this->build);
	}

	function set_build_gallery_image($id = '')
	{
		if (!$id)
		{
			unset($this->build['GalleryImage']);
		} else {
			$gallery_image = $this->GalleryImage->find(" GalleryImage.catalog_number = '$id' ");
			$this->set_build_custom_image(null);
			$this->build['GalleryImage'] = $gallery_image['GalleryImage'];
			$this->build['options'] = array(); # Clear fullbleed, etc...
			$this->build['crop'] = null;
			$this->build['template'] = null;

			if(!empty($this->build['preview_layout']) && !in_array($this->build['preview_layout'], array('standard','imageonly','imageonly_nopersonalization')))
			{
				# Don't let fullbleed.
				$this->build['preview_layout'] = 'standard';
			}
		}
		$this->Session->write("Build", $this->build);
	}

	function clear_product()
	{
		unset($this->build['Product']);
		$this->Session->write("Build", $this->build);
	}

	function assert_valid_image_type_for_product()
	{
		if (empty($this->build['Product'])) { return; }
		$product = $this->build['Product'];
		if (!preg_match("/custom/", $product['image_type']) && !empty($this->build['CustomImage']))
		{
			$this->set_build_custom_image(null);
		} else if (!preg_match("/(repro|real)/", $product['image_type']) && !empty($this->build['GalleryImage'])) {
			$this->set_build_gallery_image(null);
		}
	}

	function initialize_new_build() # Don't modify what's in the cart anymore....
	{
		unset($this->build['cart_item_id']);
		unset($this->build['cartID']);
		$this->Session->write("Build", $this->build);
	}

	function getImagePath($anon = false) # Will force anonymous...
	{

		if ($this->is_logged_in() && !$anon)
		{
			$customer_id = $this->get_customer_id();
			return "/images/custom/customers/$customer_id"; # May want to change once logged in.
		} else {
			$session_id = $this->Session->id();
			return "/images/custom/anon/$session_id"; # May want to change once logged in.
		}
	}

	function set_build_product($prod = '', $clear_build = false)
	{
		# RUINING BORDER ONSWITCH PROD HERE??

		$old_prod = !empty($this->build['Product']['code']) ? $this->build["Product"]['code'] : null;
		#error_log("SET_PROD1=$prod");

		if($old_prod != $prod)
		{
			unset($this->build['saved']); # No matter what.
		}

		if($clear_build)
		{
			#error_log("clear_build");
			$this->build = array();
		} 

		if (!$prod)
		{
			unset($this->build['prod']);
			unset($this->build['Product']);
			unset($this->build['quantity']);
		} else {

			$orig_prod = $prod;
			#error_log("orig=$orig_prod");

			#echo "P=$prod";


			# No longer alter bookmark.
			if ($prod == 'BC') 
			{ 
				#error_log( "SETPROD2=$prod");
				######################################$prod = 'B'; 
				if(empty($this->build['options']['tasselID']) || $this->build['options']['tasselID'] <= 0)
				{
					$this->build['options']['tasselID'] = 41;
					#echo "TASSEL!";
				}
				#else 
				#{
					#error_log("TASSEL PRESERVING=".$this->build['options']['tasselID']);
				#}
				if(empty($this->build['options']['charmID']) || $this->build['options']['charmID'] <= 0)
				{
					$this->build['options']['charmID'] = 17;
				}
			} # Same thing....
			else
			if ($prod == 'BNT') 
			{ 
				#error_log( "SETPROD3=$prod");
				#################################$prod = 'B'; 
				# Set tassel/charm to none.
				$this->build['options']['tasselID'] = -1;
				$this->build['options']['charmID'] = -1;
				unset($this->build['options']['charm']);
				unset($this->build['options']['tassel']);
			} # Same thing....
			else
			if ($prod == 'B')
			{
				#error_log( "SETPROD4=$prod");
				#echo "OLD=$old_prod";
				#if(!isset($this->build['options']['tasselID']))# && $old_prod == 'BNT')
				# We really DO want to show a tassel if such is asked for...

				if(!isset($this->build['options']['tasselID']) || $this->build['options']['tasselID'] <= 0)
				{
					$this->build['options']['tasselID'] = 41;
				}
				$this->build['options']['charmID'] = 0;
				unset($this->build['options']['charm']);
			}
			#error_log("P=$prod");
			if($prod == 'BB')
			{
				#error_log("CLEARING TAS/CHM");
				#$this->build['options']['tasselID'] = 0;
				#$this->build['options']['charmID'] = 0;
				unset($this->build['options']['tasselID']);
				unset($this->build['options']['charmID']);
				unset($this->build['options']['charm']);
				unset($this->build['options']['tassel']);
			}

			if(!empty($this->build['options']['tasselID']))
			{
				$this->build['options']['tassel']['tasselID_data'] = $this->Tassel->read(null,  $this->build['options']['tasselID']);
			}
			if(!empty($this->build['options']['charmID']))
			{
				$this->build['options']['charm']['charmID_data'] = $this->Charm->read(null,  $this->build['options']['charmID']);
			}

			if ($prod == 'PSF')
			{
				#$prod = 'PS';
				if(!isset($this->build['options']['poster_frame']))
				{
					$this->build['options']['poster_frame'] = 'yes';
				}
			}

			if($prod == 'ORN')
			{
				if(empty($this->build['options']['charmID']))
				{
					$this->build['options']['charmID'] = '161';
				}
			}

			#print_r($this->build['options']['charm']);

			$product = $this->Product->find("code = '$prod'");

			if(strtolower($product['Product']['available']) != strtolower('yes'))
			{
				$this->Session->delete("Build.Product");
				$this->Session->setFlash("We're sorry, this product is no longer available");
				$this->redirect("/");
			}

			#$this->build['prod'] = $prod;
			$this->build['prod'] = $orig_prod;
			#error_log("PROD=$orig_prod, $prod");
			if ($orig_prod != $prod)
			{
				$this->build['orig_prod'] = $orig_prod;
			}
			# We need to know which REAL product, so we generate proper blank....
			$this->build['Product'] = $product['Product'];

			#error_log("PROD=".$this->build['Product']['code']);

			# Don't set quantity automatically.
			#if (empty($this->build['quantity']) || $product['Product']['minimum'] > $this->build['quantity'])
			#{
			#
			#	$this->build['quantity'] = $product['Product']['minimum'];
			#}

			# Correct layout if not possible....
			$this->options = $this->load_product_options();
			$cant_do_standard = true;
			foreach($this->options as $opt)
			{
				if($opt['Part']['part_code'] == 'quote')
				{
					$cant_do_standard = false;
					$this->Session->write("CantDoStandard", 'false');
					break;
				}
			}
			// the following IF structure is for debugging. Added by Jack A
			/*if($prod == 'DPW-FLC' || $prod == 'DPW')
			{
				
				$cant_do_standard = true;
				$this->Session->write("CantDoStandard", 'true');
			}*/
			
			error_log("PROD={$this->build['Product']['code']}");
			error_log("OPTS=".print_r($this->options,true));
			error_log("CANT DO STD+$cant_do_standard");

			$template = !empty($this->build['template']) ? $this->build['template'] : null;
			
			if($template == 'standard' && $cant_do_standard)
			{
				$template = !empty($this->build['options']['personalizationNone']) ? "imageonly_nopersonalization" : "imageonly";
				error_log("TMPL NOW=$template");
				if(method_exists($this, "set_template"))
				{
					$this->set_template($template);
				}
			}
			$this->Session->write("templateTest", $template); // for debugging
		}

		if($old_prod != $prod && !(in_array($prod, array('BB','B','BNT','BC')) && in_array($old_prod, array('BB','B','BNT','BC'))))
		{
			unset($this->build['crop']);
		}

		# Clear browse_prod (dropdown)
		$this->Session->delete("browse_prod");
		$this->Session->write("Product", $prod);
		$this->Session->write("Build", $this->build);
		//App Ctrl: 1017: 
		$this->Session->write("Build_Options_Test", $this->build['options']);
		
		#error_log("SESS=".print_r($this->Session->read("Build.options"),true));

	}
	function compare_products_sort($a,$b)
	{
		if ($a['choose_index'] == $b['choose_index']) { return 0; }
		return ($a['choose_index'] < $b['choose_index']) ? -1 : 1;
	}

	function encode_xml($stuff, $name = 'data')
	{
		$data = is_object($stuff) ? get_object_vars($stuff) : $stuff;

		$xml = "<$name>";

		if (is_array($data))
		{
		foreach($data as $key => &$value)
		{
			if (is_object($value)) { $value = get_object_vars($value); }
			if (is_array($value))
			{
				$xml .= "<$key>";
				foreach($value as $kkey => $kvalue)
				{
					$xml .= "<$kkey>$kvalue</$kkey>";
				}
				$xml .= "</$key>";
			} else {
				$xml .= "<$key>$value</$key>";
			}
		}
		}

		$xml .= "</$name>";

		return $xml;
	}

	function setup_access_control()
	{
		# Accessing hdtest from external world.
		#$this->Session->setFlash("{$_SERVER['HTTP_HOST']}, {$_SERVER['REMOTE_ADDR']}, INT=".print_r($this->internal_ips,true));

		if($this->wholesale_site)
		{
			$this->Auth->deny('*');
			$this->Auth->userScope = array('Customer.is_wholesale'=>true);
			# Other customization, ie error messages, etc.

			# helping them get back to RETAIL site once logged out....

			# suggesting retail site if they dont have a wholesale account....

			# different signup form for wholesale.... & different "Login" title....

		} else if (preg_match("/hdtest/", $_SERVER['HTTP_HOST']) && !in_array($_SERVER['REMOTE_ADDR'], $this->internal_ips)) {
			$this->Auth->deny('*');
			$this->Session->write("goto", "/".$this->params['url']['url']);
		} else if (!empty($_REQUEST['login'])) { 
			$this->Auth->deny('*');
			$this->Session->write("goto", "/".$this->params['url']['url']);
		} else if(empty($this->params['admin']) && empty($this->Auth->allowedActions)) # Never specified anything yet and non-admin page.
		# If we want explicit control, set it BEFORE calling parent::beforeFilter() in controller
		{
			$this->Auth->allow(); # Default allow access to stuff, unless controller says differently.
		} else {
			if ($this->params['controller'] == 'account')
			{
				#$this->Auth->allow('login');
			} # Else
			#$this->Auth->allow();
			#$this->Auth->deny(); # deny everything.
		}
		#$this->Auth->userScope = array('Member.active' => 1);
		#$this->Auth->logoutRedirect = array('controller'=>'members','action'=>'index'); # Go to homepage
		#error_log("PARAMS=".print_r($this->params,true));
		if (isset($this->params['admin'])) {
			#error_log("ADMIN");
			$this->Auth->userModel = 'AdminUser'; # Special access under /admin
			$this->Auth->fields = array('username'=>'email','password'=>'password');

			$this->Auth->loginRedirect = array('admin'=>true,'controller'=>'admin_dashboard','action'=>'index');
			$this->Auth->logoutRedirect = "/admin";#array('controller'=>'members','action'=>'index'); # Go to homepage
			$this->Auth->loginAction = array('admin'=>true,'controller'=>'account','action'=>'login');
			$this->Auth->userScope = array();
		} else { # Normal account.
			#$this->Auth->loginRedirect = array('action'=>'index'); # View your profile...
			# Never go to account page when logging in... or logging out.
			#$this->Auth->logoutRedirect = "/account";#array('controller'=>'members','action'=>'index'); # Go to homepage
			$this->Auth->loginAction = array('admin'=>false,'controller'=>'account','action'=>'login');

			$this->Auth->userModel = 'Customer'; # Normal customer account
			$this->Auth->fields = array('username'=>'eMail_Address','password'=>'Password');
			$this->Auth->authenticate = ClassRegistry::init('Customer');
			$this->Auth->authorize = 'controller';

		}
		$this->Auth->loginError = 'Unable to login. Did you <a href="/account/forgot">forget your password?</a>';
		$this->Auth->autoRedirect = false; # sends to members::login() , for session record set.... for legacy system


		$this->Auth->authError = '&nbsp;';#<h2>Please login to continue.</h2>';

	}

	function isAuthorized()
	{
		#echo 'AUTJ';
		#exit(0);
		#return true;
		if (isset($this->params['admin']))
		{
			#$this->require_https(); # Don't do this cuz it will mess up ajax inline editing 
			return $this->checkAdminSession();
		} else {
			return true;
		}
	}

   	function checkAdminSession() {  
   		// if the admin session hasn't been set  
		$authorized = false;

		if (!$this->isAdminAuthorized())
		{
   			// set flash message and redirect  
			#$this->Security->requireLogin();

			$this->Session->setFlash("Your account does not have adequate access to view this page.");

			return false;
   		} else {
			return true;
		}
	}

	function isAdminAuthorized()
	{
		# Either is_admin flag set in DB (good to not have web interface so not abused), or email in list.
		$is_admin = $this->Session->read("Auth.Customer.is_admin");
		if ($is_admin) { return true; }
		return false;
   	}  

	function is_logged_in()
	{
			$customer_id = $this->Session->read("Auth.Customer.customer_id");
			$logged_in = ($customer_id != "" ? true : false);
			return $logged_in;
	}

	function get_customer()
	{
			return $customer = $this->Session->read("Auth.Customer");
	}

	function get_customer_id() { return $this->customer_id(); }

	function get_session_id()
	{
		return session_id();
	}

	function customer_id()
	{
			return $customer_id = $this->Session->read("Auth.Customer.customer_id");
	}

	function initialize_session()
	{
		if (!empty($this->params['form']["start_over"]) || isset($_REQUEST['start_over']))
		{
			
			#$this->Session->write("Build", array());
			$this->build = array();
			$this->Session->write("Build", $this->build);
		}

		$customerRecord = $this->Session->read("customerRecord");
		if (!$customerRecord) { $customerRecord = array(); }
		$this->Session->write("customerRecord", $customerRecord);

		$shoppingCart = $this->Session->read("shoppingCart");
		if (!$shoppingCart) { $shoppingCart = array(); }
		$this->Session->write("shoppingCart", $shoppingCart);

		$this->build = $this->Session->read("Build");
		if (!$this->build) { $this->build = array(); }
		$this->Session->write("Build", $this->build);


		#$_SESSION = $this->Session->read();
		#print_r($_SESSION);
	}

	function goto_redirect($url) # If we need to goto somewhere, go there, else redirect to where we want to, if specified.
	{
		if (!empty($_COOKIE['goto']))
		{
			$goto = $_COOKIE['goto'];
			$this->clear_goto();
			$this->redirect($goto);
		} else if ($goto = $this->Session->read("goto")) { 
			$this->Session->write('goto', null);
			$this->redirect($goto);
		} else if ($url) {
			$this->redirect($url);
		}
		return;
	}

	function save_account($data)
	# Signs up or modifies an account if needed.
	{
		$customer_id = !empty($data['Customer']['customer_id']) ? $data['Customer']['customer_id'] : $this->get_customer_id();
		$data['Customer']['customer_id'] = $customer_id;
		#error_log("CUSTOMERID=$customer_id");
		$new_customer = !$customer_id;
		# Verification of required fields is handled elsewhere, since depends...

		if(!empty($data['Customer']['Password']))
		{
			$data['Customer']['guest'] = 0;
		}

		if ($new_customer)
		{
			$this->Customer->create();
			# Now set registration date...
			$data['Customer']['dateAdded'] = $this->unix_date(true);
		}

		if ($this->Customer->save($data))
		{
			$customer_id = $this->Customer->id;

			$this->CustomImage->moveAnonymousImages(session_id(), $this->Customer->id); # ALWAYS MOVE!

			if ($new_customer)
			{
	
				########$this->Session->setFlash(__('Account created', true));
				# Send out email confirmation.... with username, password, email, etc.
				# XXX TODO
				#$customer = $this->Customer->read(null, $customer_id); #Read everything, including password (may not have been in form)
				#if (!empty($data['Customer']['Password']))
				#{
				#	$this->sendEmail($data, "Harmony Designs Account", "account_created", array('customer'=>$data['Customer']));
				#}
			}

			$this->manual_login($data); # Update session with new info...

			$customer = $this->Customer->read(null, $customer_id);
			$this->Session->write("Auth.Customer", $customer['Customer']);
			return true;
		} else {
			return false;
		}
	}

	function set_ajax()
	{
		if (empty($_REQUEST['debug'])) { Configure::write("debug", 0); }
		$this->layout = 'ajax';
	}

	function set_variables()
	{
		$this->set("isNotAjax", empty($this->params['isAjax'])); # So we can default to ajax unless we want to not.
		$this->set("isAjax", !empty($this->params['isAjax']));

		$this->set("wholesale_site", Configure::read("wholesale_site"));

		#if(!empty($this->params['isAjax']) && empty($_REQUEST['debug']) && empty($this->params['admin'])) { Configure::write("debug",0); }
		#if(!empty($_REQUEST['debug'])) { Configure::write("debug", 2); }

		$this->set("malysoft", $this->malysoft);
		$this->set("hdtest", $this->hdtest);

		$parent_codes = $this->get_parent_codes();
		$this->set("parent_codes", $parent_codes);

		$this->set("livesite", $this->livesite);
		$this->set("scripts", $this->scripts);
		$this->set("styles", $this->styles);
		$this->set("meta_keywords", $this->meta_keywords);
		$this->set("meta_description", $this->meta_description);
		$this->set("required_fields", $this->js_required_fields);
		$this->set("required_functions", $this->js_required_functions);
		$this->set("required_script", $this->js_required_script);
		$this->set("required_fields_if", $this->js_required_fields_if);
		$this->set("required_conditions", $this->js_required_conditions);
		# Has defaults set above...

		$this->set("title_for_layout", $this->pageTitle);

		$this->set("tracking_entry_id", $this->tracking_entry_id);

		$this->set("full_url", "/" . $this->params['url']['url']); # SCRIPT_NAME/PATH_INFO
		$this->set("url", "/" . $this->params['url']['url']); # SCRIPT_NAME/PATH_INFO
		$this->set("javascript_sets", $this->javascript_sets);
		$this->set("prototype_js", true);
		if (!isset($this->viewVars['body_title']) && isset($this->body_title)) { $this->set('body_title', $this->body_title); }
		if (!isset($this->viewVars['page_title']) && isset($this->page_title)) { $this->set('page_title', $this->page_title); }

		$url = $this->params['url']['url'];
		if (!$url) { $url .= "/"; }

		if (!isset($this->body_title)) { $this->body_title = ucwords(preg_replace("/_/", " ", $this->params['action'])); }

		if(!preg_match("/^\//", $url)) { $url = "/$url"; }

		if (!empty($this->bread_title) && $this->body_title_crumbs && !isset($this->breadcrumbs[$url])) { $this->breadcrumbs[$url] = $this->bread_title; }
		if (!empty($this->title) && $this->body_title_crumbs && !isset($this->breadcrumbs[$url])) { $this->breadcrumbs[$url] = $this->title; }
		else if (!empty($this->body_title) && $this->body_title_crumbs && !isset($this->breadcrumbs[$url])) { $this->breadcrumbs[$url] = $this->body_title; }
		# Automatically set breadcrumbs according to 'body_title'

		$this->set("breadcrumbs", $this->breadcrumbs);

		if(empty($this->build))
		{
			$this->build = $this->Session->read("Build");
		} # Let us temporarily alter, without affecting other pages....

		$this->set("build", $this->build);

		if (empty($this->rightbar_disabled) && !isset($this->viewVars['rightbar_disabled']) && $this->build_page && count($this->build) && !isset($this->viewVars['rightbar_template'])) {
			#$this->set("rightbar_template", "build/preview/index");
			#$this->set("rightbar_disabled", false);
			# We always have the option to disable, or override.
		}

		if (empty($this->rightbar_disabled))
		{
			$this->rightbar_disabled = isset($this->viewVars['rightbar_disabled']) ?  $this->viewVars['rightbar_disabled'] : false;
		}
		if (empty($this->rightbar_disabled))
		{
			$this->rightbar_disabled = empty($this->viewVars['rightbar_template']) ? true : false;
		}

		$this->set("rightbar_disabled", $this->rightbar_disabled);

		# We dont need if we have the product record.
		#
		#$stock_products = $this->Product->findAll("is_stock_item = 1");
		#$stock_item_product_codes = array();
		#foreach($stock_products as $sp)
		#{
		#	$stock_item_product_codes[] = $sp['Product']['code'];
		#}
#
#		$this->set("stock_item_product_codes", $stock_item_product_codes);

		$special_offer = $this->ContentSnippet->find("snippet_code = 'special_offer'");
		$this->set("special_offer", !empty($special_offer) ? (!empty($special_offer['ContentSnippet']['snippet_title']) ? $special_offer['ContentSnippet']['snippet_title'] .": " : "") . strip_tags($special_offer['ContentSnippet']['content']) : null);

		if(!empty($this->snippets)) { $this->set("snippets", $this->snippets); }
		if(!empty($this->snippet_titles)) { $this->set("snippet_titles", $this->snippet_titles); }

		$steps = $this->PurchaseStep->find('all');

		$purchase_steps_by_name = Set::combine($steps, '{n}.PurchaseStep.name', '{n}.PurchaseStep');

		$this->set("purchase_steps", $purchase_steps_by_name);

		if(!empty($this->config)) { $this->set("config", $this->config); }

		if(!empty($_REQUEST['date']))
		{
			$this->action .= ".". $_REQUEST['date'];
		}

		$settings = $this->Config->find('all');
		$this->settings = Set::combine($settings, "{n}.Config.name", "{n}.Config.value");
		$this->set("settings", $this->settings);

		# Out to be here in beforeRender() so we can change around earlier.
		$this->set("preview_layout", !empty($this->build['preview_layout']) ? $this->build['preview_layout'] : '');

		if(!empty($_REQUEST['debug_vars']))
		{
			if($_REQUEST['debug_vars'] == 1)
			{
				print_r($this->viewVars);
			} else {
				print_r($this->viewVars[$_REQUEST['debug_vars']]);
			}
		}

		$this->set("customer", $this->Session->read("Auth.Customer")); 
		$this->set("is_wholesale", $this->Session->read("Auth.Customer.is_wholesale")); 

		#echo "D=".Configure::read('debug');

		if (!empty($_REQUEST['debug']))
		{
			Configure::write('debug', 2);
		} else if ($this->livesite) {
			Configure::write('debug', 0);
		}

		############################
		$cond = array('(NOW() BETWEEN start AND end OR (NOW() > start AND end IS NULL) OR (NOW() < end AND start IS NULL))',
			'active'=>1,
			'advertise'=>1
		);
		if(!$this->Auth->user("is_wholesale")) # Dont show wholesale coupons until user logs in.
		{
			$cond['wholesale_only'] = 0;
		}

		$coupon = $this->Coupon->find('first', array('conditions'=>$cond,'order'=>'wholesale_only DESC')); # Show wholesale ad instead, if applicable.

		$this->set("advertisedCoupon", $coupon);
	}

	function can_choose_stamp_type()
	{
		if (empty($this->build['GalleryImage'])) { return false; }
		if (empty($this->build['Product'])) { return false; }
		$stamp_can_repro = $this->build['GalleryImage']['reproducible'];
		$product_image_type = split(",", $this->build['Product']['image_type']);

		# If product can do repro and real, and image can do repro and real, we're ok.
		if ($stamp_can_repro == 'Yes' && in_array("real", $product_image_type) && in_array("repro", $product_image_type))
		{
			return true;
		}
		return false;
	}

	function stamp_type()
	{
		$stamp_can_repro = $this->build['GalleryImage']['reproducible'];
		$product_image_type = split(",", $this->build['Product']['image_type']);

		# If product can do repro and real, and image can do repro and real, we're ok.
		if ($stamp_can_repro == 'Yes' && in_array("real", $product_image_type) && in_array("repro", $product_image_type))
		{
			return true;
		}
		return false;
	}

	function load_product_options($prod = '', $all = false, $build = null, $template = null, $newbuild = false)
	{
		if(empty($build)) { $build = $this->build; }

		$code = "";
		if (!$prod)
		{
			if (empty($build['Product'])) { return null; }

			$product_type_id = $build['Product']['product_type_id'];
			$code = $build['Product']['code'];
			$prod = $build['Product']['code'];
			$prodname = $build['Product']['prod'];
		} else {
			$product = $this->Product->find(" code = '$prod' ");
			$product_type_id = $product['Product']['product_type_id'];
			$code = $product['Product']['code'];
			$prodname = $product['Product']['prod'];
		}
		$options = $this->ProductPart->findAll("ProductPart.product_type_id = '$product_type_id'");
		$step_options = array();
		$is_stamp = !empty($build['GalleryImage']);

		$is_stamp = !empty($build['GalleryImage']);
		$can_choose_stamp_type = $this->can_choose_stamp_type();

		if(empty($template))
		{
			$template = !empty($build['template']) ? $build['template'] : (!empty($build['CustomImage']) ? "imageonly" : "standard");
		}


		$catalogNumber = !empty($build["GalleryImage"]) ? $build["GalleryImage"]['catalog_number'] : null;

		#$product_config = $this->get_product_config($prod, null, ($template == 'imageonly'), $build); # Doesn't pass other stuff.
		$product_config = $this->get_product_config($prod, null, false, $build); # never same image only so we get steps for image+text too...

		$completed_options = array();

		$exclude = array();

		if(is_array($all)) # Ones to exclude
		{
			$exclude = is_array($all) ? $all : array();
		}


		foreach($options as $option)
		{
			$step_name = $option['Part']['part_code'];
			if (!empty($completed_options[$step_name])) { continue; }
			$completed_options[$step_name] = 1;
			#$step_file = dirname(__FILE__)."/../../product/build/{$step_name}.php";
			$step_file = dirname(__FILE__)."/views/elements/build/options/{$step_name}.ctp";
			$new_build_step_file = dirname(__FILE__)."/views/designs/form/{$step_name}.ctp";
			$product_step_file = dirname(__FILE__)."/views/elements/build/options/{$step_name}_{$prodname}.ctp";
			#echo "SF=$step_file";
			#echo "SF=$step_file, PSF=$product_step_file<br/>";
			if (!file_exists($step_file) && !file_exists($product_step_file) && (empty($newbuild) || !file_exists($new_build_step_file))) { continue; }

			if ($step_name == 'stamp' && (!$is_stamp || !$can_choose_stamp_type)) # Only show stamp option when can pick and isn't a custom image.
			{
				if ($is_stamp && !$can_choose_stamp_type)
				{
					$reproductionStamp = strtolower($build['GalleryImage']['reproducible']);
					$this->Session->write("Build.options.stamp.reproductionStamp", $reproductionStamp);
				}
				continue;
			} 

			if(!empty($exclude) && in_array($step_name, $exclude)) { continue; } # tassel, charm, etc on second side.


			if (empty($all) && $template == 'imageonly' && (in_array($step_name, array('quote')) || ($code != 'B' && $code != 'BC' && $code != 'ORN' && $step_name == 'charm')))
			# Personalization shows up on even fullviews
			#
			#if ($template == 'imageonly' && (in_array($step_name, array('border','personalization','quote')) || ($code != 'B' && $code != 'BC' && $code != 'ORN' && $step_name == 'charm')))
			# Do we exclude personalization, too?
			{
				#continue;
			#} else if ($template == 'textonly') {

			}

			$fullbleed = !empty($this->build['options']['fullbleed']) ? $this->build['options']['fullbleed'] : null;

			if(empty($all) && $template == 'imageonly' && !empty($fullbleed) && $step_name == 'border')
			{
				#continue; # Don't let bookmark border on fullbleed, but ok on image-only (fit)
			}


			if (empty($all) && $template == 'imageonly' && $step_name == 'personalization' && !empty($catalogNumber))
			{
				###########continue; # No personalization on image-only stamps.
				# This is ruining stamp on cards, small keychains w/o text, etc...
			}

			if (empty($all) && $template == 'imageonly' && $step_name == 'quote')
			{
				######continue; # No text on image only.
			}

			if($step_name == 'personalization' && empty($product_config['personalization']))
			{
				# because im using a ttally different blank file!
				continue; # Don't do personalization on products that don't have it enabled. (ie image-only small keychain, etc)
			}

			if($template == 'imageonly' && $step_name == 'personalization' && empty($product_config['text']))
			{
				# Can't do normal text, so 'imageonly' means no personaliation either.
				#######continue;
				# XXX TODO
			}

			if($template == 'imageonly' && $step_name == 'charm' && $code == 'PW')
			{
				#continue; # Cant do charm on image only rect pw's
			}

			if (empty($all) && $template == 'imageonly' && $step_name == 'personalization' && $code == 'RL')
			{
				#continue; # No personalization image only rulers.
			}

			#if (empty($all) && $template == 'imageonly' && $step_name == 'personalization' && (!empty($product_config['image.2']) || !empty($product_config['fullview.2'])))
			#{
			#	continue; # No personalization on image-only stamps OR double-sided imageonly items.
			#}


			#if ($option['Part']['is_step'])
			#{
				$step_options[] = $option;
			#} # Else if is_step is false, skip!



			#if ($option['Part']['part_code'] == 'image' && $is_stamp)
			#{
			#	$option['Part']['part_name'] = 'Stamp Type';
			#	$step_options[] = $option;
			#}
		}
		return $step_options;
	}

        function get_product_config($code, $orient = null, $fullview = false, $build = array())
        {
                $configfile = $this->get_product_config_path($code, $orient, $fullview, $build);
                $config = include($configfile);
		#error_log("PROD_CONFIG ($code, $orient, $fullview)=$configfile");
                return $config;
        }

        function get_product_config_path($code, $orient = null, $fullview = false, $build = array())
        {
                $dir = $this->get_product_image_dir($code, $orient, $fullview, false, $build);
                #if ($code == 'BC') { $code = 'B'; }
		$parentcode = $this->get_parent_code($code);
                $configfile = "$dir/original/$code.inc";
		if(!empty($parentcode) && !file_exists($configfile))
		{
                	$dir = $this->get_product_image_dir($parentcode, $orient, $fullview, false, $build);
			return "$dir/original/$parentcode.inc";
		} else {
                	return $configfile;
		}
        }

	function get_parent_codes()
	{
		$child_products = $this->Product->findAll(" parent_product_type_id IS NOT NULL ");

		$pcodes = array();
		foreach($child_products as $cp)
		{
			$code = $cp['Product']['code'];
			$pcode = $this->get_parent_code($code);
			$pcodes[$code] = $pcode;
		}
		return $pcodes;
	}

	function get_parent_code($code)
	{
		$product = $this->Product->find(" code='$code' ");
		$parent_id = $product['Product']['parent_product_type_id'];
		$parentcode = null;
		if(!empty($parent_id))
		{
			$parent = $this->Product->read(null, $parent_id);
			$parentcode = $parent['Product']['code'];
		}
		return $parentcode;
	}

	function get_product_image_dir($code, $orient = 'horizontal', $fullview = false, $relative = false, $build = array())
	{
		# For BC, choose B.

		#if ($code == 'BC') { $code = 'B'; }

		$basedir = "/images/products/blanks";

		$parentcode = $this->get_parent_code($code); # fallback.

		$codebasedir = "$basedir/$code"; # default.

		if(!empty($parentcode) && !is_dir(APP."/../$codebasedir")) # Borrow parent blank if we dont have one...
		{
			$codebasedir = "$basedir/$parentcode";
			$code = $parentcode;
		}

	        $vertical_dir = "$codebasedir/vertical";
		$horiz_dir = "$codebasedir/horizontal";
		$abs = dirname(__FILE__)."/../";

		$dir = "";
		if (!$orient) { $orient = 'horizontal'; }

		$orient_dir = "$basedir/$code/$orient";
		$other_orient_dir = $orient == 'horizontal' ? "$basedir/$code/vertical" : "$basedir/$code/horizontal";
		if (file_exists($abs.$orient_dir)) { $dir = $orient_dir; }
		else if (file_exists($abs.$other_orient_dir)) { $dir = $other_orient_dir; }
		else { $dir = $horiz_dir; }

		$logo = !empty($build['options']['personalization_logo_id']) || !empty($build['PersonalizationLogo']);

		if($logo)
		{
			if (file_exists("$abs$dir-logo"))
			{
				$dir .= "-logo";
			}
		}
		list(,$caller) = debug_backtrace();
		#error_log("CAKLLED FROM=".$caller['file'].'::'.$caller['function'].'.'.$caller['line']);
		#error_log("DIR=$dir");

		if ($fullview)
		{
			if (file_exists("$abs$dir-fullview"))
			{
				$dir .= "-fullview";
			}
		}

		return $relative ? $dir : $abs.$dir;
	}

	function get_image_orientation($image, $rotate = 0, $cropinfo = null)
	{
		$cropinfo = null; # NO LONGER APPLIES, since not how the image is cropped - but zoomed/panned. orientation never changes.
		$image_path = $image;
		if (!empty($image['CustomImage']['thumbnail_location']))
		# This is the original orientation, so we can rotate image w/o having product rotate again with it.
		{
			$image_path = APP ."/webroot/".$image['CustomImage']['thumbnail_location'];
		}
		if (!empty($image['GalleryImage']['image_location']))
		{
			$image_path = APP ."/../".$image['GalleryImage']['image_location'];
		}

		if(preg_match("/^\/images/", $image_path))
		{
			$image_path = APP."/webroot/".$image_path;
		}
		if(preg_match("/^\/stamps/", $image_path))
		{
			$image_path = APP."/../".$image_path;
		}

		if(!empty($cropinfo) && count($cropinfo) >= 4 && $cropinfo[2] > 0 && $cropinfo[3] > 0)
		{
			list($x,$y,$w,$h) = $cropinfo;
		} else {
			if (!file_exists($image_path)) { return null; }
			list($w,$h) = getimagesize($image_path);
		}

		#if ($rotate == 90 || $rotate == 270)
		#{
		#	$old_w = $w;
		#	$w = $h;
		#	$h = $old_w;
		#}
		return $w >= $h ? "horizontal" : "vertical";
	}

	function track($areaname, $taskname, $data = array(), $id = null) # For performance/improvement testing. (esp before/after)
	{
		# Need mechanism in db to mark when changes are done. (admin 'releases', areas affected, etc)
		# List of areas (should match $area) - in db.

		$ignore_internal = false;
		

		#######################################

		$ip = $_SERVER['REMOTE_ADDR'];

		if ($ignore_internal && in_array($ip, $this->internal_ips))
		{
			return; 
		}


		##########################################

		$is_bot = false;
		$browser = !empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";

		$bots = array(
			'Google',
		        'Yahoo',
		        'bot',
		        'spider',
		        'crawler',
		        'ipMonitor',
			'ZenHTTP',	
			'searchme.com',
			'Validator',
		);
		
		foreach($bots as $bot)
		{
			if (preg_match("/$bot/i", $browser) || $browser == "") { $is_bot = 1; }
		}
		
		$bot_ips = array(
			'65[.]55', # microcrapt
			'124[.]115', # china
			'58[.]61[.]164',
			'208[.]78[.]245[.]194',
		);
		
		foreach($bot_ips as $botip)
		{
			if (preg_match("/^$botip/i", $ip)) { $is_bot = 1; }
		}

		if ($is_bot) { return; } # Ignore them!

		if (!empty($id)) # Updating, saying task was completed successfully...
		{
			$entry = $this->TrackingEntry->read(null, $id);
			$entry['TrackingEntry']['complete'] = 1;
			# May add complete data, timestamp, etc someday...
			$this->TrackingEntry->save($entry);

			return;
		}


		$area = $this->TrackingArea->find("TrackingArea.url = '$areaname'");
		$area_id = $area['TrackingArea']['tracking_area_id'];
		$task = $this->TrackingTask->find("TrackingTask.url = '$taskname'");
		$task_id = $task['TrackingTask']['tracking_task_id'];

		#echo "AREA=$areaname, $area_id; TN=$taskname, $task_id";

		# Get current release id.
		$tracking_release_id = $this->TrackingRelease->get_latest($area_id, $task_id);

		# Get visit_id
		$session_id = session_id();
		$customer_id = $this->get_customer_id();
		$tracking_visit_id = $this->TrackingVisit->get_latest($session_id);

		# Get referer
		$ref = split("\?", !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null);
		$referer = $ref[0];
		$referer_qs = count($ref) > 1 ? $ref[1] : null;


		if (!$area_id || !$task_id || !$tracking_release_id) { return; } # Ignore if can't figure out!

		$tracking_entry = array('TrackingEntry'=>array(
			'tracking_area_id'=>$area_id,
			'tracking_task_id'=>$task_id,
			'tracking_visit_id'=>$tracking_visit_id,
			'tracking_release_id'=>$tracking_release_id,
			'session_id'=>$session_id,
			'customer_id'=>$customer_id,
			'ip_address'=>$ip,
			'referer'=>$referer,
			'referer_qs'=>$referer_qs,
			'data'=>serialize($data)
		));

		$this->TrackingEntry->create();
		$this->TrackingEntry->save($tracking_entry);
		$tracking_entry_id = $this->TrackingEntry->id;
		$this->tracking_entry_id = $tracking_entry_id;

	}

	function load_build_options($prod = '')
	{
		$this->option_list = array();
		$this->steps_incomplete = array();
		if (empty($this->options)) { $this->options = $this->load_product_options($prod); }

		$is_stamp = !empty($this->build['GalleryImage']);
		$can_choose_stamp_type = $this->can_choose_stamp_type();

		foreach($this->options as $option)
		{
			$option_name = $option['Part']['part_code'];
			$this->option_list[] = $option_name;
		}
		$this->option_list[] = 'comments';
		foreach($this->option_list as $option_name)
		{
			#echo "O=$option_name";
			if(empty($this->build['options'][$option_name]))
			{
				$this->steps_incomplete[$option_name] = $option_name;
			}
		}
	}

	function load_build_parts() # Converts from multidimensional $this->build to single flat form (suitable for cart_item or calculatin pricing)
	{
			 $parts = array();
			 if (empty($this->build['options'])) { return $parts; }
			 foreach($this->build['options'] as $option => $data)
			 {
			 	if (is_array($data))
				{
			 		foreach($data as $field => $value)
					{
						$parts[$field] = $value;
					}
				} # ALWAYS save array, dont just flatten.
				$parts[$option] = $data;
			 }
			 return $parts;
	}


	function calculate_item_unit_price($productCode, $quantity, $options)
	{
		list($pricePoint, $basePrice) = get_product_pricing_for_quantity($productCode, $quantity, $options);
		$pricePoint = "per$pricePoint";


		$surcharge = 0;
                if (!empty($options['catalogNumber']))
                {
			
                        $result = mysql_query ("Select $pricePoint from stamp_surcharge where catalog_number = '$options[catalogNumber]'", $this->database);
			#print_r($result);
                        if ( mysql_num_rows ($result) > 0) 
			{
                                $surchargeObj = mysql_fetch_object($result);
                                $surcharge = $surchargeObj->$pricePoint;
                                if (isset($options['reproductionStamp'])){
                                        $surcharge = 0;
                                }
			}
                }
		$unitPrice = $basePrice + $surcharge;
		return $unitPrice;
	}
	function generate_breadcrumbs() # We can overwrite $this->breadcrumbs, append, etc when we call the controller...
	{
		$name = $this->name;
		#$title = preg_replace("/([a-z])([A-Z])/", "$1 $2", $this->title);

		if (isset($this->title)) { $name = $this->title; }
		$this->breadcrumbs = array(
			#"/" . (isset($this->params['prefix']) ? $this->params['prefix'] : "") => "Home",
		);
		if(!empty($this->params['prefix']))
		{
			$this->breadcrumbs["/".$this->params['prefix']] = Inflector::humanize($this->params['prefix']);
		}
		if($this->controller_crumbs)
		{
			$this->breadcrumbs["/" . (isset($this->params['prefix']) ? $this->params['prefix']."/" : "") . $this->params['controller']] = $name;
		}
	}

	function filterImagesForProduct($code) # Stamp images...
	# XXX TODO
	{
		# Get allowable items on product.
		#$product = $this->Product->read(null, $product_id);
		$product = $this->Product->find("code = '$code'");
		$product_stamp = $product['Product']['stamp'];
		$product_image_type_list = split(",", $product['Product']['image_type']);
		$product_stamp_conditions_list = array();
		foreach($product_image_type_list as $product_image_type)
		{
			$product_stamp_image_types[$product_image_type] = true;
		}

		$product_stamp_conditions_list[] = "GalleryImage.available = 'Yes'";

		# stamp can be:

		# Only = reproduced but NOT the real stamp
		# yes = reproduced AND real
		# no = real, but NOT reproduced

		if (isset($product_stamp_image_types['repro']) && !isset($product_stamp_image_types['real'])) 
		# repro
		{
			$product_stamp_conditions_list[] = "GalleryImage.reproducible IN ('Only','Yes')";
		}
		else if (!isset($product_stamp_image_types['repro']) && isset($product_stamp_image_types['real']))
		# real
		{
			$product_stamp_conditions_list[] = "GalleryImage.reproducible IN ('No','Yes')"; # Not only reproducible
		}
		else if (isset($product_stamp_image_types['repro']) && isset($product_stamp_image_types['real']))
		# Both real and repro; product can do anything.
		{
			$product_stamp_conditions_list[] = "GalleryImage.reproducible IN ('Yes','No','Only')";
		}
		else 
		# Default. All.
		{
			$product_stamp_conditions_list[] = "GalleryImage.reproducible IN ('Yes','No','Only')";
		}

		# r = Yes => real,repro
		# r = Only => repro
		# r = No => real

		#if ($product_stamp == 'Repro')
		#{
		#	$product_stamp_conditions = "GalleryImage.reproducible IN ('Yes','Only')";
		#} else if ($product_stamp == 'Real') {
		#	$product_stamp_conditions = "GalleryImage.reproducible IN ('Yes','No')";
		#} else { #if ($product_stamp == 'Both') {
		#	$product_stamp_conditions = "GalleryImage.reproducible IN ('Yes','Only')";
		#}

		$this->GalleryCategory->unbindModel(array('hasAndBelongsToMany'=>array('GalleryImage')));

		$this->GalleryCategory->bindModel(array('hasAndBelongsToMany' => 
			array(
				'GalleryImage'=>array(
					'className'=>'GalleryImage',
					'joinTable'=>'browse_link',
					'foreignKey'=>'browse_node_id',
					'associationForeignKey'=>'catalog_number',
					'conditions' => join(" AND ", $product_stamp_conditions_list),
				),
			)
		));

	}

	function get_stamp_surcharge($productCode = '', $catalog_number = '')
	{
		#echo "PC=$productCode, CN=$catalog_number";
		if ($productCode)
		{
			$product = $this->Product->find(" code = '$productCode' ");
		} else {
			$product = array('Product'=> $this->Session->read("Build.Product"));
		}

		if (!preg_match("/real/", $product['Product']['image_type'])) { return null; } # Only charge surcharge if real product.

		if (!$catalog_number)
		{
			$catalog_number = $this->Session->read("Build.GalleryImage.catalog_number");
		}
		$this->GalleryImage->recursive = 2;
		$stamp_surcharge = $catalog_number ? $this->StampSurcharge->find("StampSurcharge.catalog_number = '$catalog_number'") : null;
		return $stamp_surcharge;
	}

	function getCustomImageAvailableProducts()
	{
		$this->Product->recursive = 1;
		#$image_type = " Product.stamp != 'real' ";
		$image_type = " FIND_IN_SET('custom', Product.image_type) ";

		$products = $this->Product->query("
			SELECT Product.*, IF(Product.parent_product_type_id IS NULL,Product.product_type_id,Product.parent_product_type_id) AS parent_id
			FROM product_type AS Product
			WHERE 
				Product.available = 'yes' AND 
				Product.is_stock_item = 0 AND
				Product.buildable = 'yes' AND 
				$image_type
			ORDER BY Product.stamp, parent_id, Product.sort_index
		");

		# Offer one we already chose as first one...
		if (!empty($this->build['Product']))
		{
			$found_product = false; # Don't show product if not available for image!
			# Now remove from elsewhere in the list.
			for($i = 0; $i < count($products); $i++)
			{
				if ($products[$i]['Product']['code'] == $this->build["Product"]['code'])
				{
					unset($products[$i]);
					$found_product = true;
				}
			}

			# Move to front.
			if ($found_product)
			{
				array_unshift($products, array('Product'=>$this->build['Product']));
			}

		}

		foreach($products as &$product)
		{
			$code = $product['Product']['code'];
			$product_pricings = $this->ProductPricing->findAll("productCode = '$code'",null, "quantity ASC");
			$product['ProductPricing'] = array();
			foreach($product_pricings as $pricing)
			{
				$product['ProductPricing'][] = $pricing['ProductPricing'];
			}
		}
				# Taken out so we can choose from rect vs domed pweights via list page buttons...
		return $products;
	}

	function getImageAvailableProducts($catalog_number)
	{
		$this->Product->recursive = 1;
		$image = $this->GalleryImage->find("GalleryImage.catalog_number = '$catalog_number'");
		$image_reproducible = $image['GalleryImage']['reproducible'];

		$image_type = "";
		if($image_reproducible == 'Yes')
		{
			#$image_type = "(Product.stamp != 'Custom')";
			$image_type = " ( FIND_IN_SET('repro', Product.image_type) OR FIND_IN_SET('real', Product.image_type) ) "; # custom,repro,real
		} else if ($image_reproducible == 'Only') {
			#$image_type = "(Product.stamp != 'real') AND (Product.stamp != 'Custom')";
			$image_type = " ( FIND_IN_SET('repro', Product.image_type) ) "; # custom,repro,real
		} else { # Real only...
			#$image_type = "(Product.stamp != 'Repro') AND (Product.stamp != 'Custom')";
			$image_type = " ( FIND_IN_SET('real', Product.image_type) ) "; # custom,repro,real
		}

		
		$products = $this->Product->query("
			SELECT Product.*, IF(Product.parent_product_type_id IS NULL,Product.product_type_id,Product.parent_product_type_id) AS parent_id
			FROM product_type AS Product
			WHERE 
				Product.available = 'yes' AND 
				Product.is_stock_item = 0 AND
				Product.buildable = 'yes' AND 
				$image_type
			ORDER BY Product.stamp, parent_id, Product.sort_index
		");


		# Offer one we already chose as first one...
		if (!empty($this->build['Product']))
		{
			$found_product = false; # Don't show product if not available for image!
			# Now remove from elsewhere in the list.
			for($i = 0; $i < count($products); $i++)
			{
				if ($products[$i]['Product']['code'] == $this->build["Product"]['code'])
				{
					unset($products[$i]);
					$found_product = true;
				}
			}

			# Move to front.
			if ($found_product)
			{
				array_unshift($products, array('Product'=>$this->build['Product']));
			}

		}

		foreach($products as &$product)
		{
			$code = $product['Product']['code'];
			$product_pricings = $this->ProductPricing->findAll("productCode = '$code'",null, "quantity ASC");
			$product['ProductPricing'] = array();
			foreach($product_pricings as $pricing)
			{
				$product['ProductPricing'][] = $pricing['ProductPricing'];
			}
		}
		return $products;
				#Product.parent_product_type_id IS NULL AND
	}

	function unix_date($time = false)
	{
		$format = $time ? 'Y-m-d H:i:s' : 'Y-m-d';
		return date($format);
	}


######################################################################################################
######################################################################################################
######################################################################################################
######################################################################################################
######################################################################################################


	function beforeRender()
	{
		if(!empty($this->params['isAjax']))
		{
			$this->layout = 'ajax'; # FORCE!
		}
		# Alternate views/action files to use
		if(!empty($_REQUEST['view'])) { $this->action = $_REQUEST['view']; }
		if(!empty($_REQUEST['template'])) { $this->action = $_REQUEST['template']; }
		if(!empty($_REQUEST['debugview'])) { $this->action = $_REQUEST['debugview']; } # Set custom view file - so try various options
		if(!empty($_REQUEST['debugaction'])) { $this->action = $_REQUEST['debugaction']; } # Set custom view file - so try various options
		#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());
		#$this->set("rightbar_disabled", false);

$this->set_variables();
		#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());

	}

	function generate_editable_data_list($data, $key)
	{
		$data_out = array();
		foreach ($data as $id => $value)
		{
		}
		return $data_out;
		
	}

	function load_appconfig()
	{
		if (!$this->appconfig)
		{
			$this->appconfig = include_once(dirname(__FILE__) . "/config/hd.conf.php");
		}
	}

	function load_appconfig_alt()
	{
		$this->appconfig = array();

		# maybe someday have a generic appconfig.php to load some globals out of...

		$basedir = CONFIGS . "/site";
		$dir = opendir($basedir);
		while($filename = readdir($dir))
		{
			if (preg_match("/^(\w+)[.]config[.]php/", $filename, $matches))
			{
				$prefix = $matches[1];
				$file_config = include($basedir . "/" . $filename);
				$this->appconfig[$prefix] = $file_config;
			}
		}
	}

	function member_limits($member_id = '', $key = null)
	{
		if (!$member_id) { $member_id = $this->Session->read('Auth.Member.member_id'); }
		if (!$member_id) { return array(); }
		if (is_array($member_id)) { $member = $member_id; }
		else { $member = $this->Member->read(null, $member_id); }
		#print_r($member);
		if (!$member || empty($member)) { return array(); }
		$limits = $this->Member->member_limits($member);
		if (isset($key)) { if(isset($limits[$key])) { return $limits[$key]; } else { return null; } }
		return $limits;
	}


	function generate_trail($url, &$trail)
	{
		# BLAH, FUCK IT....

		#
		# HONESTLY...
		# seems like better done through cookie variables (as array)....
		# ie check if url matches something in file.
		# if mat#ches, start popping items in cookie until find common ancestor.
		# then append.

		# we need to consider situations like when we're at search results pages and we want to go back!
		# so we cant just wipe out all entries in trail, we have to have a list of ACCEPTABLE parent
		# items....
		# or maybe each page has acceptable child items? dunno..

		# Take a look at current url. If in list, start backtracking to generate parents.

		if ($trail_info = $this->find_trail_item($url))
		{
			#$trail[] = array($url, 
			# Add to list.
			# get parent, add THAT to list.
		}
		$trail_specs = include(dirname(__FILE__)."/../config/trail.php");
		if ($trail_specs && count($trail_specs))
		{
			$trail = array();
			$url = $this->params['url']['url'];
			foreach ($trail_specs as $trail_item => $trail_item_info)
			{
				#$trail[] = 
			}

			return $trail;
		}
	}

	function setError($msg, $model = null)
	{
		$this->setMessage($msg, $model); # For now, do same thing.
	}

	function setMessage($msg, $model = null)
	{
		$merged_msg = $msg;
		if ($model)
		{
			$model_errors = $model->validationErrors;
			if ($model_errors && count($model_errors))
			{
				$merged_msg .= "<br/><br/>Reason: ";
				foreach($model_errors as $model_field => $model_error)
				{
					$merged_msg .= "<br/> $model_field: $model_error";
				}
			}
		}
		$this->Session->setFlash(__($merged_msg, true));
	}

	function expressCheckout($callback = null) # Generic such that can be moved to app_controller.php!
	{

	    if (isset($callback) && isset($_REQUEST['csid']))
	    {
	        // Restore session
	        
	        if (!$this->Payment->restoreSession($_REQUEST['csid']))
	        {
	    		#$this->Session->setFlash(__('Could not restore session.',true));
	    		$this->Session->setFlash(__('Could not complete transaction (retrieving session). Please try again.',true));
			$this->redirect("/members/edit");
	        }
	    }


	    if (!isset($callback))
	    {
		if (!$this->Payment->submitCheckout())
		{
	    		$this->Session->setFlash(__('Could not submit order: ' . $this->Payment->getError(),true));
			$this->redirect("/members/edit");
		}
	    }
	    else if ($callback == 'cancel')
	    {
	    	$this->Session->setFlash(__('Payment canceled.',true));
		$this->redirect("/members/edit");
	        #echo 'SNIFF... Why not?';
	        #exit;
	    }
	    else if ($callback == 'pay')
	    {
	        // Second call, make payment via PayPal

		$result = $this->Payment->getCheckoutResponse();
	        
	        if ($result === false)
	        {
	    	    $this->Session->setFlash(__('Unable to process payment: ' . $this->Payment->getError(), true));
	   	    $this->redirect("/members/edit");
	        }
	        else # Did payment... so do post-processing....
	        {
		    $transaction_id = $result["transaction"];
		    return $transaction_id;
		    # Save transaction_id into 'sales' so can do refund, etc...
		    #$this->setAction($this->payment_process_callback, $transaction_id);
	        }
	    }
	}

	function states_list($optional_value = false)
	{
		if ($optional_value === true) { $optional_value = 'None'; }

		$states = array(
			'' => $optional_value,
			'AK' => 'Alaska', 
			'AL' => 'Alabama', 
			'AR' => 'Arkansas', 
			'AZ' => 'Arizona', 
			'CA' => 'California', 
			'CO' => 'Colorado', 
			'CT' => 'Connecticut', 
			'DC' => 'District of Columbia', 
			'DE' => 'Delaware', 
			'FL' => 'Florida', 
			'GA' => 'Georgia', 
			'HI' => 'Hawaii', 
			'IA' => 'Iowa', 
			'ID' => 'Idaho', 
			'IL' => 'Illinois', 
			'IN' => 'Indiana', 
			'KS' => 'Kansas', 
			'KY' => 'Kentucky', 
			'LA' => 'Louisiana', 
			'MA' => 'Massachusetts', 
			'MD' => 'Maryland', 
			'ME' => 'Maine', 
			'MI' => 'Michigan', 
			'MN' => 'Minnesota', 
			'MO' => 'Missouri', 
			'MS' => 'Mississippi', 
			'MT' => 'Montana', 
			'NC' => 'North Carolina', 
			'ND' => 'North Dakota', 
			'NE' => 'Nebraska', 
			'NH' => 'New Hampshire', 
			'NJ' => 'New Jersey', 
			'NM' => 'New Mexico', 
			'NV' => 'Nevada', 
			'NY' => 'New York', 
			'OH' => 'Ohio', 
			'OK' => 'Oklahoma', 
			'OR' => 'Oregon', 
			'PA' => 'Pennsylvania', 
			'RI' => 'Rhode Island', 
			'SC' => 'South Carolina', 
			'SD' => 'South Dakota', 
			'TN' => 'Tennessee', 
			'TX' => 'Texas', 
			'UT' => 'Utah', 
			'VA' => 'Virginia', 
			'VT' => 'Vermont', 
			'WA' => 'Washington', 
			'WV' => 'West Virginia', 
			'WY' => 'Wyoming', 
		);

		if (!$optional_value) { unset($states['']); }

		return $states;
	}

	function sendAdminEmail($subject, $template, $vars = array(), $from = '')
	{
		$email =  $this->appconfig['admin_email'];
		$this->sendEmail($email, $subject, $template, $vars, $from);
	}

	function sendEmail($customer, $subject, $template, $vars = array(), $from = '')
	# Likely pass $this->data, $this->data["Customer"], or $this->data["Customer"]["email"] (tho cant read info in latter)
	{
		if (isset($vars['customer']) && is_array($vars['customer']) && isset($vars['customer']["Customer"])) { $vars['customer'] = $vars['customer']["Customer"]; } # So can $customer['email'], etc


		if (is_array($customer) && isset($customer["Customer"])) { $customer = $customer["Customer"]; } # So can $customer['email'], etc
		$customer_email = is_array($customer) ? $customer["eMail_Address"] : $customer;
		if (is_string($customer) && preg_match("/.+@.+/", $customer)) { $customer_email = $customer; } # In case given direct email, ie admin.
		if (!$customer_email) { $this->Session->setFlash("Unable to send email. No email address found."); return false; }


		if (!$from) { $from = $this->appconfig['admin_email']; }
		if (!preg_match('/@/', $from)) { $from = "$from@$_SERVER[HTTP_HOST]"; }
		# SHOULD AUTOMATICALLY DO FROM SENDMAIL...
		# If relative customername, set to domain!

		#error_log("EMAILING $customer_email");

		$this->log("CALLING sendEmail $customer_email ($subject, $template)",'email');



		$this->Email->reset();
		$this->Email->from = $from;
		$this->Email->to = $customer_email;
		$this->Email->bcc = 'jacka510@mac.com';
		$this->Email->subject = $subject;
		$this->Email->template = $template;
		# layout defaults to views/layouts/email/html/default.ctp
		$this->Email->sendAs = 'html';

		if (empty($this->malysoft) && isset($this->appconfig['smtp_server']))
		{
			$this->Email->delivery = 'smtp';
			$this->Email->smtpOptions = $this->appconfig['smtp_server'];
			# username, password, host
		}

		if(!empty($_SESSION['email_debug']))
		{
			$this->Email->delivery = 'debug';
		}

		$this->set("subject", $subject);

		if (is_array($customer)) { $this->set("customer", $customer); } # If we do not pass, we can't read name, act codes, etc.

		if (is_array($vars))
		{
			foreach ($vars as $var => $value)
			{
				$this->set($var, $value);
			}
		}

		$rv = $this->Email->send();
		$errors = $this->Email->smtpError;

		$this->log("EMAIL SENT ($rv) = ".print_r($errors,true),'email');

		return $rv;
	}

	function get_date($time = null)
	{
		return date('Y-m-d H:i:s', $time);
	}

	function get_url_host($https = false)
	{
                $hostUrl = 'http://';
                if (!empty($https) || (isset($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'on') == 0))
                {
                    $hostUrl = 'https://';
                }

		$hostname = $_SERVER['HTTP_HOST'];
		$hostparts = split("[.]", $hostname);
		if(count($hostparts) <= 2)
		{
			$hostname = "www.$hostname";
		}

		$hostUrl .= $hostname;
		return $hostUrl;
	}

	function get_url($query_string = '') # Something a bit more sane.
	{
		$hostUrl = $this->get_url_host();
	
		$pageUrl = $hostUrl . "/" . $this->params['url']['url'];
		if ($query_string)
		{
			$pageUrl .= "?$query_string";
		}

		return $pageUrl;
	}

	function get_url_raw($query_string = '') # Nasty since does /app/webroot shit,etc... might even be wrong.
	{
		$serverName = $_SERVER['SERVER_NAME'];
                $serverPort = $_SERVER['SERVER_PORT'];

                $pathParts = pathinfo($_SERVER['SCRIPT_NAME']);
                $pathInfo = $pathParts['dirname'];

                $pageUrl = 'http://';
                if (isset($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'on') == 0)
                {
                    $pageUrl = 'https://';
                }

                $pageUrl .= $serverName . ($serverPort != 80 ? ':' . $serverPort : '');
                $pageUrl .= $pathInfo;
                $pageUrl .= '/' . $_SERVER['SCRIPT_NAME'];

		if (isset($query_string))
		{
			$_SERVER['QUERY_STRING'] .= "&" . $query_string;
		}

                if (!empty($_SERVER['QUERY_STRING']))
                {
                    $pageUrl .= '?' . $_SERVER['QUERY_STRING'];
                }


		return $pageUrl;
	}

	function tm_media_view($params)
	{
		App::import('View', 'Media');

		$viewClass = "MediaView";
		$mediaObj =& new $viewClass($this);

		# may already be abs path.
		$filename = ((substr($params['path'],0,1) != "/") ? APP : "") . $params['path'] . $params['id'];
		if (!file_exists($filename))
		{
			$this->redirect('/pages/404');
		}
		$file = fopen($filename, 'r');
		
		# Print header
		$mimeType = 'application/octet-stream'; 
		if (!$params['download']) { $mimeType = $mediaObj->mimeType[ $params['extension'] ]; }

		$size = filesize($filename);

		$cachetime = 60*60; # 1 hour.

		$modified_time = filemtime($filename);
		$modified = gmdate('D, d M Y H:i:s', $modified_time) . ' GMT';

		header("Content-Type: $mimeType");
		header("Length: $size");
		header("Cache-Control: max-age=$cachetime, must-revalidate");
		header("Last-Modified: $modified");

		# read content, print
		$fileData = fread($file, $size);
		echo $fileData;

		fclose($file);


		exit(0);
	}

	function get_cart($cart_item_id = null)
	{
		if(!empty($cart_item_id))
		{
			return $this->CartItem->findAll("CartItem.cart_item_id = '$cart_item_id'"); 
		}

		$session_id = $this->get_session_id();
		$customer_id = $this->get_customer_id();
		$db_cart_items = $this->CartItem->findAll("(CartItem.customer_id = '$customer_id' OR CartItem.session_id = '$session_id') AND CartItem.productCode != '' AND CartItem.productCode IS NOT NULL", null, "CartItem.cart_item_id DESC");
		#$db_cart_items = $this->CartItem->findAll("CartItem.session_id = '$session_id' AND CartItem.productCode != '' AND CartItem.productCode IS NOT NULL", null, "CartItem.cart_item_id DESC");
		return $db_cart_items;
	}

	function redirect_referer($alt = '/') # Go back to previous page OR to alt page if referer not set.
	{
		$url = $_SERVER["HTTP_REFERER"];
		if (!$url) { $url = $alt; }
		$this->redirect($url);
	}

	function close_session_by_member_id($id = '')
	{
		if (!$id) { return false; }
		$this->Member->recursive = -1;
		$member = $this->Member->read(null, $id);
		$session_id = $member['Member']['session_id'];
		if ($session_id != '')
		{
			$this->MemberSessions->del($session_id);
		}
	}

	function pluralize($string, $ucwords = false)
	{
		$string = preg_replace("/^\s*(.*)\s*$/", '$1', $string);
		$inflect = new Inflector();
		$plural = $inflect->pluralize($string);
		return $ucwords ? ucwords($plural) : $plural;
	}

	function admin_sort_index() # Make a universal one so can sort arbitrarily on new objects with 'sort_index' field.
	/* view looks like:
		<table>
		<tr> <th>heading</th> </tr> (no id field)
		<tbody id="MODELS">
		<tr id="MODEL_pid">
			<td> <img class="sort_handle" src="/images/icons/up-down.png"/> </td>
		</tr>
		</tbody>
		</table>
		<?= $ajax->sortable("MODELS", array('tag'=>'tr','url'=>'/admin/CONTROLLER/sort_index', 'handle'=>'sort_handle')); ?>
	*/
	{
		$this->layout = 'ajax';
		$order = $this->params['form'][$this->params['controller']];
		if($order && count($order))
		{
			foreach ($order as $index => $id)
			{
				$this->{$this->modelClass}->id = $id;
				$this->{$this->modelClass}->saveField('sort_index', $index);
			}
		}
		header("Content-Type: text/plain");
		echo "OK";
		exit(0);
	}

	function cleanIntlChars($text)
	{
		$normalizeChars = 
			array(
			    'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
			    'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
			    'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
			    'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
			    'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
			    'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
			    'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f'
			);

		return strtr($text, $normalizeChars);
	}

	function get_model($name)
	{
		$model = ClassRegistry::init($name);
		return $model;
	}

	function get_config_value($name)
	{
		$config = $this->get_model("Config");
		$entry = $config->find("name = '$name' ");
		return !empty($entry) ? $entry['Config']['value'] : null;
	}

	function getCustomerProfileId() # Create one if needed.
	{
		$profile_id = $this->Session->read("Auth.Customer.profile_id"); # Read profile id now, in case we logged in mid-point.
		$profile_id = $this->Cim->valid_profile($profile_id);
		# Failsafe. Respond to possibility of them not having what we have already, such as if got erased, etc. (will clear ID so we can create later)

		$customer_id = $this->Auth->user("customer_id");
		$email = $this->Auth->user("eMail_Address");
		$name = $this->Auth->user("First_Name") . ' ' . $this->Auth->user("Last_Name");
	
		if(empty($profile_id)) # Create a new profile.
		{
			if(!($profile_id = $this->Cim->create_profile($customer_id, $email, $name)))
			{
				$this->flashError("Could not create your billing profile. ".$this->Cim->error.$this->Cim->raw(),true);#.$this->Cim->debug());
				return;
			}
	
			# Save to customer IF account.
			if($customer_id)
			{
				$this->Customer->id = $customer_id;
				$this->Customer->saveField("profile_id", $profile_id);
				$this->Session->write("Auth.Customer.profile_id", $profile_id); # Fail safe, in case of new customer and checkout takes a few attempts in the middle.
			}
		}

		return $profile_id;
	}

	function getCustomerProfile($profile_id = null)
	{
		if(empty($profile_id))
		{
			$profile_id = $this->getCustomerProfileId();
		}
		$profile = $this->Cim->get_profile($profile_id);
		#error_log("RETURNING PROFIEL=".print_r($profile,true));
		return $profile;
	}

	function getCustomerPaymentProfileId()
	{
		$profile_id = $this->Session->read("Auth.Customer.profile_id"); # Read profile id now, in case we logged in mid-point.
		$payment_profile_id = $this->Session->read("Auth.Customer.payment_profile_id"); # Read profile id now, in case we logged in mid-point.
		$payment_profile_id = $this->Cim->valid_payment_profile($profile_id, $payment_profile_id); # Don't return a numberi f it's invalid
		return $payment_profile_id;
	}

	function updateCustomerPaymentCard($profile_id, $billinfo, $cardinfo) # ...
	{
		$customer_id = $this->get_customer_id();

		$existing_card = $this->getCustomerPaymentProfile($profile_id);

		#error_log("UPDATE PAYCARD, CARD=".print_r($existing_card,true));

		# Delete all existing cards, so no chance we add duplicate we lose ID for.
		if(!empty($existing_card->customerPaymentProfileId))
		{
			$card_id = $existing_card->customerPaymentProfileId;
			$this->Cim->delete_payment_profile($profile_id, $card_id);
		}
		$payment_profile_id = null; # Erase, start over.

		#$billName = !empty($billinfo['Name']) ? $billinfo['Name'] : !empty($billinfo['In_Care_Of']) ? split(" ", $billinfo['In_Care_Of']) : (!empty($cardinfo['Cardholder']) ? split(" ", $cardinfo['Cardholder']) : array($customer['First_Name'],$customer['Last_Name']));
		$billName = !empty($cardinfo['Cardholder']) ? split(" ", $cardinfo['Cardholder']) : array($customer['First_Name'],$customer['Last_Name']);
		$billFirst = !empty($billName[0]) ? $billName[0] : null;
		$billLast = !empty($billName[count($billName)-1]) ? $billName[count($billName)-1] : null;
		# Create credit card.... XXX TODO
		#error_log("CARD=".print_r($cardinfo,true));
		$exp = sprintf("%02u-%02u", $cardinfo['Expiration']['year'], $cardinfo['Expiration']['month']);
		$card = $cardinfo['NumberPlain'];
		$cardLast4 = substr($card, -4);
		$cardType = $this->CreditCard->get_card_type($card);

		$billing = array(
			'first_name'=>$billFirst,
			'last_name'=>$billLast,
			'address'=>join(", ", 
				array($billinfo['Address_1'], $billinfo['Address_2'])),
			'city'=>$billinfo['City'],
			'state'=>$billinfo['State'],
			'zip'=>$billinfo['Zip_Code'],
			'country'=>$billinfo['Country'],
		);

		if(!empty($payment_profile_id)) # Update.
		{
			if(!($payment_profile_id = $this->Cim->update_payment_profile($profile_id, $payment_profile_id, $card, $exp, $billing)))
			{
				$this->flashError("Could not complete your order. ".$this->Cim->error.$this->Cim->raw(), true);#.$this->Cim->debug());
				return false;
			}
		} else { # add
			#error_log(", CREATING PAYMENT PROFILE = $profile_id, $card, $exp");
			if(!($payment_profile_id = $this->Cim->create_payment_profile($profile_id, $card, $exp, $billing)))
			{
				$this->flashError("Could not complete your order. ".$this->Cim->error.$this->Cim->raw(), true);#.$this->Cim->debug());
				return false;
			}
		}
		# Save to customer IF account.
		if(!empty($customer_id))
		{
			$this->Customer->id = $customer_id;
			$this->Customer->saveField("payment_profile_id", $payment_profile_id);
			$this->Customer->saveField("cardType", $cardType);
			$this->Session->write("Auth.Customer.payment_profile_id", $payment_profile_id);
		}

		return true;

	}

	function getCustomerPaymentProfile($profile = null)
	{
		if(is_numeric($profile))
		{
			$profile = $this->getCustomerProfile($profile);
		} else if(empty($profile)) {
			$profile = $this->getCustomerProfile();
		}
		#error_log("CUSTOMER PROFILE (object?)=".print_r($profile,true));
		if(empty($profile))
		{
			error_log("INVALID CUSTOMER PROFILE");
			return null;
		}
		$paymentProfiles = $profile->xpath("paymentProfiles");
		$paymentProfile = !empty($paymentProfiles) ? $paymentProfiles[0] : null;
		#return $this->simplexml_to_array($paymentProfile);
		return $paymentProfile;
	}

	function simplexml_to_array($xmlobj) {
	    $a = array();
	    foreach ($xmlobj->children() as $node) {
	        if (is_array($node))
	            $a[$node->getName()] = $this->simplexml_to_array($node);
	        else
	            $a[$node->getName()] = (string) $node;
	    }
	    return $a;
	}


	function load_variables_step($step)
	{

		$method = "load_variables_$step";
		$prodname = $this->build['Product']['prod'];
		$product_method = "load_variables_{$prodname}_{$step}";
		# Just in case we need bookmark_charm() to process bookmark specific stuff...
		if (method_exists($this, $product_method))
		{
			$this->$product_method();
		}
		else if (method_exists($this, $method))
		{
			$this->$method();
		}

		$this->set("script_template", "build");

	}

	function load_variables_tassel()
	{
		$tassel = array();
		$result = mysql_query ("Select * from tassel where available='yes' order by color_name", $this->database);
		while ( $temp = mysql_fetch_object($result) ) {
			$tassels[] = $temp;
		}
		$this->set("tassels", $tassels);
		return $tassels;
	}

	function load_variables_border()
	{
		$borders = array();
		$result = mysql_query ("Select * from border where available='yes' order by name", $this->database);
		while ( $temp = mysql_fetch_object($result) ) {
			$borders[] = $temp;
		}
		$this->set("borders", $borders);
		return $borders;
	}

	function load_variables_charm()
	{
		$charms = array();
		$result = mysql_query ("Select * from charm where available='yes' order by name", $this->database);
		while ( $temp = mysql_fetch_object($result) ) {
			$charms[] = $temp;
		}
		$this->set("charms", $charms);
		return $charms;
	}

	function load_variables_ribbon()
	{
		$ribbons = array();
		$result = mysql_query ("Select * from ribbon where available='yes' order by color_name", $this->database);
		while ( $temp = mysql_fetch_object($result) ) {
			$ribbons[] = $temp;
		}
		$this->set("ribbons", $ribbons);
		return $ribbons;
	}

	function load_variables_frame()
	{
		$frames = array();
		$result = mysql_query ("Select * from frame where available='yes' order by sort_index,name", $this->database);
		while ( $temp = mysql_fetch_object($result) ) {
			$frames[] = $temp;
		}
		$this->set("frames", $frames);
		return $frames;
	}

	function load_product_quotes()
	{
		# Set quotes for product.
		$product_id = $this->build['Product']['product_type_id'];
		$product_quotes = $this->ProductQuote->findAll(" ProductQuote.product_type_id = '$product_id' ");
		$this->set("productQuotes", $product_quotes);
	}

	function load_variables_background()
	{
		Configure::load("background_colors");
		$this->set("backgrounds", Configure::read("BackgroundColors"));
	}

	function load_variables_quote()
	{
		$this->load_product_quotes();

		$catalogNumber = !empty($this->build['GalleryImage']['catalog_number']) ? $this->build['GalleryImage']['catalog_number'] : null;
		if ($catalogNumber)
		{
			$this->load_recommended_quotes($catalogNumber);
		}


		$quoteLength = 0;
		$quoteText = "";
		$quoteAttribution = "";

		if (isset($_REQUEST['selectedQuote']))
		{
			$selectedQuote = $_REQUEST['selectedQuote'];

			$result = mysql_query ("Select text, text_length, attribution from quote where quote_id = '$selectedQuote'", $this->database);
			if(mysql_num_rows($result)>0)
			{
				while($temp = mysql_fetch_object($result))
				{
					$quoteText = $temp->text;
					$quoteLength = $temp->text_length;
					$quoteAttribution = $temp->attribution;
				}
			}
			if ($quoteAttribution != "")
			{
				$quoteText = $quoteText . "\n - " . $quoteAttribution;
			}
		}

		$this->set("quoteText", preg_replace('/\<br(\s*)?\/?\>/i', "\n", $quoteText));
		$this->set("quoteLength", $quoteLength);
		
	}
	function load_variables_layout()
	{
		$cropdata = $this->get_crop_data();
		$this->set("cropdata", $cropdata);
	}

	function load_cart_data($cart_items)
	{
		#echo "X=".print_r($cart_items,true);
		$shoppingCart = array();
		$product_list = array();
		$subtotal = $eligible_subtotal = 0;
		$proofcost = !empty($this->config['proof_cost']) ? $this->config['proof_cost'] : 25; # Default.

		foreach($cart_items as $cart_item)
		{
			$cartItem = array();
			$parts = array();
			$parts2 = array();
			if (is_object($cart_item))
			{
				$cartItem = get_object_vars($cart_item);
				$parts = get_object_vars($cart_item->parts);
				$parts2 = get_object_vars($cart_item->parts2);
			} else if (!empty($cart_item['CartItem'])) { 
				$cartItem = $cart_item['CartItem'];
				$parts = unserialize($cart_item['CartItem']['parts']);
				$parts2 = unserialize($cart_item['CartItem']['parts2']);
			}
			$cartItem['parts'] = $parts;
			$cartItem['parts2'] = $parts2;



			# Get options cost, for breakdown. (ie printing on back, etc)
			$options = array_merge($cartItem, $parts);
			if(!empty($parts2)) { $options['printing_back'] = 1; }

			# charmID, printing_back, etc should match.
			$cartItem['options_cost'] = $this->Product->get_options_cost($cartItem['productCode'], $cartItem['quantity'], $options);
			#error_log("OPTIONS_COST=".print_r($cartItem['options_cost'],true));



			$imageID = !empty($cartItem['parts']['customImageID']) ? $cartItem['parts']['customImageID'] : null;
			$catalogNumber = !empty($cartItem['parts']['catalogNumber']) ? $cartItem['parts']['catalogNumber'] : null;
			$galleryImage = $catalogNumber ? $this->GalleryImage->find("GalleryImage.catalog_number = '$catalogNumber'") : null;
			$cartItem['GalleryImage'] = $galleryImage ? $galleryImage['GalleryImage'] : null;
			$productCode = $cartItem['productCode'];
			if ($productCode == 'B' && !empty($cartItem['parts']['charmID']) && $cartItem['parts']['charmID'] != 'None' && $cartItem['parts']['charmID'] != -1)
			{
				$productCode = 'BC';
			}
			if ($productCode == 'B' && (empty($cartItem['parts']['tasselID']) || $cartItem['parts']['tasselID'] == 'None' || $cartItem['parts']['tasselID'] == -1))
			{
				$productCode = 'BNT';
			}
			$product = $this->Product->find("code = '$productCode'");
			$cartItem['Product'] = $product['Product'];
			$customImage = $imageID ? $this->CustomImage->find("Image_ID = '$imageID'") : null;
			$cartItem['CustomImage'] = $customImage ? $customImage['CustomImage'] : null;

			if(empty($cartItem['proof']) || $cartItem['proof'] !== 'only')
			{
				$subtotal += $cartItem['quantity'] * $cartItem['unitPrice'];
				if(!empty($product['Product']['free_shipping']))
				{
					$eligible_subtotal += $cartItem['quantity'] * $cartItem['unitPrice'];
				}
			} else {
				$subtotal += $proof_cost;
				if(!empty($product['Product']['free_shipping']))
				{
					$eligible_subtotal += $proof_cost;
				}
			}
			if(!empty($cartItem['setupPrice']))
			{
				$subtotal += $cartItem['setupPrice'];
				if(!empty($product['Product']['free_shipping']))
				{
					$eligible_subtotal += $cartItem['setupPrice'];
				}
			}


			if(empty($product_list[$product['Product']['code']])) { $product_list[$product['Product']['code']] = 0; }
			$product_list[$product['Product']['code']] += $cartItem['quantity'];

			# LOAD OTHER STUFF
			# Load quote if there...
			$cartItem['parts']['meta'] = $partsInfo = $this->load_parts_info($cartItem['parts']);
			if(!empty($cartItem['parts2']))
			{
				$cartItem['parts2']['meta'] = $this->load_parts_info($cartItem['parts2']);
			}

			# Keep old merge there for compat.
			$shoppingCart[] = array_merge($cartItem, $partsInfo);
		}
		return array($shoppingCart, $subtotal, $product_list, $eligible_subtotal);
	}

	function load_parts_info($parts)
	{
		if(empty($parts)) { return array(); } # ie blank 2nd side, etc.

		$info = array();
		if (isset($parts['quoteID'])) {
			$quote = $this->Quote->read(null, $parts['quoteID']);
			$info['quote_info'] = $quote['Quote'];
		}

		if (isset($parts['customTassel'])) {
			$tassel = $this->Tassel->read(null, $parts['customTassel']);
			$info['tassel_info'] = $tassel['Tassel'];
		} else if (isset($parts['tasselID'])) {
			$tassel = $this->Tassel->read(null, $parts['tasselID']);
			$info['tassel_info'] = $tassel['Tassel'];
		}

		if (isset($parts['customRibbon'])) {
			$ribbon = $this->Ribbon->read(null, $parts['customRibbon']);
			$info['ribbon_info'] = $ribbon['Ribbon'];
		} else if (isset($parts['ribbonID'])) {
			$ribbon = $this->Ribbon->read(null, $parts['ribbonID']);
			$info['ribbon_info'] = $ribbon['Ribbon'];
		}

		if (isset($parts['customCharm'])) {
			$charm = $this->Charm->read(null, $parts['customCharm']);
			$info['charm_info'] = $charm['Charm'];
		} else if (isset($parts['charmID'])) {
			$charm = $this->Charm->read(null, $parts['charmID']);
			$info['charm_info'] = $charm['Charm'];
		}

		if (isset($parts['customBorder'])) {
			$border = $this->Border->read(null, $parts['customBorder']);
			$info['border_info'] = $border['Border'];
		} else if (isset($parts['borderID'])) {
			$border = $this->Border->read(null, $parts['borderID']);
			$info['border_info'] = $border['Border'];
		}

		if (isset($parts['frameID'])) {
			$frame = $this->Frame->read(null, $parts['frameID']);
			$info['frame_info'] = $frame['Frame'];
		}

		return $info;
	}

	function load_recommended_quotes($catalogNumber)
	{
		$maxLength = $this->build['Product']['quote_limit'];
		$this->RecommendedQuote->recursive = -1;

		$stamp = $this->GalleryImage->find("GalleryImage.catalog_number = '$catalogNumber' ");

		$stampID = $stamp['GalleryImage']['stampID'];

		#$recommended = $catalogNumber != "" ? $this->RecommendedQuote->findAll("RecommendedQuote.Catalog_Number = '$catalogNumber'") : array();
		$recommended = $stampID != "" ? $this->RecommendedQuote->findAll("RecommendedQuote.stamp_id = '$stampID'") : array();
		$quote_id = array();
		foreach($recommended as $rec)
		{
			$quote_id[] = $rec['RecommendedQuote']['Quote_ID'];
		}
		$quote_id_csv = join(",", $quote_id);
		$recommendedQuotes = $quote_id_csv ? $this->Quote->findAll(" Quote.quote_id IN ($quote_id_csv) AND LENGTH(Quote.text)+LENGTH(Quote.attribution) <= '$maxLength'") : null;
		$this->set("recommendedQuotes", $recommendedQuotes);
	}

	function json_set($k,$v)
	{
		$this->jsonResponse[$k] = $v;
	}

	function json_render()
	{
		header("Content-Type: application/json");
		echo json_encode($this->jsonResponse);
		exit(0);
		
	}

	function setFlash($msg, $level = 'default', $params=array(), $key = 'flash') # Can be overwritten by controller, to do extra logging.
	{
	#	error_log("FL=$msg, $level");
		return $this->Session->setFlash($msg, $level,$params,$key);
	}

	function flashError($msg, $email = false) # Bad error to notify info@hd with.
	{
		$this->setFlash($msg, 'warn'); 

		if($email)
		{
			$vars = array(
				'msg'=>$msg,
				'data'=>$this->data,
				'sessinfo'=>$this->Session->read(),
				'url'=>$_SERVER['REQUEST_URI']
			);
	
			$this->sendAdminEmail("Harmony Designs User Error", "user_error", $vars);
		}
	}
	

}
?>
