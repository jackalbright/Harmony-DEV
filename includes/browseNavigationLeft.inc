<?php
	include ('sidebarSearch.inc');
?>
<!--Begin Subject/Product Navigation-->
<?php
	include_once ('relatedSubjects.inc');
	echo '<h4>Browse Subjects</h4>';
	echo '<div id="subjectList">' . "\n";
	currentSubjectPath ($browseNode, $database);
	echo '</div>' . "\n";
?>
<hr />
<?php
	include ('products.inc');
?>
<!--End Subject/Product Navigation-->
