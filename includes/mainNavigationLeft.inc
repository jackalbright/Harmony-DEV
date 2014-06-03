<?php
	include ('sidebarSearch.inc');
?>
<!--Begin Subject/Product Navigation-->
<?php
	include_once ('subjectPulldown.inc');
	displaySubjectPulldown('Shop by Subject', $database);
?>
<hr />
<?php
	include ('products.inc');
?>
<!--End Subject/Product Navigation-->
