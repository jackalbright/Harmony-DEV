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
<!-- use "/product/search.php" for old search and "/search/index.php" for google search -->
<form action="/product/search.php" method="get"  id="sidebarSearch" name="searchform" onsubmit="return preflightSearch();" class="center">
		<input type="text" id="searchTerms" name="q" size="20" onkeyup="allowSearch()" onchange="allowSearch()" value="<?php if ( isset($searchString) && (strpos($_SERVER['PHP_SELF'], 'search') !== false) ) echo htmlentities($searchString); ?>" />
		<br />
		<button  class="imgButton" type="submit" id="searchSubmit">
			<img src="/new-buttons/Search-light-background.gif" width="96" height="29" alt="search" />
		</button>
</form>
<?php
	if ( isset($searchString) && (strpos($_SERVER['PHP_SELF'], 'search') === false) && $searchString != '' ) { 
		$encodedSearch = htmlentities($searchString);
		echo "<a href=\"/product/search.php?q=$encodedSearch\">Last search: <em>$encodedSearch</em></a>";
	}
	?>
<hr />
<!--End Sidebar Search-->
