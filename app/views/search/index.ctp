<div>
	<? if(!empty($_REQUEST['q'])) { ?>
	<h2>Searched for: <i><?= $_REQUEST['q'] ?></i></h2>
	<? } ?>
	<div id="cse" style="width: 100%;">Searching...</div>
	<script src="https://www.google.com/jsapi" type="text/javascript"></script>
	<script type="text/javascript"> 
	  google.load('search', '1', {language : 'en'});
	  google.setOnLoadCallback(function() {
	    var customSearchControl = new google.search.CustomSearchControl('004564445762325706795:0mskjlhfwcq');
	    customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
	    customSearchControl.setLinkTarget(google.search.Search.LINK_TARGET_SELF);
	    var options = new google.search.DrawOptions();
	    options.setAutoComplete(true);
	    customSearchControl.draw('cse', options);
	    <? if(!empty($_REQUEST['q'])) { ?>
		j('.gsc-search-box').hide();
	    	j('.gsc-input').val("<?= preg_replace('/"/', '\\"', $_REQUEST['q']); ?>");
		j('.gsc-search-button').click();
	    <? } ?>

	  }, true);
	</script>
	<link rel="stylesheet" href="http://www.google.com/cse/style/look/default.css" type="text/css" />

</div>
