<div style="width: 225px;">
<form action="<?= false && !empty($_SESSION['Auth']['Customer']['is_admin']) ? "/search" : "/product/search.php" ?>" method="GET"  id="searchform" name="searchform">
        <input type="text" id="search" name="q" style="width: 150px; " value="<?= !empty($_REQUEST['q']) ? preg_replace("/\?(.*)/", "", urlencode($_REQUEST['q'])) : "" ?>"/>
	<input type="image" value="Search" align="top" src="/images/buttons/small/Search-grey.gif"/>
</form>
</div>
