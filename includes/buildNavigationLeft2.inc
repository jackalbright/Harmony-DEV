<?php
	include_once ('browseNavigationLeft2.inc');
?>
<!--Begin Subject/Product Navigation-->
<?php
	include_once ('relatedSubjects.inc');
?>
<div id="subjectList" style="margin-top:25px;">
	<h4>Related Subjects</h4>
	<?php
		$result = mysql_query ("Select browse_node_id from browse_link where catalog_number = '$catalogNumber'", $database);
		$browsePaths = array();	
		while ( $record = mysql_fetch_object ($result) ) {
			$temp = array();
			$currentID = $record->browse_node_id;
			while ($currentID != 1) {
				$result2 = mysql_query ("Select * from browse_node where browse_node_id = $currentID", $database);
				$node = mysql_fetch_object ($result2);
				array_push ($temp, $node);
				$currentID = $node->parent_node;
			}
			array_push ($browsePaths, $temp);
		}
		$result = mysql_query ("Select * from browse_node where parent_node = 0", $database);
		$rootNode = mysql_fetch_object ($result);
		echo '<ul><li><a href="/product/browse.php?browseNode=';
		echo $rootNode->browse_node_id;
		echo '&resultOffset=1">';
		echo $rootNode->browse_name;
		echo '</a></li>';
		
		foreach ($browsePaths as $path) {
			$levels = count($path);
			while ( count($path) > 1 ) {
				$node = array_pop ($path);
				echo '<ul><li><a href="/product/browse.php?browseNode=';
				echo $node->browse_node_id;
				echo '&resultOffset=1">';
				echo $node->browse_name;
				echo '</a></li>';
			}
			$node = array_pop ($path);
			echo '<ul><li><a href="/product/browse.php?browseNode=';
			echo $node->browse_node_id;
			echo '&resultOffset=1">';
			echo $node->browse_name;
			echo '</a>';
			echo '</li></ul>';
			for ($i=1; $i < $levels; $i++) {
				echo '</ul>';
			}
		}
		
		echo '</ul>'; // close the root node unordered list
	?>
</div>
<!--End Subject/Product Navigation-->
