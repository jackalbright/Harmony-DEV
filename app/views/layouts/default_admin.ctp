<?php
/* SVN FILE: $Id: default.ctp 7945 2008-12-19 02:16:01Z gwoo $ */
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<link rel="Stylesheet" href="/css/cupertino/jquery-ui.css"/>
	<script src="/js/jquery-1.7.1.js"></script>
	<script src="/js/jquery.form.js"></script>
	<script src="/js/jquery.dateFormat.js"></script>
	<script src="/js/jquery-ui.js"></script>
	<script>
		var j = jQuery.noConflict();
	</script>
	<script src="/js/spin.js"></script>
	<script src="/js/harmonydesigns.js"></script>
	<script src="/js/util.js"></script>
	<link rel="stylesheet" type="text/css" href="/js/shadowbox/shadowbox.css"/>
	<?php
		echo $html->meta('icon');

		echo $html->css('cake.generic');
		echo '<link rel="Stylesheet" href="/stylesheets/autoload.php"/>';
		echo '<link rel="Stylesheet" href="/css/autoload.php"/>';

		echo $javascript->link('scriptaculous/prototype.js', true);
		echo $javascript->link('scriptaculous/scriptaculous.js', true);
		echo $javascript->link('swfobject.js', true);
		echo $javascript->link('harmonydesigns.js', true);
		echo $javascript->link('jquery.ajaxify.js', true);

        	echo $javascript->link('shadowbox/shadowbox.js', true);

		echo $javascript->link('tiny_mce/jquery.tinymce.js');

		?>
		<script type="text/javascript">

		(function($) {
			$.fn.rte = function() {
				j(this).each(function() {
					   j(this).tinymce({
						script_url: "/js/tiny_mce/tiny_mce_src.js",
			
					        theme : "advanced",
					        mode : "textareas",
						plugins: "table,inlinepopups",
						//dialog_type: 'modal',
						/*plugins: "table,paste",*/
						/*paste_text_sticky: true,*/
						theme_advanced_fonts: "Helvetica=helvetica;",

						theme_advanced_buttons1 : "formatselect,fontsizeselect,bold,italic,underline,strikethrough,sup,sub,removeformat",
						theme_advanced_buttons2 : "forecolor,forecolorpicker,bullist,numlist,link,unlink,anchor,image,sup,sub,charmap,code",
						theme_advanced_blockformats : "p,address,pre,h1,h2,h3,h4,h5,h6",
			
						setup: function(ed) {
							ed.onInit.add(function(ed) {
								/*ed.pasteAsPlainText = true;*/
							});
			
						},
			
						convert_fonts_to_spans: false,
						valid_styles : { '*' : 'color,font-size,font-weight,font-style,text-decoration' },
			
						preformatted : true,
					        convert_urls : false,
						force_p_newlines : false,
						/*force_br_newlines : true,*/
						/*convert_newlines_to_brs : true,*/
						/*remove_linebreaks: false,*/
						/*invalid_elements : 'span',*/
						/*paste_remove_spans: true,*/
						width: '100%',
					   });
				});

			};

		})(jQuery);

		j(document).ready(function() {
			j('textarea').not('.no_editor').rte();
		});

        		Shadowbox.init({overlayOpacity: 0.5, continuous: true, resizeDuration: 0.3, fadeDuration: 0.2, players: ['html','img','iframe'],adapter:'jquery'});
		</script> 
		<?



		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<?= $this->element("layout/admin/header", $this->viewVars); ?>
		</div><!--header-->
        <?= $this->element("layout/admin/menu", $this->viewVars); ?>
        <?php //include("/includes/admin_menu.php")?>
		<div id="content">
			<?= $this->element("layout/breadcrumbs"); ?>

			<?= $session->flash('auth'); ?>
			<?= $session->flash(); ?>

			<?php echo $content_for_layout; ?>

		</div><!--content-->
		<div id="footer">
			<?= $this->element("layout/admin/footer", $this->viewVars); ?>
		</div><!--footer-->
	</div><!--container-->
	<?php //echo !empty($malysoft) || !empty($_REQUEST['debug']) ? $this->element('sql_dump') : ''; ?>
</body>
</html>
