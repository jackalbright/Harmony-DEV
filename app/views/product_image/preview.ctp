<html>
<head>
	<link rel="Stylesheet" href="/stylesheets/base2.css" type="text/css" media="all" />
	<link rel="Stylesheet" href="/stylesheets/autoload.php" type="text/css" media="all" />
	<script type="text/javascript" src="/js/jquery-1.7.1.js"></script>
	<script type="text/javascript" src="/js/shadowbox/shadowbox.js"></script>
	<link rel="stylesheet" type="text/css" href="/js/shadowbox/shadowbox.css"/>
</head>
<body><!-- XXXonLoad="parent.document.getElementById('preview_iframe').height = document['body'].offsetHeight + 50; parent.hidePleaseWait();"> -->

<a id="preview_larger" href="/product_image/stock_preview/-1200x1200.png" onClick="Shadowbox.open(this); return false;"/>+ View Larger</a>

<script>
<? if($errors = $this->Session->read("Message.flash.message")) { ?>
	var errormsg = "<div id='preview_error' class='error'><?= $errors ?></div>";
	window.parent.j('#preview_error').remove();
	window.parent.j('#preview_iframe').after(errormsg);
	parent.hidePleaseWait();
	<? $this->Session->delete("Message.flash"); ?>
<? } else { ?>
	var a = window.parent.document.getElementById('preview_img');
	a.href = "/product_image/stock_preview/-1200x1200.png?rand=<?=rand(1,90000); ?>";
	
	window.parent.Shadowbox.setup(a);
	window.parent.Shadowbox.open(a);
	window.parent.hidePleaseWait();
<? } ?>
</script>

</body>
</html>
