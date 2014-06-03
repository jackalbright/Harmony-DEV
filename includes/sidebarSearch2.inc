<table width="100%" align=right><tr><td align=right>

<div>
<!--Begin Sidebar Search-->
<script type="text/javascript" language="javascript1.2">
	var validSearch = false;
	var searchCount = 0;
	function allowSearch () {
		validSearch = true;
	}
	function preflightSearch () {
		if (validSearch) {
			validSearch = false;
			return true;
		} else {
			searchCount++;
			if ( searchCount >= 3 ) {
				alert ("Please enter some text to search for before submitting.");
				searchCount = 0;
			}
			return false;
		}
	}
</script>


<table width="150" border=0 cellpadding=5 cellspacing=0 id="sidebarSearchbox">
<tr class="header">
	<th align=left>Search Site</th>
	<td align=right>
		<a href="/info/sitemap.php">Site Map</a>
	</td>
</tr>
<tr>
	<td colspan=2>
        <form action="/product/search.php" method="get"  id="sidebarSearch" name="searchform" onsubmit="return preflightSearch();">
          <input type="text" id="searchTerms" name="q" onkeyup="allowSearch()" onchange="allowSearch()" value="<?php if ( isset($searchString) && (strpos($_SERVER['PHP_SELF'], 'search') !== false) ) echo htmlentities($searchString); ?>" style="width:122px;" />
          <input type="image" name="submit" value="Submit" src="/images-shared/Go.gif" alt="Submit" style="position:relative; height:21px; width:22px; top:4px;" />
        </form>
	</td>
</tr>
</table>
		
<?php
	if ( isset($searchString) && (strpos($_SERVER['PHP_SELF'], 'search') === false) && $searchString != '' ) { 
		$encodedSearch = htmlentities($searchString);
		echo "<a href=\"/product/search.php?q=$encodedSearch\">Last search: <em>$encodedSearch</em></a><br /><br />";
	}
	?>
<!--End Sidebar Search-->
</div>

</td></tr></table>
