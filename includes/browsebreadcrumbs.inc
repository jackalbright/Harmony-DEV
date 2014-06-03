<?php
include_once ('includes/database.inc');
$bnode=$_REQUEST['browseNode'];

$nodecount=0;
$string2="";
$result = mysql_query ("Select * from browse_node", $database);

			$parent = array();			
			$name = array();			
			$child = array();			
			while ( $temp = mysql_fetch_array($result) ) {
				$node[] = $temp[0];
				$name[] = $temp[1];
				$parent[] = $temp[2];
				$nodecount=$nodecount + 1;
			}
if ($bnode!=1) {		
	for ($i=0;$i<$nodecount;$i++) {
	   if ($node[$i]==$bnode) {
	      $nodename=$name[$i];
	      $parentnum=$parent[$i];
	   }   
	}
	$string2=' &raquo; ' . $nodename;	
}


	
if ($bnode!=1) {	
	if ($parentnum!=1) {
	    for ($i=0;$i<$nodecount;$i++) {
	       if ($node[$i]==$parentnum) {
	          $nodename=$name[$i];
	          $thisparentnum=$parentnum;
	          $parentnum=$parent[$i];
	      }   
	   }
	   $stringtemp=' &raquo; <a href="browse.php?browseNode=' . $thisparentnum . '&resultOffset=1">' . $nodename . '</a>';
	   $string2=$stringtemp . $string2;
	}
}	
	
	
if ($bnode!=1) {	
	if ($parentnum!=1) {
	    for ($i=0;$i<$nodecount;$i++) {
	       if ($node[$i]==$parentnum) {
	          $nodename=$name[$i];
	          $thisparentnum=$parentnum;	          
	          $parentnum=$parent[$i];
	      }   
	   }
	   $stringtemp=' &raquo; <a href="browse.php?browseNode=' . $thisparentnum . '&resultOffset=1">' . $nodename . '</a>';
	   $string2=$stringtemp . $string2;
	}
}	

if ($bnode!=1) {		
	if ($parentnum!=1) {
	    for ($i=0;$i<$nodecount;$i++) {
	       if ($node[$i]==$parentnum) {
	          $nodename=$name[$i];
	          $thisparentnum=$parentnum;	          
	          $parentnum=$parent[$i];
	      }   
	   }
	   $stringtemp=' &raquo; <a href="browse.php?browseNode=' . $thisparentnum . '&resultOffset=1">' . $nodename . '</a>';
	   $string2=$stringtemp . $string2;
	}
}

if ($bnode!=1) {	
	if ($parentnum!=1) {
	    for ($i=0;$i<$nodecount;$i++) {
	       if ($node[$i]==$parentnum) {
	          $nodename=$name[$i];
	          $thisparentnum=$parentnum;	          
	          $parentnum=$parent[$i];
	      }   
	   }
	   $stringtemp=' &raquo; <a href="browse.php?browseNode=' . $thisparentnum . '&resultOffset=1">' . $nodename . '</a>';
	   $string2=$stringtemp . $string2;
	}

}
	
$string1='<span class="breadcrumbs"><a href="../index.php">Home</a> &raquo; <a href="browse.php?browseNode=1&resultOffset=1">All Subjects</a>' . $string2;

echo $string1 . '</span>';

?>
