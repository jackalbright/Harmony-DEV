<?
class ArchiveComponent extends Object
{
	var $name = 'Archive';

	function startup(&$controller)
	{
		App::import("Vendor", "pear", array('file'=>'pear.inc.php'));
		require_once("Archive/Tar.php");
	}

	function extract($file, $destination = null)
	{
		if(empty($destination)) { $destination = APP."/../"; }
		$tar = new Archive_Tar($file);
		return $tar->extract($destination);
	}
}
?>
