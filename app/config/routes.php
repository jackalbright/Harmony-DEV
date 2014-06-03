<?php
/* SVN FILE: $Id: routes.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
Router::parseExtensions("json");

	Router::connect('/', array('controller' => 'products', 'action' => 'index'));

	Router::connect('/about', array('controller' => 'pages', 'action' => 'display', 'about_us'));
	Router::connect('/services', array('controller' => 'pages', 'action' => 'display', 'design_services'));
	Router::connect('/guarantee', array('controller' => 'pages', 'action' => 'display', 'guarantee'));
	Router::connect('/security', array('controller' => 'pages', 'action' => 'display', 'security'));
	Router::connect('/privacy', array('controller' => 'pages', 'action' => 'display', 'privacy'));

	Router::connect('/index.php', array('controller' => 'products', 'action' => 'index'));
	Router::connect('/work3', array('controller' => 'work_requests', 'action' => 'add','nodetails'));
	Router::connect('/work2', array('controller' => 'work_requests', 'action' => 'add','noart'));
	Router::connect('/work', array('controller' => 'work_requests', 'action' => 'add'));
	Router::connect('/workrequest/*', array('controller' => 'work_requests', 'action' => 'add'));
	Router::connect('/product/build.php', array('controller' => 'build', 'action' => 'customize'));
	###Router::connect('/info/contact_us.php', array('controller' => 'static', 'action' => 'contact'));
	Router::connect('/info/contact_us.php', array('controller' => 'contact_requests', 'action' => 'add'));
	Router::connect('/contact', array('controller' => 'contact_requests', 'action' => 'add'));
	Router::connect('/contact/thanks', array('controller' => 'contact_requests', 'action' => 'thanks'));
	Router::connect('/info/faq.php', array('controller' => 'faqs', 'action' => 'index'));
	Router::connect('/info/testimonials.php', array('controller' => 'testimonials', 'action' => 'index'));
	Router::connect('/info/quantityPricing.php', array('controller' => 'products', 'action' => 'quantityPricing'));
	Router::connect('/info/reseller_pricing.php', array('controller' => 'products', 'action' => 'wholesale_pricing'));
	Router::connect('/newcart/:action', array('controller' => 'cart'));

	Router::connect('/images/blanks/*', array('controller' => 'product_image', 'action' => 'blank'));
	Router::connect('/images/preview/*', array('controller' => 'product_image', 'action' => 'view'));
	Router::connect('/images/galleries/cached/*', array('controller' => 'product_image', 'action' => 'view_gallery'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */

	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'view'));
	Router::connect('/customers/*', array('controller' => 'account'));
	Router::connect('/admin/customers', array('controller' => 'account','admin'=>true,'action'=>'index'));
	Router::connect('/admin', array('controller' => 'admin_dashboard', 'action' => 'index', 'admin'=>true));

	Router::connect('/details/', array('controller' => 'products', 'action' => 'index'));
	Router::connect('/details/index.php', array('controller' => 'products', 'action' => 'index'));
	Router::connect('/details/*', array('controller' => 'products', 'action' => 'view'));
	Router::connect('/specialties/*', array('controller' => 'specialty_pages', 'action' => 'view'));
	Router::connect('/promo/*', array('controller' => 'promo_pages', 'action' => 'view'));
	#Router::connect('/account/*', array('controller' => 'customers'));
	Router::connect('/orders', array('controller' => 'purchases'));

	Router::connect('/design', array('controller' => 'designs','action'=>'add'));
	Router::connect('/design/clear', array('controller' => 'designs','action'=>'clear'));
	Router::connect('/design/edit/*', array('controller' => 'designs','action'=>'edit'));
	Router::connect('/design/reset', array('controller' => 'designs','action'=>'reset'));
	Router::connect('/design/review', array('controller' => 'designs','action'=>'review'));
	Router::connect('/design/svg', array('controller' => 'designs','action'=>'svg'));
	Router::connect('/design/svg/*', array('controller' => 'designs','action'=>'svg'));
	Router::connect('/design/png', array('controller' => 'designs','action'=>'png'));
	Router::connect('/design/png/*', array('controller' => 'designs','action'=>'png'));
	Router::connect('/design/dump', array('controller' => 'designs','action'=>'dump'));
	Router::connect('/design/debug', array('controller' => 'designs','action'=>'dump'));
?>
