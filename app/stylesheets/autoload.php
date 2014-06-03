<?
# Loads all .css files within auto/
# .... (may want SOME files not auto-loaded)

header("Content-Type: text/css");

$dirname = dirname($_SERVER['REQUEST_URI']);

$cwd = opendir(dirname(__FILE__)."/autoload");
if (!$cwd) { return; } # None available, dir empty, missing, etc...
while($file = readdir($cwd))
{
	if (preg_match("/[.]css$/", $file) || preg_match("/[.]css[.]php$/", $file)) # Ends in .css or .css.php
	{
		echo "@import url(\"$dirname/autoload/$file\");\n";
	}
}
closedir($cwd);

?>
