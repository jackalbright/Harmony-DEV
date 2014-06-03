<?
error_log("START");

class JokeController extends Controller
{
	var $name = "Joke";
	var $uses = array();

	function beforeFilter()
	{
		error_log("BEFORE");
return parent::beforeFilter();
	}
	function index()
	{
		error_log("INDEX");
		header("Content-Type: text/plain");
		echo "OK";
		exit(0);
	}

}
