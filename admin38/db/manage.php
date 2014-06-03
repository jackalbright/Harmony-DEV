<?

include("../../classes/AdminPage.class.php");

class DBManagePage extends AdminPage
{
	var $body_title = "Manage Records";

	function process()
	{
		# Path is /table/action/id, etc...

		# Will load template accordingly....

		# If we need to customize, we can turn into class and subclass....
	}

}

$page = new DBManagePage(); $page->display();

?>
