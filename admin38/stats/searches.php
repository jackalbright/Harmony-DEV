<?php
	include_once ('../../includes/baseSecurity.inc');
	session_start();
	if (!array_key_exists('UName', $_SESSION)){
		header ('Location: /admin38/index.php');
		exit(0);
	} else {
		$manageOrders=$_SESSION['canManageOrders'];
		$manageParts=$_SESSION['canManageParts'];
		$manageUsers=$_SESSION['canManageUsers'];
		$manageItems=$_SESSION['canManageItems'];
		$manageEvents=$_SESSION['canManageEvents'];
		$manageDatabase=$_SESSION['canManageDatabase'];
		$manageTestimonials=$_SESSION['canManageTestimonials'];
	};

	include_once ('../../includes/database.inc');

	$start = date('Y-m-j', time() - 1209600); 
	$stop = date('Y-m-j', time());	
	if ( array_key_exists('start', $_POST) ) {
		$start = $_POST['start'];
		$stop = $_POST['stop'];
	}
	$dbStop = date('Y-m-j', strtotime("$stop") + 86400);
	$result = mysql_query ("Select * from searches where time >= '$start' && time < '$dbStop' order by time DESC", $database);
	$searches = array();
	while ( $temp = mysql_fetch_object($result) ) {
		$searches[] = $temp;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Search Statistics - Harmony Designs Inc.</title>
	<meta name="generator" content="BBEdit 7.1.4" />
	<link rel="stylesheet" href="/admin38/style/base.css" type="text/css" media="all" />
	<link rel="alternate stylesheet" href="/admin38/style/print.css" type="text/css" media="all" title="print" />
</head>
<body>
	<div id="header">
		<img src="/admin38/hdlogo.gif" alt="Harmony Designs Logo" id="logo" width="160" height="78" />
		<h1 id="title">Search Statistics</h1>
	</div>
	<div id="leftBar">
		<h4>Navigation</h4>
		<ul>
			<li><a href="../menu.php">Main Menu</a></li>
			<ul>
				<li><a href="index.php">Statistics Menu</a></li>
			</ul>
		</ul>
	</div>
	<div id="main">
		<form action="searches.php" method="post">
			Start Date:<input type="text" name="start" size="20" value="<?php echo $start ?>" />
			End Date:<input type="text" name="stop" size="20" value="<?php echo $stop ?>" />
			<button type="submit">Submit</button>
		</form>
		<p class="note">Results for <?php echo count($searches); ?> searches.</p>
		<table class="center">
			<tr>
				<td id="spacer">&nbsp;</td>
				<th>Search Terms</th>
				<th class="count">Stamps</th>
				<th class="count">Categories</th>
				<th class="count">Products</th>
				<th class="count">Pages</th>
				<th>Time</th>
			</tr>
			<?php
				foreach ($searches as $search) {
					if ($search->stampCount == 0 && $search->catCount == 0 && $search->productCount == 0 && $search->pageCount == 0)
						echo "<td class=\"flag\"><span>X</span></td>\n";
					else
						echo "<td></td>\n";
					echo "<td>" . $search->search_string . "</td>\n";
					echo "<td>" . $search->stampCount . "</td>\n";
					echo "<td>" . $search->catCount . "</td>\n";
					echo "<td>" . $search->productCount . "</td>\n";
					echo "<td>" . $search->pageCount . "</td>\n";
					echo "<td>" . date('n/j/y Hi', strtotime($search->time)) . "h</td>\n";
					echo "</tr>\n";
				}
			?>
		</table>
		<p class="note">
			Searches are ordered by time. Queries with no results are flagged.
		</p>
	</div>
</body>
</html>
