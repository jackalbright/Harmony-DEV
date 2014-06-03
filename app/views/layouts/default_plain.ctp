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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php #__('CakePHP: the rapid development php framework:'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<link rel="Stylesheet" href="/stylesheets/autoload.php" type="text/css" media="all" />
	<meta name="description" content="<?= isset($meta_description) ? $meta_description : ""; ?>"/>
	<meta name="keywords" content="<?= isset($meta_keywords) ? (is_array($meta_keywords) ? join(", ", $meta_keywords) : $meta_keywords) : ""; ?>"/>

	<script src="/js/jquery-1.7.1.js"></script>
	<script>
		var j = jQuery.noConflict();
	</script>
	<script src="/js/util.js"></script>
	<script src="/js/jquery.scrollTo.js"></script>
	<script src="/js/jquery.form.js"></script>
	<script src="/js/jquery-ui.js"></script>
	<link rel="Stylesheet" href="/css/cupertino/jquery-ui.css"/>

	<?
		echo $javascript->link('harmonydesigns.js', true);
		echo $javascript->link('scriptaculous/prototype.js', true);
		#echo $javascript->link('prototype.js', true);
		echo $javascript->link('scriptaculous/scriptaculous.js', true);
		#echo $javascript->link('cropper/cropper.uncompressed.js', true);
		#echo $javascript->link('lightbox.js', true);
		#echo $javascript->link('lightbox.js', true);
		#echo $javascript->link('shadowbox-2.0.js', true);
		#echo $javascript->link('spica.js', true);
        #echo $javascript->link('shadowbox/src/adapter/shadowbox-base.js', true);
        #echo $javascript->link('shadowbox/src/adapter/shadowbox-prototype.js', true);
        #echo $javascript->link('shadowbox/src/shadowbox.js', true);
        #echo $javascript->link('lightbox.js', true);
        echo $javascript->link('shadowbox/shadowbox.js', true);

        #echo $javascript->codeBlock('Shadowbox.loadSkin("classic", "/js/shadowbox/src/skin");');
        #echo $javascript->codeBlock('Shadowbox.loadLanguage("en", "/js/shadowbox/src/lang");');
        #echo $javascript->codeBlock('Shadowbox.loadPlayer(["img","html","iframe"], "/js/shadowbox/src/player");');

	?>
	<link rel="stylesheet" type="text/css" href="/js/shadowbox/shadowbox.css"/>
	<script src="/js/spin.js"></script>

	<?php
		echo $scripts_for_layout;
	?>

	<? if(!empty($scripts)) { foreach($scripts as $script) { ?>
		<script src="<?=$script?>"></script>
	<? } } ?>

	<? if(!empty($styles)) { foreach($styles as $style) { ?>
		<link rel="stylesheet" type="text/css" href="<?=$style?>"/>
	<? } } ?>
	<link rel="stylesheet" type="text/css" href="/css/lightbox.css"/>

	<? if(!empty($script_template)) { ?>
	<!-- script tags are IN the files... -->
		<? if (is_array($script_template)) { ?>
			<? foreach($script_template as $template) { ?>
				<?= $this->element("js/".$template); ?>
			<? } ?>
		<? } else { ?>
			<?= $this->element("js/".$script_template); ?>
		<? } ?>
	<? } ?>

	<script>
        Shadowbox.init({overlayOpacity: 0.5, continuous: true, resizeDuration: 0.3, fadeDuration: 0.2, players: ['html','img','iframe']});
	function onLoad()
	{
		<? foreach ($javascript_sets as $field => $value) { ?>
			var field = $('<?= $field ?>');
			field.setValue('<?= $value ?>');
		<? } ?>
        	//Shadowbox.init({overlayOpacity: 0.5, continuous: true, resizeDuration: 0.3, fadeDuration: 0.2});
	}
	</script>
	<style>
	label
	{
		font-size: 13px !important;
	}
	p, div
	{
		font-size: 12px;
	}
	</style>


</head>
<body onLoad="onLoad();" style="background-color: white !important; font-size: 10px;">
	<? if(!empty($body_title)) { ?>
		<h1><?= $body_title ?></h1>
	<? } ?>
	<?php $session->flash(); ?>

	<?php echo $content_for_layout; ?>

	<? if(!empty($malysoft)) { ?>
		<?= $this->element("sql_dump"); ?>
	<? } ?>
</body>
</html>
