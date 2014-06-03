<?php
	function displaySubjectPulldown ($title, $database) {
		echo '<form action="/product/browse.php" method="get" id="miniBrowse" name="miniBrowse">' . "\n";
		echo '<input type="hidden" name="resultOffset" value="1" />' . "\n";
		echo '<select id="browseList" name="browseNode" onchange="document.miniBrowse.submit()">' . "\n";
		echo'<option label="' . $title . '" disabled="disabled" selected="selected" value="1">' . $title . '</option>' . "\n";
		echo'<option label=" " disabled="disabled" value="1"> </option>' . "\n";

		$result = mysql_query ("Select * from browse_node where parent_node = 1 order by browse_name", $database);
		while ( $node = mysql_fetch_object ($result) ) {
			echo '<option value="' .  $node->browse_node_id . '">';
			echo $node->browse_name;
			echo '</option>' . "\n";
		}

		echo'<option label=" " disabled="disabled" value="1"> </option>' . "\n";
		$result = mysql_query ("Select * from browse_node where browse_node_id = 1", $database);
		$node = mysql_fetch_object ($result);
		echo '<option value="' .  $node->browse_node_id . '">';
		echo $node->browse_name;
		echo '</option>' . "\n";

		echo '</select>' . "\n";
		echo '<button type="submit"value="Go">Go</button>' . "\n";
		echo '</form>' . "\n";
	}
	
	function fullCategoryName ($currentNode, $database) {
		//fetch the ancestry path for the current node
		$nodeID = $currentNode->parent_node;
		$ancestorNodes = array();
		while ($nodeID > 0) {
			$result = mysql_query ("Select * from browse_node where browse_node_id = $nodeID", $database);
			$node = mysql_fetch_object ($result);
			array_push ($ancestorNodes, $node);
			$nodeID = $node->parent_node;
		}
		array_pop($ancestorNodes);
		$fullPath = '';
		while ( $temp = array_pop($ancestorNodes) ) {
			$fullPath = $fullPath . str_replace(' ', '&nbsp;', $temp->browse_name) . ' &#62; ';
		}
		$fullPath .= str_replace(' ', '&nbsp;', $currentNode->browse_name);
		return $fullPath;
	}
?>