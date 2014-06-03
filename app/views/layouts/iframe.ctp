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
<html xmlns="http://www.w3.org/1999/xhtml" class="iframe">
<head>
	<?php echo $html->charset(); ?>
	<!--<base href="http://www.harmonydesigns.com"/>-->
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<link rel="Stylesheet" href="/stylesheets/autoload.php" type="text/css" media="all" />
	<link rel="Stylesheet" href="/js/starbox/css/starbox.css" type="text/css" media="all" />
	<meta name="description" content="<?= isset($meta_description) ? $meta_description : ""; ?>"/>
	<meta name="keywords" content="<?= isset($meta_keywords) ? (is_array($meta_keywords) ? join(", ", $meta_keywords) : $meta_keywords) : ""; ?>"/>
	<?
		echo $javascript->link('harmonydesigns.js', true);
		echo $javascript->link('scriptaculous/prototype.js', true);
		echo $javascript->link('fixed.js', true);
		echo $javascript->link('starbox/js/starbox.js', true);
		echo $javascript->link('ajaxupload.js', true);
		#echo $javascript->link('prototype.js', true);
		echo $javascript->link("spin.js", true);
		echo $javascript->link('scriptaculous/scriptaculous.js', true);
		echo $javascript->link('cropper/cropper.uncompressed.js', true);
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

	<?php
		echo $scripts_for_layout;
	?>

	<? if(!empty($scripts)) { foreach($scripts as $script) { ?>
		<script src="<?=$script?>"></script>
	<? } } ?>

	<? if(!empty($styles)) { foreach($styles as $style) { ?>
		<link rel="stylesheet" type="text/css" href="<?=$style?>"/>
	<? } } ?>
	<link rel="stylesheet" type="text/css" href="/js/shadowbox/shadowbox.css"/>

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
	// Shadowbox.init no longer properly works in onLoad()....
        Shadowbox.init({overlayOpacity: 0.5, continuous: true, resizeDuration: 0.3, fadeDuration: 0.2, players: ['html','img','iframe']});

	function onUnload()
	{
		hidePleaseWait();
	}

	function onLoad()
	{
	      document.onkeypress = stopRKey; 

		<? foreach ($javascript_sets as $field => $value) { ?>
			var field = $('<?= $field ?>');
			field.setValue('<?= $value ?>');
		<? } ?>
        	//Shadowbox.init({players: ['html','img','iframe']});

		var diagrams = document.getElementsByClassName("diagram");
		if (diagrams.length)
		{
			for(var i = 0; i < diagrams.length; i++)
			{
				Shadowbox.setup(diagrams[i].getElementsByTagName('area'), {width: 600, height: 500 });
			}
		}
	}

	function stopRKey(evt) {
		var evt = (evt) ? evt : ((event) ? event : null);
		var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
		if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
	}


	function verifyRequiredFields()
	{
		<? if (!empty($required_script)) { 
			foreach($required_script as $rs) { 
				echo $rs;
			}
		}
		?>

		<? if (!empty($required_functions)) { 
			foreach($required_functions as $func) { 
				?>
					if (!<?=$func?>()) { return false; }
				<?
			}
		} ?>

		<? if (!empty($required_conditions)) { ?>
		if (!(<?= $required_conditions ?>)) // When we SHOULD check conditions
		{
			return true; // Bypass checking since not required....
		}
		<? } ?>
		<? foreach ($required_fields as $rvid) { ?>
		var field = $('<?= $rvid ?>');
		if (field && !field.value)
		{
			var label = $$('label[for=<?= $rvid ?>]').first();
			if (!label) { label = '<?= $rvid ?>'; }
			if(label.innerHTML) { label = label.innerHTML; }
			alert("Missing information for " + label);
			field.focus();
			return false;
		}
		<? } ?>

		<? foreach ($required_fields_if as $cond => $rvid_list) { ?>
			if (<?= $cond ?>)
			{
				<? foreach($rvid_list as $rvid) { ?>
					var field = $('<?= $rvid ?>');
					if (field && !field.value)
					{
						var label = $$('label[for=<?= $rvid ?>]').first();
						if (!label) { label = '<?= $rvid ?>'; }
						if(label.innerHTML) { label = label.innerHTML; }
						alert("Missing information for " + label);
						field.focus();
						return false;
					}
				<? } ?>
			}
		<? } ?>


		return true;
	}

	</script>


</head>
<body onLoad="onLoad();" class="iframe relative" onUnload="return onUnload();" style="padding: 0px; margin: 0px; background-color: white;">
	<div>
		<?php $session->flash(); ?>
		<?php echo $content_for_layout; ?>
	</div>
</body>
</html>
