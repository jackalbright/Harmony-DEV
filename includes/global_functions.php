<?
function get_domain()
{
	$host = $_SERVER['HTTP_HOST'];
	$host_parts = split("[.]", $host);
	#error_log("HP=".print_r($host_parts,true));
	if (count($host_parts) > 2) { array_shift($host_parts); } # Get rid of first part if more than 2.
	$domain = join(".", $host_parts);
	#error_log("DOMAIN=$domain");
	return $domain;
}
?>
