<?php

	function generateSubjectList ($nodePath, $database) {
		if ( count($nodePath) == 1) {
			$nodeID = array_pop ($nodePath);
			$result = mysql_query ("Select * from browse_node where browse_node_id = $nodeID", $database);
			$currentNode = mysql_fetch_object ($result);
			$result = mysql_query ("Select * from browse_node where parent_node = $nodeID order by browse_name", $database);
			$childNodes = array();
			while ( $record = mysql_fetch_object ($result) ) {
				$childNodes[] = $record;
			}
			echo '<li id="currentNode">';
			echo $currentNode->browse_name;
			echo '</li><ul>';
			foreach ( $childNodes as $node ) {
				echo '<li><a href="/product/browse.php?browseNode=';
				echo $node->browse_node_id;
				echo '&resultOffset=1">';
				echo $node->browse_name;
				echo '</a></li>';
			}
			echo '</ul>';
		} else {
			$nodeID = array_pop ($nodePath);
			$targetChildID = array_pop ($nodePath);
			array_push ($nodePath, $targetChildID);
			$result = mysql_query ("Select * from browse_node where browse_node_id = $nodeID", $database);
			$currentNode = mysql_fetch_object ($result);
			$result = mysql_query ("Select * from browse_node where parent_node = $nodeID order by browse_name", $database);
			$childNodes = array();
			while ( $record = mysql_fetch_object ($result) ) {
				$childNodes[] = $record;
			}
			echo '<li><a href="/product/browse.php?browseNode=';
			echo $currentNode->browse_node_id;
			echo '&resultOffset=1">';
			echo $currentNode->browse_name;
			echo '</a></li><ul>';
			foreach ( $childNodes as $node ) {
				if ( $node->browse_node_id == $targetChildID )
					generateSubjectList ($nodePath, $database);
				else {
					echo '<li><a href="/product/browse.php?browseNode=';
					echo $node->browse_node_id;
					echo '&resultOffset=1">';
					echo $node->browse_name;
					echo '</a></li>';
				}
			}
			echo '</ul>';
		}
	return;
	}				
	
	function displaySubjectList ($nodeID, $database) {
		$currentID = $nodeID;
		$ancestorNodeIDs = array();
		while ( $currentID != 0 ) {
			$result = mysql_query ("Select parent_node from browse_node where browse_node_id = $currentID", $database);
			$record = mysql_fetch_object ($result);
			array_push ($ancestorNodeIDs, $currentID);
			$currentID = $record->parent_node;
		}
		echo '<h2>Browse Subjects</h2>';
		echo '<ul>';
		generateSubjectList ($ancestorNodeIDs, $database);
		echo '</ul>';
	}
?>
