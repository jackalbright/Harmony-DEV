<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 4/27/05
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
	if ($_SESSION['canManageEvents']!="Yes"){
		header ('Location: ../menu.php');
	};
?>
<?php
	include ('../../includes/admin.inc');
	$domainName = 'harmonydesigns.com';
?>
<?php
    $featureID=$_POST['hdnFeatureID'];
    $startday=$_POST['txtStartDay'];
	$startmonth=$_POST['txtStartMonth'];
	$startyear=$_POST['txtStartYear'];
    $stampday=$_POST['txtStampDay'];
	$stampmonth=$_POST['txtStampMonth'];
	$stampyear=$_POST['txtStampYear'];
	$txtSendMail=$_POST['txtSendEmail'];
	$txtWelcomeTitle=addslashes($_POST['txtWelcomeTitle']);
	$txtWelcomeDesc=addslashes(nl2br($_POST['txtWelcomeDesc']));
	$txtStartDate = $startyear . "-" . $startmonth . "-" . $startday;
	$txtStampDate = $stampyear . "-" . $stampmonth . "-" . $stampday;
	$intItemFound=0;
	$txtSendStatus="false";
  	include('../../includes/database.inc');
    $result = mysql_query ("SELECT * FROM newsletters WHERE title = '$txtWelcomeTitle' AND welcome_letter='$txtWelcomeDesc' AND send_date='$startyear-$startmonth-$startday' AND stamp_start_date='$stampyear-$stampmonth-$stampday'", $database);
	if ($result){
		$intItemFound++;
		$txtSendStatus=$result->status_sent;
	};
    mysql_close($database);
	if ($intItemFound!=0){
    	if ($featureID=="AAA")
    	{
	      $querystring = "INSERT INTO newsletters (newsletter_id, title, welcome_letter, send_date, stamp_start_date, status_sent) VALUES ('', '$txtWelcomeTitle', '$txtWelcomeDesc', '$startyear-$startmonth-$startday', '$stampyear-$stampmonth-$stampday', '$txtSendMail');";
	    } else {
	      $querystring = "UPDATE newsletters SET send_date = '$startyear-$startmonth-$startday', stamp_start_date = '$stampyear-$stampmonth-$stampday', title='$txtWelcomeTitle', welcome_letter='$txtWelcomeDesc', status_sent='$txtSendMail' WHERE newsletter_id='$featureID'";
	    };
		include ('../../includes/database.inc');
		$result = mysql_query ($querystring, $database);
// Get addresses and names for sending the e-mails
		if ($txtSendMail=="true"){
			$querystring = "SELECT DISTINCT First_Name, Last_Name, eMail_Address from customer WHERE Mail_List = 'Yes'";						
			$result = mysql_query ($querystring, $database);
			while ($row = mysql_fetch_object($result))
	    	{
				$txtFirstName[]=$row->First_Name;
				$txtLastName[]=$row->Last_Name;
				$txtEMailAddress[]=$row->eMail_Address;
			};
// Get Newsletter Content Information
			$txtSpotlightQuery = 'Select * from spotlight_items where (start_date <= "'. $txtStartDate . '" ) AND (end_date >= "' . $txtStartDate . '" ) order by start_date DESC';
			$results = mysql_query ($txtSpotlightQuery, $database );
			$record = mysql_fetch_object ($results);
			while ( $row = mysql_fetch_object($results) ) {
				$stylesheet[] = $record->stylesheet_loc;
				$include_file[] = $record->include_file_loc;
			};
			$results = mysql_query ('Select title, description from web_feature where (start_date <= CURDATE() ) && (end_date >= CURDATE() ) order by start_date DESC', $database );
			$txtHTMLfeatures = "";
			if ($results){
				$txtHTMLfeatures = "<h4>Web Features</h4>";
			};
			while ( $row = mysql_fetch_object($results) ) {
				$title=$row->title;
				$description=$row->description;
				$txtHTMLfeatures .= "<p><b>$title</b><br />$description<br /><br /></p>";
			};
			$results = mysql_query ('Select title, body from announcement where (start_date <= CURDATE() ) && (end_date >= CURDATE() ) order by start_date DESC', $database );
			if ($results){
				while ( $row = mysql_fetch_object($results) ) {
					$title=$row->title;
					$description=$row->body;
					$txtHTMLfeatures .= "<h4>$title</h4><p>$description<br /><br /></p>";
				};
			};
			$results = mysql_query ("select distinct * from stamp where (Available = 'yes') && (entry_date >= '$txtStampDate') && (entry_date <= '$txtStartDate') order by  stamp.stamp_name LIMIT 0,8", $database);
			$searchResults = array();
			while ( $temp = mysql_fetch_object( $results ) ) {
				$searchResults[] = $temp;		
			};
			$numResults = count($searchResults);
			$txtWelcomeTitle = stripslashes($txtWelcomeTitle);
			$txtWelcomeDesc = stripslashes($txtWelcomeDesc);
			$txtMessageBody = "";			
		/* To send HTML mail, you can set the Content-type header. */
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		/* additional headers */
			$headers .= "From: info@$domainName\r\n";
			foreach($txtEMailAddress as $key => $value){
				$txtWelcomeMessage = "<BR><H2>$txtWelcomeTitle</H2><BR>Dear $txtFirstName[$key] $txtLastName[$key],<BR><BR>";
				$txtWelcomeMessage = $txtWelcomeMessage . "<p>$txtWelcomeDesc</p>";
				$txtMessageBody = "<html><head><title>Harmony Designs Newsletter</title><meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-1\">";
				if ($stylesheet[0]!=""){
					foreach ($stylesheet as $CSSSheet) {
						$txtMessageBody .= "<link rel=\"Stylesheet\" href=\"http://www.$domainName/$CSSSheet\" type=\"text/css\" media=\"all\" />";
					};
				};
				$txtMessageBody .="<style type=\"text/css\" media=\"all\">";
				$txtMessageBody .= "body{background-color: #FFFFD0; background-image: url(http://www.$domainName/new-images/background.gif); margin: 6px; font-family: \"Arial\", sans-serif; font-size: 10pt; background-repeat: no-repeat; width: 600px; border-color: #090; border-width: 0 1px 0 0; border-style: none none none none;}";
				$txtMessageBody .= ".imgButton{	padding: 0px; margin: 0px; border-width: 0px; height: 29px; background-color: #FFE;}";
				$txtMessageBody .= ".nowrap { white-space: nowrap; }";
				$txtMessageBody .= "p { margin: 0 0 .5em 0; }";
				$txtMessageBody .= "h1,h2,h3,h4,h5,h6{color: #060; font-family: \"Times\", serif;	font-weight: bold; margin: 0 0 5px 0;}";
				$txtMessageBody .= "h1 { font-size: 42px; }";
				$txtMessageBody .= "h2 { font-size: 28px; }";
				$txtMessageBody .= "h3 { font-size: 18px; }";
				$txtMessageBody .= "h4 { font-size: 15px; }";
				$txtMessageBody .= "h5 { font-size: 12px; }";
				$txtMessageBody .= "h6 { font-size: 11px; }";
				$txtMessageBody .= "a h1,a h2,a h3,a h4,a h5,a h6{color: #039; text-decoration: none;}";
				$txtMessageBody .= "a h1:hover,a h2:hover,a h3:hover,a h4:hover,a h5:hover,a h6:hover { color: #909; }";
				$txtMessageBody .= ".center { text-align: center; }";
				$txtMessageBody .= ".right { text-align: right; }";
				$txtMessageBody .= "a:link { color: #039; }";
				$txtMessageBody .= "a:visited { color: #903; }";
				$txtMessageBody .= "a:hover { color: #909; }";
				$txtMessageBody .= "a:active { color: #309; }";
				$txtMessageBody .= "hr.narrow { margin: 0; }";
				$txtMessageBody .= ".note{font-size: smaller; font-style: italic; font-weight: normal;}";
				$txtMessageBody .= ".testimonial{text-align: left; color: #060; font-style: italic; font-weight: bold; margin-bottom: 0.25em;}";
				$txtMessageBody .= ".attribution{text-align: right; color: #060; font-style: italic; margin-top: 0.25em;}";
				$txtMessageBody .= ".super{vertical-align: super; font-size: 0.7em;}";
				$txtMessageBody .= ".sub{vertical-align: sub; font-size: 0.7em;}";
				$txtMessageBody .= ".divider { clear: both; }";
				$txtMessageBody .= "div#header{width: 760px; height: 88px;}";
				$txtMessageBody .= "#header img { border-width: 0px; }";
				$txtMessageBody .= "#header img#logo{position: absolute; top: 4px; left: 17px;}";
				$txtMessageBody .= "#header img#slogan{position: absolute; top: 10px; left: 186px;}";
				$txtMessageBody .= "#header #title{position: absolute; top: 45px; left: 220px;}";
				$txtMessageBody .= "div#title{clear: right;}";
				$txtMessageBody .= "div#leftbar{width: 230px; float: left; clear: left;	padding-top: 25px; font-size: 0.95em;}";
				$txtMessageBody .= "#subjectList { font-size: 0.95em; }";
				$txtMessageBody .= "#leftbar ul{list-style-type: none;}";
				$txtMessageBody .= "#currentNode{color: #936; list-style-type: disc; margin: 0.25em 0 0.25em 0; font-style: italic;}";
				$txtMessageBody .= "#productList a{text-decoration: none;}";
				$txtMessageBody .= ".bookwrapper{width: 228px;}";
				$txtMessageBody .= ".bookcontentwrapper{background-image: url(http://www.$domainName/new-images/Single-Homepage-Bookmark-02.gif); background-repeat: repeat-y;}";
				$txtMessageBody .= ".booktop{background-image: url(http://www.$domainName/new-images/Single-Homepage-Bookmark-01.gif); background-repeat: no-repeat; width: 228px; height: 54px;}";
				$txtMessageBody .= ".booktassel{background-image: url(http://www.$domainName/new-images/Single-Homepage-Bookmark-03.gif); background-repeat: no-repeat; float: right; width: 61px; height: 176px; padding-left: 0px;}";
				$txtMessageBody .= ".bookcontent{background-color: #FFE; width: 154px; clear: none;	margin-left: 8px; margin-right: 61px; padding-top: 6px; padding-bottom: 6px;}";
				$txtMessageBody .= ".bookbottom{background-image: url(http://www.$domainName/new-images/Single-Homepage-Bookmark-05.gif); background-repeat: no-repeat; clear: both; height: 24px; width: 228px;}";
				$txtMessageBody .= "#bookmark{width: 221px;	background-image: url(http://www.$domainName/background-images/Bookmark-Rework.gif); background-repeat: no-repeat; background-position: 0 0; padding: 1px 0 0 0; margin: 0 0 10px 0;}";
				$txtMessageBody .= "#bookmark #bookBottom{width: 221px; height: 14px; background-image: url(http://www.$domainName/background-images/Bookmark-Rework-bottom.gif); margin: 0;}";
				$txtMessageBody .= "#bookmark #bookContents{width: 166px; margin: 60px auto 14px 8px; padding: 0;}";
				$txtMessageBody .= "h2#alert { color: #C33; }";
				$txtMessageBody .= ".subjectList{margin: 0 0 .5em 0; clear: right;}";
				$txtMessageBody .= "#updateCount p{text-align: left; margin: 0;}";
				$txtMessageBody .= ".subjectList *{margin: 0;}";
				$txtMessageBody .= ".subjectList h2 { color: #039; }";
				$txtMessageBody .= ".subjectList img {float: left; border-width: 0;}";
				$txtMessageBody .= ".subjectList p {margin-left: 50px;}";
				$txtMessageBody .= "select { width: 4em; }";
				$txtMessageBody .= "#main h1, #main h2, #main h3, #main h4, #main h5, #main h6 {clear: left; }";
				$txtMessageBody .= "h3.category	{text-indent: -1em; padding-left: 1em; margin: 0.25em 0 0.75em 0.5em;}";
				$txtMessageBody .= "h4.subHead {font-style: italic;}";
				$txtMessageBody .= "p#altSearch {color: gray;}";
				$txtMessageBody .= "p#altSpelling {color: gray;	font-size: 0.85em;}";
				$txtMessageBody .= ".productLink p { margin-left: 80px; }";
				$txtMessageBody .= ".productLink img {float: left; margin: 0 6px 0.5em 0;}";
				$txtMessageBody .= "div#mainWrapper{float: left; width: 370px; margin: 0 0 10px 0;}";
				$txtMessageBody .= "div#contentWrapper{ width: 542px; float: right; clear: none;}";
				$txtMessageBody .= "div#title{margin: 0; padding: 0; width: 540px;}";
				$txtMessageBody .= "div#main{margin: 0; padding: 0; float: left;}";
				$txtMessageBody .= "div#leftbar{margin: 0; padding: 0; float: left; width: 221px;}";
				$txtMessageBody .= "div#rightBar{ margin-top: 0px; float: right;}";
				$txtMessageBody .= "div#footer{ margin: 10px 0 0 0; clear: both;}";
				$txtMessageBody .= ".stretcher{	clear: both;}";
				$txtMessageBody .= "#bookmark{width: 221px; background-image: url(http://www.$domainName/background-images/Bookmark-Rework.gif); background-repeat: no-repeat; background-position: 0 0; padding: 1px 0 0 0; margin: 0 0 10px 0;}";
				$txtMessageBody .= "#bookmark #bookBottom{width: 221px; height: 14px; background-image: url(http://www.$domainName/background-images/Bookmark-Rework-bottom.gif); margin: 0;}";
				$txtMessageBody .= "#bookmark #bookContents{width: 166px; margin: 60px auto 14px 8px; padding: 0;}";
				$txtMessageBody .= "input#searchTerms{width: 164px; margin: 0 auto 0 auto;}";
				$txtMessageBody .= "button#searchSubmit{margin: 0 auto 0 auto;}";
				$txtMessageBody .= "</style></head><body><div id=\"header\"><a href=\"www.harmonydesigns.com/index.php\"><img id=\"logo\" src=\"http://www.harmonydesigns.com/new-images/large-logo.gif\" width=\"160\" height=\"79\" border=\"0\"></a>";
				$txtMessageBody .= "<img id=\"slogan\" src=\"http://www.harmonydesigns.com/new-images/Slogan.gif\" alt=\"Harmony Designs Logo\" width=\"387\" height=\"18\"><div id=\"title\"><h2>Harmony Designs Newsletter</h2><p><i>";
				$txtMessageBody .= $startmonth . "-" . $startday . "-" . $startyear . "</i></p></div></div><div id=\"leftbar\">";
				$txtMessageBody .= "<div id=\"bookmark\"><div id=\"bookContents\"><h3>What's New</h3><hr />";
				$txtMessageBody .= "$txtHTMLfeatures";
				$txtMessageBody .= "<hr><p>&bull;Choose any image on any product with any text.<br/>";
				$txtMessageBody .= "&bull;Thousands of subjects<br/>";
				$txtMessageBody .= "&bull;<a href=\"/info/submission.php\">Use your own photo, logo or art on your custom gifts</a>.<br/>";
				$txtMessageBody .= "&bull;Order any quantity, 1&nbsp;&#8212;&nbsp;1000s.<br/>";
				$txtMessageBody .= "&bull;<a href=\"/info/quantityPricing.php\">Quantity Discounts</a> available.<br/>&bull;Free personalization<br/>";
				$txtMessageBody .= "&bull;Fast Service: Most orders ship within 3 business days.<br/>&bull;Shipping by UPS, FedEx and US Mail.<br/>";
				$txtMessageBody .= "&bull;Materials and workmanship guaranteed.<br/>&bull;All products made in USA.<br/></ul></p>";
				$txtMessageBody .= "<p>Questions? Please e-mail <a href=\"mailto:info@harmonydesigns.com\">info@harmonydesigns.com</a> or call (888)&nbsp;293-1109.</p><hr />";
				$txtMessageBody .= "<p class=\"center\">Harmony Designs <br />";
				$txtMessageBody .= "donates a percentage <br />of its annual profits to<br />";
				$txtMessageBody .= "cancer research</p>";
				$txtMessageBody .= "<p class=\"center\">We are a member of <br />";
				$txtMessageBody .= "the <a href=\"http://fairlabor.org\">Fair Labor </a><a href=\"http://fairlabor.org\">Association</a>.</p>";
				$txtMessageBody .= "<p></p></div><div id=\"bookBottom\"></div></div></div><div id=\"mainWrapper\">";
				$txtMessageBody .= "<p>$txtWelcomeMessage<BR>Best Regards,<BR><BR><BR>Sherrill Franklin<BR>Harmony Designs, Inc.</p>";
				$i = 0;
				if ($include_file[0]!=""){
					foreach($include_file as $include){
						$txtMessageBody .= file_get_contents("http://$domainName/$include");
						$i++;
					};
				};
				if (i>0){
					$txtMessageBody .= "<p>To see our other specials, visit our <a href='../../spotlight-items.php' target=\"_blank\">Special Items page</a>.</p><hr />";
				};
				$txtMessageBody .= "<h2>New Additions to our Stamp Library</h2><p>";
				for ($i=0; $i < $numResults; $i++ ) {
					$txtMessageBody .= "<div class=\"subjectList\"><a href=\"http://www.$domainName/product/detail.php?catalogNumber=";
					$txtMessageBody .= $searchResults[$i]->catalog_number;
					$txtMessageBody .= "\" target=\"_blank\"><h3>";
					$txtMessageBody .= $searchResults[$i]->stamp_name;
					$txtMessageBody .= "</h3>Create&nbsp;Gift&nbsp;with&nbsp;this&nbsp;Stamp<img src=\"http://www.$domainName/";
					$txtMessageBody .= $searchResults[$i]->thumbnail_location;
					$txtMessageBody .= "\"></a>";
					$txtMessageBody .= "<div><p>";
					$txtMessageBody .= $searchResults[$i]->short_description;
					$txtMessageBody .= "</p><p class=\"note\">Catalog # ";
					$txtMessageBody .= $searchResults[$i]->catalog_number;
					$txtMessageBody .= "</p></div></div><br>";
				};
				$txtMessageBody .= "</p><p>To see our other new stamps, visit our <a href='http://www.$domainName/product/showRecent.php' target=\"_blank\">New Stamp page</a>.</p><HR></div><div id=\"footer\">";
				$txtMessageBody .= "<p align=\"center\">Harmony Designs, Inc. ...making history one piece at a time since 1992 <BR>129 E. Harmony Road West Grove, PA 19390 <br>";
				$txtMessageBody .= "Order line: 1-888-293-1109 Project consult line: 610-869-4234<br>";
				$txtMessageBody .= "Fax: 610-869-7415<br>";
				$txtMessageBody .= "email: <a href=\"mailto:info@harmonydesigns.com\">info@harmonydesigns.com</a><br>";
				$txtMessageBody .= "email: <a href=\"mailto:orders@harmonydesigns.com\">orders@harmonydesigns.com</a><br>";
				$txtMessageBody .= "website: <a href=\"http://www.harmonydesigns.com/\">www.harmonydesigns.com</a></p>";
				$txtMessageBody .= "<p align=\"center\">Bookmarks &bull; PageWeights &bull; Magnets &bull; Keychains &bull; Posters &bull; Mugs &bull; Rulers &bull;";
				$txtMessageBody .= "Pins &bull; Framed Stamps &bull; Stamps on a Card &bull; Paperweight Kits</p>";
				$txtMessageBody .= "<br><p align=\"center\">If you wished to be removed from our mailing list, <a href='http://www.$domainName/unsubscribe.php?email_address=$value'>click here</a>.<br>";
				$txtMessageBody .= "</p></div></body></html>";
				$txtMessageBody = stripslashes($txtMessageBody);
				mail($value, "Your Newsletter from Harmony Designs", $txtMessageBody, $headers);
				}; 
			};
		};

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<title>Newsletter Submission Screen</title>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; line-height: normal; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style1 {font-size: medium}
--></style>
	</head>
	<body bgcolor="#ffffff">
		<table width="700" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top" width="200">
					<div align="center">
						<img src="../hdlogo.gif" alt="" height="78" width="160" border="0"></div>
				</td>
				<td valign="bottom">
					<div align="center">
						<span class="title">Newsletter Submission Screen</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top"><p class="title style1">Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
                      <a href="menu.php">Back to What's New Menu</a></p></td>
				<td>				  <div align="center">

<?php
	if ($intItemFound!=0){
    	if ($featureID=="AAA")
    	{
?>						
						<p class="basetext">
                      The newsletter has been successfully added into the database.</p>
	                    <?php } else { ?>
						<p class="basetext">The newsletter has been successfully changed in the database.                         </p>
	                    <?php }; 
	} else {
	?>
						<p class="basetext">The newsletter could not be added to the database.  A newsletter with all of the same information has already been found in the database.  Either this newsletter had been entered previously or you have refreshed this page (possibly by coming back to it after viewing a different page).</p>
	
                    <?php }; ?>
					<span class="basetext">
					<?php if ($txtSendStatus=="true"){ ?>
					<p>To see the item on the newsletter page, click  <a href="../../http://hdtest.com/other/newsletterlist.php">here</a>.</p>
					<?php };?>
					<p>To get back to the main menu, click <a href="../menu.php">here</a>.</p>
					<p>To get back to the What's New menu, click <a href="menu.php">here</a>.</p>
				  </span></div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>

</html>