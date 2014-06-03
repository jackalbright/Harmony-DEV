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
<html xmlns="http://www.w3.org/1999/xhtml" style="background-color: #FFFFEE;">
<head>
	<?php echo $html->charset(); ?>
    <!-- cake version <?php echo Configure::version();?>-->
	<!--<base href="http://www.harmonydesigns.com"/>-->
	<title><?= !empty($page_title) ? $page_title : preg_replace("/\|\s*Harmony Designs.*/", "", $title_for_layout); ?> | Harmony Designs</title>
	<link rel="Stylesheet" href="/stylesheets/autoload.php" type="text/css" media="all" />
	<link rel="Stylesheet" href="/js/starbox/css/starbox.css" type="text/css" media="all" />
	<link rel="Stylesheet" href="/css/cupertino/jquery-ui.css"/>
   <!-- <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />-->
	<link rel="Stylesheet" href="/stylesheets/base2.css" type="text/css" media="all" />
	<!--
	<link rel="Stylesheet" href="/stylesheets/newLayout2.css" type="text/css" media="all" />
	-->
	<meta name="description" content="<?php echo isset($meta_description) ? $meta_description : ""; ?>"/>
	<meta name="keywords" content="<?php echo isset($meta_keywords) ? (is_array($meta_keywords) ? join(", ", $meta_keywords) : $meta_keywords) : ""; ?>"/>

	<script src="/js/jquery-1.7.1.js"></script>
    <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
	<script src="/js/jquery.color.js"></script>
	<script src="/js/jquery.ba-resize.js"></script>
	<script src="/js/jquery-ui.js"></script>
    
	<!--<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>-->
	<script src="/js/jquery.scrollTo.js"></script>
	<script src="/js/jquery.form.js"></script>
    <!--<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>-->
	<script src="/js/jquery.dateFormat.js"></script>
	<script src="/js/inflection.js"></script>
	<script src="/js/jquery.hashchange.js"></script>
	<script src="/js/spin.js"></script>
	<?php echo $javascript->link('tiny_mce/tiny_mce_src.js'); ?>
    <script type="text/javascript">
    var j = jQuery.noConflict();
	var dbg = false; 
    </script>


	<?php $this->Js->JqueryEngine->jQueryObject = 'j'; ?>

	<script src="/js/jquery.serializeObject.js"></script>
	<script src="/js/jquery.nearest.js"></script>

	<!--<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>-->
	<?php
		echo $javascript->link('scriptaculous/prototype.js', true);
		echo $javascript->link('scriptaculous/slider.js', true);
		echo $javascript->link('harmonydesigns.js', true);
		echo $javascript->link('util.js', true); # Other js stuff, jquery functions
		#echo $javascript->link('fixed.js', true);
		echo $javascript->link('starbox/js/starbox.js', true);
		echo $javascript->link('ajaxupload.js', true);
		#echo $javascript->link('prototype.js', true);
		if(!empty($scriptaculous))
		{
			echo $javascript->link('scriptaculous/scriptaculous.js', true);
		}

		if(!empty($cropper)) { 
			echo $javascript->link('scriptaculous/scriptaculous.js', true);
			#echo $javascript->link('cropper/cropper.uncompressed.js', true);
			echo $javascript->link('jcrop/jcrop.prototype.js',true);
		}

		#echo $javascript->link('lightbox.js', true);
		#echo $javascript->link('lightbox.js', true);
		#echo $javascript->link('shadowbox-2.0.js', true);
		#echo $javascript->link('spica.js', true);
        #echo $javascript->link('shadowbox/src/adapter/shadowbox-base.js', true);
        #echo $javascript->link('shadowbox/src/adapter/shadowbox-prototype.js', true);
        #echo $javascript->link('shadowbox/src/shadowbox.js', true);
        #echo $javascript->link('lightbox.js', true);
		if(true || !empty($shadowbox))
		{
        		echo $javascript->link('shadowbox/shadowbox.js', true);
        		echo $javascript->link('shadowbox/adapters/shadowbox-jquery.js', true); # Stupid delays/bugs. Causes S.lib undefined error, because slight delay.
		}

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

	<? if(!empty($cropper)) {  ?>
	<link rel="stylesheet" href="/css/jcrop.css" type="text/css" />
	<? } ?>

	<script src="/js/fancy_dropdown.js"></script>
	<link rel="stylesheet" href="/css/fancy_dropdown.css" type="text/css" />

	<script src="/js/fontSelector.js"></script>
	<link rel="stylesheet" href="/css/fontSelector.css" type="text/css" />

	<script src="/js/jquery.waitforimages.js"></script>
	<!--
	<script src="/js/jquery.thumbnailScroller.js"></script>
	<link rel="stylesheet" href="/css/jquery.thumbnailScroller.css" type="text/css" />
	-->
	<script src="/js/jcarousel/jquery.jcarousel.js"></script>
	<link rel="stylesheet" href="/css/jcarousel.css" type="text/css" />

	<script src="/js/spectrum.js"></script>
	<link rel="stylesheet" href="/css/spectrum.css" type="text/css" />

	<!--
	<link rel="stylesheet" href="/css/galleriffic/galleriffic-2.css" type="text/css" />
	-->

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
	<? if(!empty($livesite)) { ?>
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	<? } ?>

	window.borders = {};
	window.charms = {};
	window.tassels = {};

	<? if(true || !empty($shadowbox)) { ?>
	// Shadowbox.init no longer properly works in onLoad()....
        Shadowbox.init({overlayOpacity: 0.5, continuous: true, resizeDuration: 0.3, fadeDuration: 0.2, players: ['html','img','iframe'], adapter: 'jquery'});
	<? } ?>

	function onUnload()
	{
		hidePleaseWait();
	}

	function onLoad()
	{
	      //document.onkeypress = stopRKey; 
	      // Not letting them press return will just annoy people trying to search.

		<? foreach ($javascript_sets as $field => $value) { ?>
			var field = $('<?= $field ?>');
			field.setValue('<?= $value ?>');
		<? } ?>
        	//Shadowbox.init({players: ['html','img','iframe']});

		<? if(false && !empty($shadowbox)) { ?>

		var diagrams = document.getElementsByClassName("diagram");
		if (diagrams && diagrams.length)
		{
			for(var i = 0; i < diagrams.length; i++)
			{
				Shadowbox.setup(diagrams[i].getElementsByTagName('area'), {width: 600, height: 500 });
			}
		}
		<? } ?>
		<? if(!empty($onLoad)) { ?>
			<?= $onLoad ?>
		<? } ?>
		<? if(false && !empty($enable_tracking)) { ?>
			enableLinkTracking('<?= $this->params['url']['url'] ?>', '<?= $enable_tracking ?>');
		<? } ?>
	}

	function stopRKey(evt) {
		var evt = (evt) ? evt : ((event) ? event : null);
		var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
		if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
	}

	function verifyRequiredFields_legacy()
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
			hidePleaseWait();
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
						hidePleaseWait();
						return false;
					}
				<? } ?>
			}
		<? } ?>


		return true;
	}

	</script>


</head>
<body onLoad="onLoad();" class="relative" onUnload="return onUnload();">

	<? if(!empty($showPleaseWait)) { ?>
	<script>
	j(document).ready(function() {
		j.spin();
	});
	</script>
	<? } ?>
	<div id="loading" style="<?= true || empty($showPleaseWait) ? "display:none;" : "" ?>" onClick="j(this).fadeOut('slow');">
		<div class="">
			<img class="loading_img" src="/images/icons/loading-teal.gif"/>
		</div>
	</div>
	<script>
	<? if(!empty($showPleaseWait)) { ?>
		<? if(is_numeric($showPleaseWait)) { ?>
		j('#loading').data('showPleaseWait', <?= $showPleaseWait ?>);
		<? } else { ?>
		//setTimeout("j('#loading').fadeOut('slow');", 30*1000);
		setTimeout("j.hidespin();", 30*1000);
		<? } ?>
	<? } ?>
	</script>

	<div id="container">
		<div id="header" style="position: relative; z-index: 30;">
			<?
			$status_bar = !empty($stepname) ? $this->element("steps/steps",array('step'=>$stepname)) : null;
			?>
			<?= $this->element("layout/header", array('status_bar'=>$status_bar)); ?>
		</div>

		<table id="content_row" style="position: relative; z-index: 20;" cellpadding=0 cellspacing=0>
		<tr>
			<td id="leftbar_column" class="hidden">
				<?php //echo $this->element("layout/leftbar", $this->viewVars); ?>
			</td>
			<td id="main_column" align="left">
			<div style="min-height: 200px;">
				<?= $session->flash('auth'); ?>
				<?= $session->flash(); ?>

				<?php echo $content_for_layout; ?>

			</div>
			</td>
			<? if(empty($rightbar_disabled) || !$rightbar_disabled) { 
			?>
			<td id="rightbar_column">
				<? if(!empty($rightbar_template)) { 
					echo $this->element($rightbar_template, $this->viewVars);
				} ?>
			</td>
			<? } ?>
		</tr>
		</table>

		<div id="footer">
			<?= $this->element("layout/footer", $this->viewVars); ?>
		</div>
		<div class="clear"></div>
	</div>
	<div id="modal" style="overflow: auto; display: none;"></div>
	<div id="alert" style="overflow: auto; display: none;"></div>


	<div>
		<?= !empty($malysoft) ? $this->element('sql_dump') : ''; ?>
	</div>
	<? if(!empty($livesite)) { ?>
	<script type="text/javascript">
		try {
			var pageTracker = _gat._getTracker("UA-16111468-1");
			pageTracker._trackPageview();
		} catch(err) {}
	</script>

	<? } ?>
	<? if(!empty($malysoft)) { ?>
		<a href="http://www.hp.malysoft.com/">ms</a>
	<? } ?>
	<?= $this->Js->writeBuffer(); ?>

<? if(!empty($livesite)) { ?>
<script type="text/javascript">
	setTimeout(function(){var a=document.createElement("script");
	var b=document.getElementsByTagName("script")[0];
	a.src=document.location.protocol+"//dnn506yrbagrg.cloudfront.net/pages/scripts/0014/1618.js?"+Math.floor(new Date().getTime()/3600000);
	a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
</script>
<? } ?>
</body>
</html>
