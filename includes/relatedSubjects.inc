<?php

function getSubjectCategory($node_id, $database)
{
	$result = mysql_query ("Select * from browse_node where browse_node_id = $node_id", $database);
	$category = mysql_fetch_assoc($result);
	return $category;
}

function getSubjectAncestors($node_id, $database)
{
	$ancestors = array();
	do
	{
		$result = mysql_query ("Select * from browse_node where browse_node_id = $node_id", $database);
		$category = mysql_fetch_assoc($result);
		$ancestors[] = $category;
		$node_id = $category['parent_node'];
	} while ($node_id > 1);
	
	return array_reverse($ancestors);
}

function getSubjectSubcategories($parent_id, $database) # List of ID's
{
	$result = mysql_query ("Select * from browse_node where parent_node = $parent_id ORDER BY browse_name", $database);
	$subcategory_ids = array();
	while($subcategory = mysql_fetch_assoc($result))
	{
		$subcategories[] = $subcategory;
	}
	#error_log("GSSC ($parent_id)=".print_r($subcategories,true));

	return $subcategories;
}

function currentSubjectPath ($currentNodeID, $database) 
{
	if (!$currentNodeID) { $currentNodeID = 1; }
	$node_id = $currentNodeID;
	$child_id = null;
	$root_node_id = 1;
	$parent_ids = array();
	$nodes = array();
	$subcategories = array();

	while ($node_id > 0)
	{
		# Get current node.
		$category = getSubjectCategory($node_id, $database);
		$nodes[$node_id] = $category;
		$parent_ids[$node_id] = $category['parent_node'];

		# Get children.
		$category_children = getSubjectSubcategories($node_id, $database);
		$subcategories[$node_id] = array();
		foreach($category_children as $child)
		{
			$child_id = $child['browse_node_id'];
			$nodes[$child_id] = $child;
			if (!is_array($subcategories[$node_id])) { $subcategories[$node_id] = array(); }
			#
			$subcategories[$node_id][] = $child_id;
		}

		# Get parent, repeat.
		$node_id = $category['parent_node'];
	}

	# Now, starting at root, start going back down.
	printNode($root_node_id, $nodes, $subcategories, $currentNodeID, 10);
}

function printNode($node_id, $nodes, $subcategories, $current_id, $level)
{
	$node = $nodes[$node_id];
	$children = isset($subcategories[$node_id]) ? $subcategories[$node_id] : null;
	$has_children = ($children && count($children) > 0);
	$link_style = $has_children ? "font-weight: bold;" : "";
	$link_style .= ($node_id == $current_id) ? " text-decoration: underline; " : "";

	?>
	<a style='<?= $link_style ?>' href="/gallery/browse/<?= preg_replace("/ /", "_", $node['browse_name']) ?>"><?= $node['browse_name'] ?></a>
	<?
	# Now print children.

	if ($has_children)
	{
	?>
	<!-- <ul style='margin-left: <?= $level ?>px;' > -->
	<ul style='' >
	<?
		foreach($children as $child_id)
		{
			if ($child_id == $current_id) { 
				echo "<li id='currentNode'>";
			} else {
				echo "<li>";
			}
			printNode($child_id, $nodes, $subcategories, $current_id, $level+10);
			echo "</li>";
		}
	?>
	</ul>
	<?
	}
}

?>
