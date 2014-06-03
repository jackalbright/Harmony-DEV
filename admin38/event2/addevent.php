<?php
/******************************************************************************************
Edited by: John Plecenik
Last edited: 8/16/04
******************************************************************************************/
	session_start();
	if ( !array_key_exists('UName', $_SESSION) ) {
		header ('Location: ../index.php');
		exit (0);
	} else {
		$manageOrders=$_SESSION['canManageOrders'];
		$manageParts=$_SESSION['canManageParts'];
		$manageUsers=$_SESSION['canManageUsers'];
		$manageItems=$_SESSION['canManageItems'];
		$manageEvents=$_SESSION['canManageEvents'];
		$manageDatabase=$_SESSION['canManageDatabase'];
		$manageTestimonials=$_SESSION['canManageTestimonials'];
	}
	if ( !$_SESSION['canManageEvents']=="Yes" ) {
		header ('Location: ../menu.php');
		exit (0);
	}
	
	include_once ('../../includes/database.inc');
	$events = array();
	$result = mysql_query ("SELECT event_ID, intro_text, UNIX_TIMESTAMP(start_date) as code_start, UNIX_TIMESTAMP(end_date) as code_end FROM event ORDER BY start_date, end_date", $database);
	while ( $temp = mysql_fetch_object($result) ) {
		$events[] = $temp;
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="BBEdit">
		<title>Event Addition Page</title>
	    <link href="../../stylesheets/style.css" rel="stylesheet" type="text/css">
	    <style type="text/css" media="all">
	    	body	    	
	    	{
	    		width: 700px;
	    		background-color: white;
	    	}
			#head {margin-bottom: 10px; }
			#nav			
			{
				float: left;
				width: 160px;
				background-color: #EEE;
			}
			#main			
			{
				margin-left: 180px;
				background-color: #EEF;
			}
			#title { margin-left: 200px; }
			.note			
			{
				font-size: smaller;
				font-style: italic;
			}
			td.formLabel			
			{
				text-align: right;
				font-weight: normal;
				width: 100px;
				vertical-align: top;
				font-size: smaller;
			}
			td.formInput {
				text-align: left;
			}
			td { padding: 6px 0 0 0; }
		</style>
		<script language="javascript" type="text/javascript">
			function changeGraphic() {
				
			}
		</script>
	</head>

	<body>
		<div id="head">
			<img src="../hdlogo.gif" alt="" height="78" width="160" border="0">
			<span class="title" id="title">Event Addition Page</span>
		</div>

		<div id="nav">
			<p>
				<span class="title">Navigation:</span><br />
				<a href="../menu.php">Back to Main Menu</a><br />
				<a href="menu.php">Back to Event Menu</a>
			</p>
			<p class="title">Event Preview:</p>
			<div id="preview">
				<h3 id="titlePrev">Event Title</h3>
				<img id="eventGraphic" src="../../event-images/blank.gif" width="160" height="160">
				<div id="textPrev">Event Text</div>
			</div>
		</div>

		<div id="main">
			<form action="addevent.php" method="post">
				<table>
					<tr>
						<td class="formLabel">Event Title:</td>
						<td class="formInput"><input type="text" id="eventTitle" name="eventTitle" size="50" maxlength="200"></td>
					</tr>
					<tr>
						<td class="formLabel">Event Text:</td>
						<td class="formInput"><textarea id="eventText" name="eventText" rows="5" cols="50"></textarea></td>
					</tr>
					<tr>
						<td class="formLabel">Event Graphic:</td>
						<td class="formInput"><input type="text" id="eventGraphic" name="eventGraphic" size="50" maxlength="200" value="/event-images/" onchange="javascript:changeGraphic();"></td>
					</tr>
					<tr>
						<td class="formLabel">Target Page:</td>
						<td class="formInput">
							<input type="radio" id="eventTarget" name="eventTarget" value="productDetail">
							<select id="detailPage" name="detailPage">
								<option label="Product Detail Page&hellip;" disabled selected>Product Detail Page&hellip;</option>
								<option label="" disabled></option>
							</select>
							<br />
							<input type="radio" id="eventTarget" name="eventTarget" value="categoryPage">
							<select id="categoryPage" name="categoryPage">
								<option label="Product Detail Page&hellip;" disabled selected>Category Page&hellip;</option>
								<option label="" disabled></option>
							</select>
							<br />
							<input type="radio" id="eventTarget" name="eventTarget" value="searchResult">
							<input id="searchTerms" name="searchTerms" type="text" value="Search for terms" size="20" maxlength="200">
							<br />
							<input type="radio" id="eventTarget" name="eventTarget" value="directLink">
							<input id="linkPage" name="linkPage" type="text" value="Arbitrary Page" size="30" maxlength="200">
							<br />
						</td>
					</tr>
					<tr>
						<td class="formLabel">Start Date:</td>
						<td class="formInput">
							<input type="text" id="startMonth" name="startMonth" size="2" maxlength="2" value="<?php echo date('m'); ?>">
							/
							<input type="text" id="startDay" name="startDay" size="2" maxlength="2" value="<?php echo date('d'); ?>">
							/
							<input type="text" id="startYear" name="startYear" size="4" maxlength="4" value="<?php echo date('Y'); ?>">
							<span class="note">(mm/dd/yyyy)</span>
						</td>
					</tr>
					<tr>
						<td class="formLabel">End Date:</td>
						<td class="formInput">
							<input type="text" id="endMonth" name="endMonth" size="2" maxlength="2" value="<?php echo date('m'); ?>">
							/
							<input type="text" id="endDay" name="endDay" size="2" maxlength="2" value="<?php echo date('d'); ?>">
							/
							<input type="text" id="endYear" name="endYear" size="4" maxlength="4" value="<?php echo date('Y'); ?>">
							<span class="note">(mm/dd/yyyy)</span>
						</td>
					</tr>
				</table>
			</form>
			<iframe></iframe>
		</div>
	</body>

</html>