<?php
/* SVN FILE: $Id: ajax.ctp 7945 2008-12-19 02:16:01Z gwoo $ */
/**
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
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>
<!--
# SETTING THIS AGAIN WILL CAUSE CUSTOMIZATIONS TO jquery functions, ie j.fn.formerror, to disappear
<script src="/js/jquery-1.7.1.js"></script>
<script src="/js/jquery.form.js"></script>
-->
<script type="text/javascript" language="javascript">
	// iframes (file uploads) do not have access to jquery, since its another window
	
	//console.log(window.parent);
	//console.log(window.parent.jQuery);
	//console.log("TRYING");
	
	if(window.parent && typeof jQuery == 'undefined' 
	&& typeof window.parent.jQuery != 'undefined') {
		 window.j = window.jQuery = window.parent.jQuery; 
	}
</script>
<? $this->Js->JqueryEngine->jQueryObject = 'j'; # This may need to be placed on individual views, since we need to know this before view gets rendered.... ?>
<?php echo $session->flash('auth'); ?>
<?php echo $session->flash(); ?>
<?php echo $content_for_layout; ?>
<?php echo $this->Js->writeBuffer(); ?>
