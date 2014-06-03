<?
# Loads all .css files within auto/
# .... (may want SOME files not auto-loaded)

# IE can only load 30 files, so we need to just print each out here!

header("Content-Type: text/css");

$dirname = dirname($_SERVER['REQUEST_URI']);

$cwd = opendir(dirname(__FILE__)."/autoload");
if (!$cwd) { return; } # None available, dir empty, missing, etc...
while($file = readdir($cwd))
{
	if (preg_match("/[.]css$/", $file))
	{
		$css = file_get_contents(dirname(__FILE__)."/autoload/$file");
		echo $css;
	}
	else if(preg_match("/[.]css[.]php$/", $file)) # Ends in .css or .css.php
	{
		include(dirname(__FILE__)."/autoload/$file");
	}
	#echo "@import url(\"$dirname/autoload/$file\");\n";
}
closedir($cwd);

?>
