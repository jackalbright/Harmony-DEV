<?
# Loads all .css files within auto/
# .... (may want SOME files not auto-loaded)

function import_dir($dir, $dirname)
{
	#echo "#$dir\n\n";
	$cwd = opendir($dir);
	if (!$cwd) { return; } # None available, dir empty, missing, etc...
	while($file = readdir($cwd))
	{
		if (is_dir("$dir/$file") && !preg_match("/^[.]/", $file))
		{
			#echo "# READ=$file\n";
			import_dir("$dir/$file", "$dirname/$file");
		} else if (preg_match("/[.]css$/", $file) || preg_match("/[.]css[.]php$/", $file)) # Ends in .css or .css.php
		{
			echo "@import url(\"$dirname/$file\");\n";
		}
	}
	closedir($cwd);
}

header("Content-Type: text/css");

$dirname = dirname($_SERVER['REQUEST_URI']);
import_dir(dirname(__FILE__)."/autoload", "$dirname/autoload");


?>

#container
{
	width: 100% !important;
}
