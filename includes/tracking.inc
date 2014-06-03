<?
include_once(dirname(__FILE__)."/database.inc");

return; # asking for session_id is causing session to start, causing us to not properly adjust session past this point. should be moved to cake and in beforeRender

global $database;


#print_r($_SERVER);
#print_r($_COOKIE);

$sessid = session_id();
if(empty($sessid)) { session_start(); }

$sessid = !empty($_COOKIE['PHPSESSID']) ? $_COOKIE['PHPSESSID'] : session_id(); # If no session_id yet, guess from what will be sent!
$customerlogin = !empty($_COOKIE['customerlogin']) ? $_COOKIE['customerlogin'] : null;
list($customer_id) = explode('x', $customerlogin);

$browser = !empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
$complete_referer = $referer = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "";
$referer_query_string = "";
$referer_url_parts = explode("?", $complete_referer);
if(count($referer_url_parts) > 1) { $referer = $referer_url_parts[0]; $referer_query_string = $referer_url_parts[1]; }

$address = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "";
$complete_url = $url = !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : "";
$query_string = "";
$url_parts = explode("?", $complete_url);
if(count($url_parts) > 1) { $url = $url_parts[0]; $query_string = $url_parts[1]; }
$date = date("Y-m-d H:i:s");

$method = $_SERVER['REQUEST_METHOD'];
#if (!$method) { $method = 'GET'; }
#error_log(print_r($_SERVER,true));

$internal = 0;
$internal_ips = array(
	#'10.0.0.100',
	'71.224.15.91',
	'71.224.1.11',
	'71.224.15.94',
	'69.139.23.131',
	'69.253.57.132'
);

foreach($internal_ips as $internal_ip)
{
	if ($address === $internal_ip)
	{
		$internal = 1;
	}
}

$is_bot = 0;

$bots = array(
	'Google',
        'Yahoo',
        'bot',
        'spider',
        'crawler',
        'ipMonitor',
	'ZenHTTP',	
	'searchme.com',
	'Validator',
);

foreach($bots as $bot)
{
	if (preg_match("/$bot/i", $browser) || $browser == "") { $is_bot = 1; }
}

$bot_ips = array(
	'65[.]55', # microcrapt
	'124[.]115', # china
	'58[.]61[.]164',
	'208[.]78[.]245[.]194',
);

foreach($bot_ips as $botip)
{
	if (preg_match("/^$botip/i", $address)) { $is_bot = 1; }
}

$malysoft = preg_match("/malysoft/", $_SERVER['HTTP_HOST']);

#error_log("MS=$malysoft");

# IGNORE proxy jerks
if (preg_match("/http:\/\/.*index.html/", $url)) { $is_bot = 1; }

$insert = "INSERT INTO tracking_requests SET 
	customer_id = '$customer_id',
	session_id = '$sessid',
	address = '$address',
	internal = '$internal',
	browser = '$browser',
	is_bot = '$is_bot',

	date = '$date',
	complete_url = '$complete_url',
	url = '$url',
	query_string = '$query_string',
	method = '$method',
	complete_referer = '$complete_referer',
	referer = '$referer',
	referer_query_string = '$referer_query_string'
	";


	if ($malysoft || (!$is_bot && !$internal))
	{
		#error_log("INS=$insert");
		mysql_query($insert, $database);
	}
	# DONT BOTHER TRACKING BOTS, self, etc... NO POINT, makes Db HUGE

$source_site = "";
$source_query_string = "";
$source_search = "";

if ($referer != "")# && !preg_match("/harmonydesigns|malysoft/", $referer))
{
	$source_site = $referer;
	$source_query_string = $referer_query_string;

	parse_str($source_query_string, $qs);

	if(!empty($qs['q']))
	{
		$source_search = $qs['q'];
	} else if (!empty($qs['p'])) { 
		$source_search = $qs['p'];
	} else if (!empty($qs['query'])) { 
		$source_search = $qs['query'];
	}

	# NOW parse through query string and get search.
}


$now = date("Y-m-d H:i:s");

$landingpage_url = $url;
$landingpage_query_string = $query_string;
$lastpage_url = $url;
$lastpage_query_string = $query_string;

$session_data = array(
	'page_count'=>1,
	'visit_count'=>1,
	'session_start'=>$now,
	'session_end'=>$now,
	'session_id'=>$sessid,
	'address'=>$address,
	'customer_id'=>$customer_id,
	'referral_source'=>$source_site,
	'referer_query_string'=>$source_query_string,
	'referer_search'=>$source_search,
	'landingpage_url'=>$landingpage_url,
	'landingpage_query_string'=>$landingpage_query_string,
	'lastpage_url'=>$lastpage_url,
	'lastpage_query_string'=>$lastpage_query_string,
);

# If no session entry in the last 30 minutes, track as new session. Mark external source, too.
# IF NOT MET IN THRESHOLD, LIKELY A SUCCESSIVE VISIT.
$time_threshold = "30"; # In minutes.
if(empty($internal))
{
	if (0 === update_db_record("tracking_visits", 
		array("page_count = page_count+1",'session_end'=>$now,'customer_id'=>$customer_id,'lastpage_url'=>$lastpage_url,'lastpage_query_string'=>$lastpage_query_string),
		array('session_id'=>$sessid,"DATE_ADD(session_end, INTERVAL $time_threshold MINUTE) >= NOW() LIMIT 1")
		))
	{
		# NO RECORDS FOUND.
		#echo "NOT UPDATED, INSERTING";
		#error_log("NOT UPDATED VISIT!");
		if (!update_db_record("tracking_visits", array("page_count = page_count+1","visit_count = visit_count+1", 'session_end'=>$now,'customer_id'=>$customer_id,'lastpage_url'=>$lastpage_url,'lastpage_query_string'=>$lastpage_query_string), array('session_id'=>$sessid)))
		## Nothing in last 30 minutes, try to add new 'visit'
		{
			#error_log("NOT UPDATED VISIT 2! src=$source_site");
			# We need to track visit because still have the same session_id yet 
			
			# Never went to site before.
			if ($source_site) { # Only if not in middle of session...
				$rc = insert_db_record("tracking_visits", $session_data);
			}
		}
	} else {
	}

}





?>
