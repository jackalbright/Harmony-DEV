<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 10/06/04
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
?>
<?php
    $eventID = $_POST['txtEventID'];
	include ('../../includes/database.inc');
    $result = mysql_query ("SELECT *, UNIX_TIMESTAMP(start_date) as codedStart, UNIX_TIMESTAMP(end_date) as codedEnd FROM `event` WHERE event_ID='$eventID'", $database);
    while ($event = mysql_fetch_object($result))
        {
           $startdate['month']=date('n', $event->codedStart);
           $startdate['day']=date('j', $event->codedStart);
           $startdate['year']=date('Y', $event->codedStart);
           $enddate['month']=date('n', $event->codedEnd);
           $enddate['day']=date('j', $event->codedEnd);
           $enddate['year']=date('Y', $event->codedEnd);
           $title=$event->intro_text;
           $maintext=$event->main_text;
           $txtURLAddress=$event->target_url;
           $graphicloc=$event->graphic_location;
         };
     mysql_close($database);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Delete Event</title>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; line-height: normal; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style1 {font-size: medium}
h1,h2,h3,h4,h5,h6
{
	color: #060;
	font-family: "Times", serif;
	font-weight: bold;
	margin: 0 0 5px 0;
}

h1 { font-size: 32px; }
h2 { font-size: 21px; }
h3 { font-size: 17px; }
h4 { font-size: 15px; }
h5 { font-size: 12px; }
h6 { font-size: 11px; }

a h1,a h2,a h3,a h4,a h5,a h6
{
	color: #039;
	text-decoration: none;
}

a h1:hover,a h2:hover,a h3:hover,a h4:hover,a h5:hover,a h6:hover { color: #909; }

.center { text-align: center; }

.right { text-align: right; }

a:link { color: #039; }

a:visited { color: #903; }

a:hover { color: #909; }

a:active { color: #309; }

hr.narrow { margin: 0; }
		div#rightBar { width: 172px; }		
		#rightBar .event
		{
			text-align: center;
			margin: 6px 0px 6px 0px;
		}
		#rightBar .event *
		{
			margin: 0px;
			padding: 0px;
			border: 0px;
		}

		#rightBar .event p
		{
			font-weight: bold;
			margin: 0px;
		}
		#rightBar #old-events
		{
			text-align: right;
			margin: 0px;
		}
		#rightBar ul
		{
			margin-left: 2px;
			padding-left: 1em;
			font-size: 0.9em;
		}
		#main		
		{
			width: 340px;
			float: left;
			clear: none;
		}
		#rightBar li
		{
			margin-bottom: 0.33em;
		}
		.itemDisplay		
		{
			text-align: center;
			vertical-align: top;
			width: 110px;
			padding: 0.5em 0 0.5em 0;
		}
		.itemDisplay a { text-decoration: none; }
		#itemList		
		{
			background-color: #FFFFEE;
			text-align: center;
			margin: 0 0 1em 0;
		}
		#sidebarSearchSubmit
		{
			text-align: right;
		}
		.ErrMsg { color: red; font-weight: bold; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
--></style>
<script language="javascript1.2" type="text/javascript">
	function backToMenu(){
		document.location.href="menu.php";
		return false;
	};
</script>
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
						<span class="title">Event Deletion Screen</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top"><p class="title style1">Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
                      <a href="menu.php">Back to Event Menu</a></p></td>
				<td>
					<div align="center">
					  <table width="500" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="328"><form name="formEventDelete" method="post" action="deleteevent2.php">
                            <p align="center" class="basetext">This is the event that you have selected for deletion. Are you absolutely certain that you wish to delete this event?</p>
                            <p align="center">
                              <input type="hidden" name="txtEventID" value="<?php echo $eventID; ?>">
                              <input type="submit" name="btnSubmit" value="Yes">&nbsp;&nbsp;
                              <input type="button" name="btnReturn" value="No" onClick="return backToMenu()">
</p>
                          </form></td>
                          <td width="172" valign="top" bordercolor="#000000">				<?php
				include ('../../includes/database.inc');
				$results = mysql_query ("Select * from event where event_ID='$eventID'", $database );
				$record = mysql_fetch_object ($results);
				echo '<a href="../..';
				echo $record->target_url;
				echo '"><h2>';
				echo $record->intro_text;
				echo '</h2><img src="../..';
				echo $record->graphic_location;
				echo '" border="0" /></a><p>';
				echo $record->main_text;
				echo '</p>';
			?>
</td>
                        </tr>
                      </table>
					  <span class="basetext"><p>&nbsp;</p>
					  </span></div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>

</html>