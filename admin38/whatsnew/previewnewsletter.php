<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 3/9/05
******************************************************************************************/
	session_start();
	if (!array_key_exists('UName', $_SESSION)){
		header ('Location: ../index.php');
	} else {
		$manageOrders=$_SESSION['canManageOrders'];
		$manageParts=$_SESSION['canManageParts'];
		$manageUsers=$_SESSION['canManageUsers'];
		$manageItems=$_SESSION['canManageItems'];
		$manageEvents=$_SESSION['canManageEvents'];
		$manageDatabase=$_SESSION['canManageDatabase'];
		$manageTestimonials=$_SESSION['canManageTestimonials'];
	};
	if ($_SESSION['canManageParts']!="Yes"){
		header ('Location: ../menu.php');
	};
?>
<?php 
	include_once ('../../includes/database.inc');
	$txtStartDate = $_GET['txtStartYear'] . "-" . $_GET['txtStartMonth'] . "-" . $_GET['txtStartDay'];
	$txtStampDate = $_GET['txtStampYear'] . "-" . $_GET['txtStampMonth'] . "-" . $_GET['txtStampDay'];
	$txtWelcomeTitle = stripslashes($_GET['txtWelcomeTitle']);
	$txtWelcomeDesc = nl2br(stripslashes($_GET['txtWelcomeDesc']));
	$txtWelcomeMessage = "<BR><H2>$txtWelcomeTitle</H2><BR>Dear Valued Customer,<BR><BR>";
	$txtWelcomeMessage = $txtWelcomeMessage . "<p>$txtWelcomeDesc</p>";
	$txtSpotlightQuery = 'Select * from spotlight_items where (start_date <= "'. $txtStartDate . '" ) AND (end_date >= "' . $txtStartDate . '" ) order by start_date DESC';
	$results = mysql_query ($txtSpotlightQuery, $database );
	$record = mysql_fetch_object ($results);
	while ( $row = mysql_fetch_object($results) ) {
		$stylesheet[] = $record->stylesheet_loc;
		$include_file[] = $record->include_file_loc;
	};
	$results = mysql_query ("select distinct * from stamp where (Available = 'yes') && (entry_date >= '$txtStampDate') && (entry_date <= '$txtStartDate') order by  stamp.stamp_name LIMIT 0,8", $database);
	$searchResults = array();
	while ( $temp = mysql_fetch_object( $results ) ) {
		$searchResults[] = $temp;		
	};
	$numResults = count($searchResults);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>E-mail Preview</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<?php
	if ($stylesheet[0]!=""){
	foreach ($stylesheet as $CSSSheet) {
?>
	<link rel="Stylesheet" href="http://www.hdtest.com/<?php echo $CSSSheet; ?>" type="text/css" media="all" />
<?php
};
};
?>
<style type="text/css" media="all">
body{background-color: #FFFFD0; background-image: url(http://www.hdtest.com/new-images/background.gif); margin: 6px; font-family: "Arial", sans-serif; font-size: 10pt; background-repeat: no-repeat; width: 600px; border-color: #090; border-width: 0 1px 0 0; border-style: none none none none;}
.imgButton{	padding: 0px; margin: 0px; border-width: 0px; height: 29px; background-color: #FFE;}
.nowrap { white-space: nowrap; }
p { margin: 0 0 .5em 0; }
h1,h2,h3,h4,h5,h6{color: #060; font-family: "Times", serif;	font-weight: bold; margin: 0 0 5px 0;}
h1 { font-size: 42px; }
h2 { font-size: 28px; }
h3 { font-size: 18px; }
h4 { font-size: 15px; }
h5 { font-size: 12px; }
h6 { font-size: 11px; }
a h1,a h2,a h3,a h4,a h5,a h6{color: #039; text-decoration: none;}
a h1:hover,a h2:hover,a h3:hover,a h4:hover,a h5:hover,a h6:hover { color: #909; }
.center { text-align: center; }
.right { text-align: right; }
a:link { color: #039; }
a:visited { color: #903; }
a:hover { color: #909; }
a:active { color: #309; }
hr.narrow { margin: 0; }
.note{font-size: smaller; font-style: italic; font-weight: normal;}
.testimonial{text-align: left; color: #060; font-style: italic; font-weight: bold; margin-bottom: 0.25em;}
.attribution{text-align: right; color: #060; font-style: italic; margin-top: 0.25em;}
.super{vertical-align: super; font-size: 0.7em;}
.sub{vertical-align: sub; font-size: 0.7em;}
.divider { clear: both; }
div#header{width: 760px; height: 88px;}
#header img { border-width: 0px; }
#header img#logo{position: absolute; top: 4px; left: 17px;}
#header img#slogan{position: absolute; top: 10px; left: 186px;}
#header #title{position: absolute; top: 45px; left: 220px;}
div#title{clear: right;}
/* Left Bar */
div#leftbar{width: 230px; float: left; clear: left;	padding-top: 25px; font-size: 0.95em;}
#subjectList { font-size: 0.95em; }
#leftbar ul{list-style-type: none;}
#currentNode{color: #936; list-style-type: disc; margin: 0.25em 0 0.25em 0; font-style: italic;}
#productList a{text-decoration: none;}
.bookwrapper{width: 228px;}
.bookcontentwrapper{background-image: url(http://www.hdtest.com/new-images/Single-Homepage-Bookmark-02.gif); background-repeat: repeat-y;}
.booktop{background-image: url(http://www.hdtest.com/new-images/Single-Homepage-Bookmark-01.gif); background-repeat: no-repeat; width: 228px; height: 54px;}
.booktassel{background-image: url(http://www.hdtest.com/new-images/Single-Homepage-Bookmark-03.gif); background-repeat: no-repeat; float: right; width: 61px; height: 176px; padding-left: 0px;}
.bookcontent{background-color: #FFE; width: 154px; clear: none;	margin-left: 8px; margin-right: 61px; padding-top: 6px; padding-bottom: 6px;}
.bookbottom{background-image: url(http://www.hdtest.com/new-images/Single-Homepage-Bookmark-05.gif); background-repeat: no-repeat; clear: both; height: 24px; width: 228px;}
#bookmark{width: 221px;	background-image: url(http://www.hdtest.com/background-images/Bookmark-Rework.gif); background-repeat: no-repeat; background-position: 0 0; padding: 1px 0 0 0; margin: 0 0 10px 0;}
#bookmark #bookBottom{width: 221px; height: 14px; background-image: url(http://www.hdtest.com/background-images/Bookmark-Rework-bottom.gif); margin: 0;}
#bookmark #bookContents{width: 166px; margin: 60px auto 14px 8px; padding: 0;}
h2#alert { color: #C33; }
.subjectList{margin: 0 0 .5em 0; clear: right;}
#updateCount p{text-align: left; margin: 0;}
.subjectList *{margin: 0;}
.subjectList h2 { color: #039; }
.subjectList img {float: left; border-width: 0;}
.subjectList p {margin-left: 50px;}
select { width: 4em; }
#main h1, #main h2, #main h3, #main h4, #main h5, #main h6 {clear: left; }
h3.category	{text-indent: -1em; padding-left: 1em; margin: 0.25em 0 0.75em 0.5em;}
h4.subHead {font-style: italic;}
p#altSearch {color: gray;}
p#altSpelling {color: gray;	font-size: 0.85em;}
.productLink p { margin-left: 80px; }
.productLink img {float: left; margin: 0 6px 0.5em 0;}
div#mainWrapper{float: left; width: 370px; margin: 0 0 10px 0;}
div#contentWrapper{ width: 542px; float: right; clear: none;}
div#title{margin: 0; padding: 0; width: 540px;}
div#main{margin: 0; padding: 0; float: left;}
div#leftbar{margin: 0; padding: 0; float: left; width: 221px;}
div#rightBar{ margin-top: 0px; float: right;}
div#footer{ margin: 10px 0 0 0; clear: both;}
.stretcher{	clear: both;}
#bookmark{width: 221px; background-image: url(http://www.hdtest.com/background-images/Bookmark-Rework.gif); background-repeat: no-repeat; background-position: 0 0; padding: 1px 0 0 0; margin: 0 0 10px 0;}
#bookmark #bookBottom{width: 221px; height: 14px; background-image: url(http://www.hdtest.com/background-images/Bookmark-Rework-bottom.gif); margin: 0;}
#bookmark #bookContents{width: 166px; margin: 60px auto 14px 8px; padding: 0;}
input#searchTerms{width: 164px; margin: 0 auto 0 auto;}
button#searchSubmit{margin: 0 auto 0 auto;}
</style>
</head>
<body>
<div id="header"><a href="www.harmonydesigns.com/index.php"><img id="logo" src="http://www.harmonydesigns.com/new-images/large-logo.gif" width="160" height="79" border="0"></a>
<img id="slogan" src="http://www.harmonydesigns.com/new-images/Slogan.gif" alt="Harmony Designs Logo" width="387" height="18">
<div id="title">
  <h2>Harmony Designs Newsletter</h2>
  <p><i><?php echo ($_GET['txtStartMonth'] . "-" . $_GET['txtStartDay'] . "-" . $_GET['txtStartYear']); ?></i></p>
</div>
</div>
<!-- Begin Left Bar -->
		<div id="leftbar">
<!-- Begin Bookmark -->
			<div id="bookmark">
			  <div id="bookContents">
<!-- Begin What's New -->
					<h3>What's New</h3> 
					<hr />
					<?php
						$results = mysql_query ('Select title, description from web_feature where (start_date <= CURDATE() ) && (end_date >= CURDATE() ) order by start_date DESC', $database );
						if ($results){
					?>
					<h4>Web Features</h4>
				  <?php
						};
						while ( $row = mysql_fetch_object($results) ) {
							$title=$row->title;
							$description=$row->description;
							echo "<p><b>$title</b><br />$description<br /><br /></p>";
						};
					?>
				  <?php
						$results = mysql_query ('Select title, body from announcement where (start_date <= CURDATE() ) && (end_date >= CURDATE() ) order by start_date DESC', $database );
						if ($results){
							while ( $row = mysql_fetch_object($results) ) {
								$title=$row->title;
								$description=$row->body;
								echo "<h4>$title</h4><p>$description<br /><br /></p>";
							};
						};
					?>
<!-- End What's New -->
				<hr>
				<!-- Begin Feature List -->
			<p>&bull; Choose any image on any product with any text.<br/>
		  <br/>
				&bull; <a href="/info/submission.php">Use your own photo, logo or art on your custom gifts</a>.</p>
			<p><br/>
  &bull; Low minimums. Free personalization.</p>
			<p><br/>
  &bull;<a href="/info/quantityPricing.php">Quantity Discounts</a> available.<br/>
  <br/>
  &bull;Fast Service: Most orders ship within 3 business days.</p>
			<p><br/>
  &bull;Shipping by FedEx and US Mail.</p>
			<p><br/>
  &bull;Materials and workmanship guaranteed.</p>
			<p><br/>
  &bull;All products made in USA.<br/>
			  </ul>
			  </p>
			<p>Questions? Please e-mail <a href="mailto:info@harmonydesigns.com">info@harmonydesigns.com</a> or call (888)&nbsp;293-1109.</p>
			<hr />
			<p class="center">Harmony Designs <br />
				donates a percentage <br />of its annual profits to<br />
				cancer research</p>
			<p class="center">We are a member of <br />
				the <a href="http://fairlabor.org">Fair Labor </a><a href="http://fairlabor.org">Association</a> and the Museum Store Association
			</p>
<!-- End Feature List -->

				<p></p>
			  </div>
				<div id="bookBottom">
				</div>
			</div>
<!-- End Bookmark -->
		</div>
<!-- End Left Bar -->
<div id="mainWrapper">
<p><?php echo $txtWelcomeMessage; ?><BR>
Best Regards,<BR>

<BR><BR>Sherrill Franklin<BR>
Harmony Designs, Inc.</p>
<!-- Begin special item feature -->
			<?php
				$i = 0;
				if ($include_file[0]!=""){
					foreach($include_file as $include){
						include("http://hdtest.com/$include");
						$i++;
					};
				};
			?>
		<?php
		if ($i>0){
		?>
			<p>
				To see our other specials, visit our <a href='../../spotlight-items.php' target="_blank">Special Items page</a>.
			</p><hr />			
		<?php	} ?>
<!-- End special item feature -->
<h2>New Additions to our Stamp Library</h2>
<p>
<?php
				for ($i=0; $i < $numResults; $i++ ) {
					echo '<div class="subjectList"><a href="../../product/detail.php?catalogNumber=';
					echo $searchResults[$i]->catalog_number;
					echo '" target="_blank"><h3>';
					echo $searchResults[$i]->stamp_name;
					echo '</h3>Create&nbsp;Gift&nbsp;with&nbsp;this&nbsp;Stamp<img src="../..';
					echo $searchResults[$i]->thumbnail_location;
					echo '"></a>';
					echo '<div><p>';
					echo $searchResults[$i]->short_description;
					echo '</p><p class="note">Catalog # ';
					echo $searchResults[$i]->catalog_number;
					echo '</p></div></div><br>';
				}
?></p>
<p>To see our other new stamps, visit our <a href='../../product/showRecent.php<?php echo "?startday=". $_GET['txtStampDay'] . "&startmonth=" . $_GET['txtStampMonth'] . "&startyear=" . $_GET['txtStampYear'] . "&endday=" . $_GET['txtStartDay'] . "&endmonth=" . $_GET['txtStartMonth'] . "&endyear=" . $_GET['txtStartYear']; ?>' target="_blank">New Stamp page</a>.</p>
<HR></div>
<div id="footer">
<p align="center">Harmony Designs, Inc. ...making history one piece at a time since 1992 <BR>129 E. Harmony Road West Grove, PA 19390 <br>
  Order line: 888.293.1109 Project consult line: 610.869.4234<br>
  Fax: 610.869.7415<br>
  email: <a href="mailto:info@harmonydesigns.com">info@harmonydesigns.com</a><br>
  email: <a href="mailto:orders@harmonydesigns.com">orders@harmonydesigns.com</a><br>
website: <a href="http://www.harmonydesigns.com/">www.harmonydesigns.com</a></p>
<p align="center">Bookmarks &bull;  Framed Stamps &bull; Keychains &bull;  Luggage Tags &bull;&nbsp;Magnets &bull; Mugs &bull; Ornaments &bull; Paperweights &bull;&nbsp;Pins &bull; Postcards &bull; Posters &bull; Puzzles &bull; Rulers &bull; Stamps on a Card &bull;  T-shirts &bull; Totebags&nbsp;&bull; Paperweight Kits &bull; Charms &bull;  Tassels </p>
<br>
<p align="center">If you want to be removed from our mailing list, log in to <a href="http://www.harmonydesigns.com/custserv/">your account</a> . Under &quot;Account Information&quot; click on &quot;Change your name, ...&quot; Uncheck the box that says "I would like to join the Harmony Designs mailing list ...&quot;</p>
</div>
</body>
</html>
