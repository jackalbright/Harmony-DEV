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
		<title>Event Menu</title>
	    <link href="../../stylesheets/style.css" rel="stylesheet" type="text/css">
	    <style type="text/css" media="all">
	    	body	    	
	    	{
	    		width: 700px;
	    		background-color: white;
	    	}
			#head { margin-bottom: 10px; }
			#nav			
			{
				float: left;
				width: 160px;
				background-color: #EEE;
			}
			#main { margin-left: 180px; }
			#title { margin-left: 200px; }
		</style>
	</head>
 
	<body>
		<?php
		?>
		<div id="head">
			<img src="../hdlogo.gif" alt="" height="78" width="160" border="0">
			<span class="title" id="title">Event Menu</span>		
		</div>
		
		<div id="nav">
			<p class="title">Navigation:</p>
			<p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
		</div>

		<div id="main">
			<ul>
				<li>
					<span class="basetext"><a href="addevent.php">Add Event</a></span>
					<br />
					Add Events to be shown on the home page of the site. 
				</li>
				<li>
					<span class="basetext">Edit Event</span>
					<br />
					Edit the Events shown on the site. 
					<br />
					<form action="editevent.php" method="post" name="EditEvent">
						<select name="txtEventID">
							<option label="Choose an event&hellip;" disabled selected>Choose an event&hellip;</option>
							<option label="" disabled></option>
							<?php
								foreach ($events as $event) {
									echo '<option ';
									echo 'label="' . $event->intro_text . ' &#8212; (' . date('M. j, Y', $event->code_start) . ' to ' . date('M. j, Y', $event->code_end) . ')" ';
									if ( ( time() >= $event->code_start )	&& ( time() <= ($event->code_end + 86400) ) ) {
										echo 'style="color: #0C0;" ';
									} else if  ( time() < $event->code_start ) {
										echo 'style="color: #00C;" ';
									}
									echo '>'. $event->intro_text . ' &#8212; (' . date('M. j, Y', $event->code_start) . ' to ' . date('M. j, Y', $event->code_end) . ')</option>';
								}
							?>
						</select>
						<br />
						<input type="submit" name="sbEditEvent" value="Edit Event">
					</form>
				</li>
				<li>
					<span class="basetext">Delete Event</span>
					<br />
					Remove Events from the site that are either outdated or incorrect. 
					<br />
					<form action="deleteevent.php" method="post" name="EditEvent">
						<select name="txtEventID">
							<option label="Choose an event&hellip;" disabled selected>Choose an event&hellip;</option>
							<option label="" disabled></option>
							<?php
								foreach ($events as $event) {
									echo '<option ';
									echo 'label="' . $event->intro_text . ' &#8212; (' . date('M. j, Y', $event->code_start) . ' to ' . date('M. j, Y', $event->code_end) . ')" ';
									if ( ( time() >= $event->code_start )	&& ( time() <= ($event->code_end + 86400) ) ) {
										echo 'style="color: #0C0;" ';
									} else if  ( time() < $event->code_start ) {
										echo 'style="color: #00C;" ';
									}
									echo '>'. $event->intro_text . ' &#8212; (' . date('M. j, Y', $event->code_start) . ' to ' . date('M. j, Y', $event->code_end) . ')</option>';
								}
							?>
						</select>
						<br />
						<input type="submit" name="sbEditEvent" value="Delete Event">
					</form>
				</li>
			</ul>
		</div>
	</body>

</html>