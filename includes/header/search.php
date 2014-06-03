<div style="width: 225px;">
<form action="<?= false && !empty($_SESSION['Auth']['Customer']['is_admin']) ? "/search" : "/product/search.php" ?>" method="GET"  id="searchform" name="searchform">
        <input type="text" id="search" name="q" style="font-weight: normal; width: 150px; " value="<?= !empty($_REQUEST['q']) ? $_REQUEST['q'] : "" ?>"/>
	<input type="image" value="Search" align="top" src="/images/webButtons2014/grey/small/search.png"/>
</form>
</div>
