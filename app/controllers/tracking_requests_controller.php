<?php
class TrackingRequestsController extends AppController {

	var $name = 'TrackingRequests';
	var $helpers = array('Html', 'Form');
	var $uses = array('TrackingRequest','TrackingProductCalculatorRequest','Customer','CustomImage','CartItem',"TrackingSession","Purchase",'UpdateComment');
	var $components = array("GeoIp","Chart");

	function beforeFilter()
	{
		if (isset($_REQUEST['date_start']))
		{
			$this->Session->write("admin.tracking_requests.date_start", $_REQUEST['date_start']);
		}
		if (isset($_REQUEST['date_end']))
		{
			$this->Session->write("admin.tracking_requests.date_end", $_REQUEST['date_end']);
		}


		parent::beforeFilter();
	}

	function beforeRender()
	{
		parent::beforeRender();
		$this->set("tracking_requests", $this->Session->read("admin.tracking_requests"));

		if(empty($this->viewVars["date_start"]))
		{
		$this->set("date_start", $this->Session->read("admin.tracking_requests.date_start"));
		}
		if(empty($this->viewVars["date_start"]))
		{
		$this->set("date_end", $this->Session->read("admin.tracking_requests.date_end"));
		}
	}

	function index() {
		$this->TrackingRequest->recursive = 0;
		$this->set('trackingRequests', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid TrackingRequest.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('trackingRequest', $this->TrackingRequest->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->TrackingRequest->create();
			if ($this->TrackingRequest->save($this->data)) {
				$this->Session->setFlash(__('The TrackingRequest has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TrackingRequest could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid TrackingRequest', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->TrackingRequest->save($this->data)) {
				$this->Session->setFlash(__('The TrackingRequest has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TrackingRequest could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TrackingRequest->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for TrackingRequest', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->TrackingRequest->del($id)) {
			$this->Session->setFlash(__('TrackingRequest deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function admin_index()
	{
		# Index page of possible reports.
		if (!empty($this->data))
		{
			foreach($this->data as $key => $val)
			{
				$this->Session->write("admin.tracking_requests.$key", $val);
			}
		}

		$this->data = $this->Session->read("admin.tracking_requests");
		if (empty($this->data['date_start']))
		{
			$this->data['date_start'] = date("Y-m-d");
		}
		if (empty($this->data['date_end']))
		{
			$this->data['date_end'] = date("Y-m-d");
		}
		#print_r($this->data);
		$this->Session->write("admin.tracking_requests", $this->data);
	}

	function admin_top_companies($days = 1)
	{
		$visitors = $this->admin_top_visitors($days);
		#echo "V=".print_r($visitors,true);
		$companies = array();
		foreach($visitors as $ip => $v)
		{
			$company = !empty($v['whois']['OrgName']) ? $v['whois']['OrgName'] : "?";
			if(empty($companies[$company])) { $companies[$company] = $v; }
			else { 
				$companies[$company]['pages'] += $v['pages'];
				foreach($v['urls'] as $url)
				{
					$companies[$company]['urls'][] = $url;
				}
				$companies[$company]['visits'] += $v['visits'];
			}
		}
		error_log("COMPANIES=".print_r($companies,true));
		#print_r($companies);
		#exit(0);
		uasort($companies, function($a,$b) {
			$sortby = 'visits'; $sortby2 = 'pages';
			if($a[$sortby] == $b[$sortby]) { 
				return $a[$sortby2] == $b[$sortby2] ? 1 : -1;
			}
			return ($a[$sortby] < $b[$sortby]) ? 1 : -1;

		});
		$this->set("visitors", $companies);
		$this->action = 'admin_top_visitors';
	}

	function admin_top_visitors($days = 1)
	{
		$this->set("start", $start = date("Y-m-d", time()-$days*60*60*24));
		$this->set("finish", $finish = date("Y-m-d", time()));

		set_time_limit(0); # Wait forever.
		# ON LANDING PAGES ONLY
		$visitors = $this->TrackingRequest->find('all', array('fields'=>array('address','COUNT(*) AS count', 'url','session_id','query_string','referer'), 'conditions'=>array("url LIKE '/details/%'", "referer NOT LIKE '%harmonydesigns.com'", 'date >='=>date("Y-m-d", time()-$days*60*60*24)), 'group'=>'session_id'));
		$data = array();
		error_log("DONE VISIT QUERY, TOTAL=".count($visitors));
		$i = 0;
		foreach($visitors as $v)
		{
			$ip = $v['TrackingRequest']['address'];
			$url = $v['TrackingRequest']['url'];
			$session = $v['TrackingRequest']['session_id'];
			$referer = $v['TrackingRequest']['referer'];
			$count = $v[0]['count'];

			if(!empty($data[$ip]))
			{
				$data[$ip]['pages'] += $count;
				if(!in_array($url, $data[$ip]['urls'])) 
				{
					$data[$ip]['urls'][] = $url;
				}
				if(!in_array($session, $data[$ip]['sessions'])) 
				{ 
					$data[$ip]['sessions'][] = $session;
				}
				$data[$ip]['visits']++;
			} else {
				$whois = $this->whois($ip);
				$geoip = $this->GeoIp->lookupIP($ip);
				$data[$ip] = array('ip'=>$ip,'pages'=>$count,'whois'=>$whois,'geoip'=>$geoip,'visits'=>1,'sessions'=>array(),'referers'=>array(),'urls'=>array($url),'keywords'=>array());
			}
			if(empty($data[$ip]['visit']))
			{
				$visit = $this->TrackingVisit->find('first', array('fields'=>array('referral_source','referer_query_string','referer_search'),'conditions'=>array("session_end >="=>$start, "session_start <="=>$finish, 'session_id'=>$session)));
				$keywords = null;
				if(!empty($visit))
				{
					$keywords = $visit['TrackingVisit']['referer_search'];
					if(empty($data[$ip]['keywords'])) { $data[$ip]['keywords'] = array(); }
					if(!empty($keywords)) { $data[$ip]['keywords'][] = $keywords; }

					$ref = $visit['TrackingVisit']['referral_source'].'?'.$visit['TrackingVisit']['referer_query_string'];
					$data[$ip]['visit'] = $visit;
					if(empty($data[$ip]['referers'])) { $data[$ip]['referers'] = array(); }
					$data[$ip]['referers'][] = $ref;
				}

			}
			if(empty($data[$ip]['sessions'])) { $data[$ip]['sessions'] = array(); }
			$data[$ip]['sessions'][$session] = !empty($keywords) ? $keywords : $session;
			error_log($i++);
		}
		error_log("DONE WHOIS, GEOIP");
		$this->set("visitors", $data);


		error_log("VISITORS=".print_r($data,true));

		return $data; # For internal use.
	}

	function whois($ip)
	{
		$w = $this->whois_server('whois.iana.org', $ip);
		#print_r($w);
		preg_match("@whois\.[\w\.]*@si", $w, $data);
		if(empty($data)) { return array(); } # No data available.
		$server = $data[0];

		#error_log("WHOIS SERVER=$server");

		$data = $this->whois_server($server, $ip);

		#error_log("WHOIS=$data");

		$hash = array();
		$lines = explode("\n", $data);
		foreach($lines as $line)
		{
			# Some lines don't match
			if(preg_match("/^(\w+):\s+(.*)$/", $line, $match))
			{
				$key = $match[1]; $val = $match[2];
				$hash[$key] = $val;
			}
			#list($key,$val) = preg_split("/:\s+/", $line);
		}

		return $hash;
		
	}

	function whois_server($server, $ip)
	{
		#Create the socket and connect
		$f = fsockopen($server, 43, $errno, $errstr, 3);	//Open a new connection
		if(!$f)
		{
			return '';
		}
		
		#Set the timeout limit for read
		if(!stream_set_timeout($f , 3))
		{
			die('Unable to set set_timeout');	#Did this solve the problem ?
		}
		
		#Send the IP to the whois server	
		if($f)
		{
			fputs($f, "$ip\r\n");
		}
		
		if(!stream_set_timeout($f , 3))
		{
			die('Unable to stream_set_timeout');	#Did this solve the problem ?
		}
		
		//Set socket in non-blocking mode
		stream_set_blocking ($f, 0 );

		$data = "";
		
		//If connection still valid
		if($f) 
		{
			while (!feof($f)) 
			{
				while (!feof($f)) 
				{
					$data .= fread($f , 128);
				}
			}
		}

		return $data;
	}

	function performance_data()
	{
		$totalweeks = 12;
		$data = array(
			'yearweeks'=>array(),
			'landing_visits'=>array(),
			'image_uploads'=>array(),
			'cart_items'=>array(),
			'checkouts'=>array(),
			'purchases'=>array(),
			'sales'=>array(),
		);

		#$admins = array(1025, 2987, 3276, 5585); # US, ignore stats.
		$admin_rows = $this->Customer->find('all',array('conditions'=>array('is_admin'=>1)));
		$admins = Set::extract("/Customer/customer_id", $admin_rows);
		$admin_csv = join(", ", $admins);


		for($ago = 0; $ago <= $totalweeks; $ago++)
		{
			$yearweek = date("YW", strtotime("$ago weeks ago"));
			$data['yearweeks'][] = $yearweek;

			# LANDING VISITS
			#$landing_visits = $this->TrackingRequest->find('count', array('conditions'=>array(
			#	'YEARWEEK(date)'=>$yearweek,
			#	"url LIKE '/details/%'"
			#	)
			#));
			$lv = $this->TrackingVisit->query("SELECT count(DISTINCT session_id) AS count,YEARWEEK(session_start) AS yearweek FROM tracking_visits AS TrackingVisits WHERE YEARWEEK(session_start) = '$yearweek' AND landingpage_url LIKE '/details/%' ");
			$landing_visits = $lv[0][0]['count'];

			# IMAGE UPLOADS
			$image_uploads = $this->CustomImage->find('count', array('conditions'=>array(
				'YEARWEEK(submission_date)'=>$yearweek,
				'CustomImage.Customer_ID NOT'=>$admins, # May miss anonymous pics, until we log in.
			)));


			# CART ITEMS

			$cart_items = $this->TrackingRequest->find('count', array('conditions'=>array(
				'YEARWEEK(date)'=>$yearweek,
				"url LIKE '/cart/add%'",
				)
			));


			# CHECKOUT STARTS
			$checkouts = $this->TrackingRequest->find('count', array('conditions'=>array(
				'YEARWEEK(date)'=>$yearweek,
				"url = '/checkout'",
				)
			));

			# PURCHASES
			$purchases = $this->Purchase->find('count', array('conditions'=>array(
				'YEARWEEK(order_date)'=>$yearweek,
				'Purchase.Customer_ID NOT'=>$admins, # May miss anonymous pics, until we log in.
				)
			));

			# SALES
			$sales = $this->Purchase->find('first', array('conditions'=>array(
				'YEARWEEK(order_date)'=>$yearweek,
				'Purchase.Customer_ID NOT'=>$admins, # ignore our purchases.
				),'fields'=>array('SUM(Charge_Amount) AS sales'),
			));
			$sales_query = "SELECT SUM(Quantity*Price) AS sales FROM order_item JOIN purchase ON order_item.Purchase_id = purchase.purchase_id WHERE YEARWEEK(Order_date) = '$yearweek' AND purchase.Customer_ID NOT IN ($admin_csv)";
			$sales_result = $this->Purchase->query($sales_query);

			$data['landing_visits'][$yearweek] = $landing_visits;
			$data['image_uploads'][$yearweek] = $image_uploads;
			$data['cart_items'][$yearweek] = $cart_items;
			$data['checkouts'][$yearweek] = $checkouts;
			$data['purchases'][$yearweek] = $purchases;
			$data['sales'][$yearweek] = $sales_result[0][0]['sales'];
		}

		return $data;
	}

	function admin_performance()
	{
		$data = $this->performance_data();
		$this->set("data", $data);
	}

	function chart_data($queryname, $date_start, $date_end = null)
	{
		if (empty($_REQUEST['debug'])) { Configure::write("debug", 0); }
		include_once(dirname(__FILE__)."/../../includes/php-ofc-library/open-flash-chart.php");

		if (empty($date_end)) { $date_end = $date_start; }

		$querylist = array(
			# Each query is done per day...
			'daily_visitors'=>"SELECT COUNT(DISTINCT address) AS count FROM tracking_requests WHERE '%s' <= date AND date <= '%s' AND is_bot = 0 AND internal = 0",
			'visit_length'=>"SELECT AVG(UNIX_TIMESTAMP(session_end) - UNIX_TIMESTAMP(session_start)) AS count FROM tracking_visits WHERE (session_start BETWEEN '%s' AND '%s' OR session_end BETWEEN '%s' AND '%s') AND session_id != ''"
			# average session length in a day....
		);
		$query_labels = array(
			'visit_length'=>array(60, 'minutes'),
		);

		$label_factor = !empty($query_labels[$queryname]) ? $query_labels[$queryname][0] : 1;
		$label_unit = !empty($query_labels[$queryname]) ? $query_labels[$queryname][1] : "";

		$morning = date("Y-m-d 00:00:00", strtotime($date_start));
		$midnight = date("Y-m-d 23:59:59", strtotime($date_end));

		$data = array();
		$date_labels = array();
	#	error_log("M=$morning, MID=$midnight");
		$raw_data = array();
		for ($d = strtotime($morning); $d < strtotime($midnight); $d += 24*60*60)
		{
			$dstart = date("Y-m-d 00:00:00", $d);
			$dend = date("Y-m-d 23:59:59", $d);
			$query = sprintf($querylist[$queryname], $dstart, $dend, $dstart, $dend);
			$result = $this->TrackingRequest->query($query);
			$value = $result[0][0]['count'];
			$date = date("D M d Y", $d);

			$value = $value / $label_factor;

			#$data[] = $user_count;
			$raw_data[] = $value;
			$dot = new dot($value);
			$data[] = $dot->colour('#D02020')->tooltip("$date<br>#val#");

			$date_labels[] = $date;
		}

		# NEW STUFF
		$this->Chart->create($raw_data,$date_labels);
		$this->Chart->title("$queryname $label_unit $date_start - $date_end");
		$this->Chart->render();
		exit(0);


		# OLD STUFF

		$chart = new open_flash_chart();
		$title = ucwords(preg_replace("/_/", " ", $queryname));
		$chart->set_title( new title( "$title $label_unit $date_start - $date_end" ) );
		
		$def = new dot();
		$def->colour('#9C0E57')->size(4);
		
		$area = new area();
		$area->set_tooltip("#val#");
		$area->set_width( 2 );
		$area->set_default_dot_style($d);
		$area->set_colour( '#C4B86A' );
		$area->set_fill_colour( '#C4B86A' );
		$area->set_fill_alpha( 0.7 );
		$area->set_values( $data );
		
		// add the area object to the chart:
		#$chart->add_element( $area );

		$line_dot = new line();
		$line_dot->set_width(2);
		$line_dot->set_colour("#DFC329");
		$line_dot->set_values($data);

		$chart->add_element($line_dot);
		
		$y = new y_axis();
		$y->set_range( 0, max($raw_data)*1.25,ceil(max($raw_data)/20));#0, 16000, 1000 );

		$max_points = 20;
		$data_count = count($data);

		#$steps = $max_points < $data_count ? ceil($data_count/$max_points) : 1;
		$steps = $max_points < $data_count ? 7 : 1;
	#	error_log("STEPS=$steps, DC=$data_count, MAX=$max_points");

		$x = new x_axis();
		$x->set_steps($steps);
		
		$x_labels = new x_axis_labels();
		$x_labels->set_colour("#ff0000");
		$x_labels->rotate(45);
		$x_labels->set_labels($date_labels);
		$x_labels->set_steps($steps);
		
		$x->set_labels($x_labels);

		$chart->set_x_axis( $x );
		$chart->set_y_axis( $y );
		
		echo $chart->toPrettyString();

		exit(0);

	}

	function daily_stats_data($date_start,$date_end)
	{
		if (empty($_REQUEST['debug'])) { Configure::write("debug", 0); }
		include(dirname(__FILE__)."/../../includes/php-ofc-library/open-flash-chart.php");

		if (empty($date_end)) { $date_end = $date_start; }


		#$date_start = $this->Session->read("admin.tracking_requests.date_start");
		#$date_end = $this->Session->read("admin.tracking_requests.date_end");
error_log("RAW DS=$date_start,DE=$date_end");
		$morning = date("Y-m-d 00:00:00", strtotime($date_start));
		$midnight = date("Y-m-d 23:59:59", strtotime($date_end));

		$data = array();
		$date_labels = array();
	#	error_log("M=$morning, MID=$midnight");
		$raw_data = array();
		for ($d = strtotime($morning); $d < strtotime($midnight); $d += 24*60*60)
		{
			$dstart = date("Y-m-d 00:00:00", $d);
			$dend = date("Y-m-d 23:59:59", $d);
			$user_count = $this->TrackingRequest->find('count', array('fields'=>'DISTINCT address', 'conditions'=>"'$dstart' <= date AND date <= '$dend' AND is_bot = 0 AND internal = 0"));
		#	error_log("UC=$user_count, DS=$dstart, DE=$dend");
			$date = date("D M d Y", $d);
			#$data[] = $user_count;
			$raw_data[] = $user_count;
			$dot = new dot($user_count);
			$data[] = $dot->colour('#D02020')->tooltip("$date<br>#val#");

			$date_labels[] = $date;
		}

		$chart = new open_flash_chart();
		$chart->set_title( new title( "Daily Visitors $date_start - $date_end" ) );
		
		$def = new dot();
		$def->colour('#9C0E57')->size(4);
		
		$area = new area();
		$area->set_tooltip("#val#");
		$area->set_width( 2 );
		$area->set_default_dot_style($d);
		$area->set_colour( '#C4B86A' );
		$area->set_fill_colour( '#C4B86A' );
		$area->set_fill_alpha( 0.7 );
		$area->set_values( $data );
		
		// add the area object to the chart:
		#$chart->add_element( $area );

		$line_dot = new line();
		$line_dot->set_width(2);
		$line_dot->set_colour("#DFC329");
		$line_dot->set_values($data);

		$chart->add_element($line_dot);
		
		$y = new y_axis();
		$y->set_range( 0, max($raw_data),25);#0, 16000, 1000 );

		$max_points = 20;
		$data_count = count($data);

		#$steps = $max_points < $data_count ? ceil($data_count/$max_points) : 1;
		$steps = $max_points < $data_count ? 7 : 1;
	#	error_log("STEPS=$steps, DC=$data_count, MAX=$max_points");

		$x = new x_axis();
		$x->set_steps($steps);
		
		$x_labels = new x_axis_labels();
		$x_labels->set_colour("#ff0000");

		$x_labels->rotate(45);
		$x_labels->set_labels($date_labels);
		$x_labels->set_steps($steps);
		
		$x->set_labels($x_labels);

		$chart->set_x_axis( $x );
		$chart->set_y_axis( $y );
		
		echo $chart->toPrettyString();

		exit(0);

	}

	function admin_trends_landing() # 'landing', 'build', 'checkout'
	{
		$landing_pages = array();
		$landing_successes = array();
		$total_weeks = array();
		$weeks = array();
		$grand_total = 0;

		$date_start = null;
		$date_end = null;

		$totalweeks = 8;

		$date_end = date('Y-m-d');
		$date_start = date('Y-m-d', time()-$totalweeks*7*24*60*60);

		if(true)
		{
			$stock_items=  array('ruler','paperweightkit','tassel','dpaperweightkit','Mpaperweightkit','charm','obamaruler','bookmark_presidents');
			$stock_csv = join("|", $stock_items);

			$totals_query = "SELECT COUNT(*) AS count,YEARWEEK(date) AS yearweek FROM tracking_requests WHERE (date BETWEEN '$date_start 23:59:59' AND '$date_end 23:59:59') GROUP BY yearweek";
			$totals = $this->TrackingRequest->query($totals_query);
			$landing_query = "SELECT COUNT(*) AS count,YEARWEEK(date) AS yearweek,url FROM tracking_requests WHERE (date BETWEEN '$date_start 23:59:59' AND '$date_end 23:59:59') AND url REGEXP '^/details/[^/]*.php' GROUP BY url,yearweek ORDER BY count,yearweek DESC";
			$landing = $this->TrackingRequest->query($landing_query);


			$landing_calls_to_action = array(
				"'/cart/add'",
				"'/cart/add.php'",
				"'/custom_images/add'",
				"'/custom_images'",
				"'/gallery'",
				"'/gallery/browse'"
			);
			$cta_joined = join(",", $landing_calls_to_action);
	
			# See how much people who go to landing pages actually continue in purchase process (EFFECTIVE landing pages)
			# One query is MUCH more efficient.
			$cta_query = "SELECT COUNT(*) AS count,YEARWEEK(date) AS yearweek,url,referer FROM tracking_requests WHERE '$date_start 23:59:59' <= date AND date <= '$date_end 23:59:59' AND url IN ($cta_joined) AND referer LIKE '%/details/%.php' GROUP BY referer,yearweek ORDER BY count,yearweek DESC";
			$landing_ctas = $this->TrackingRequest->query($cta_query);
	
	
			foreach($totals as $totalrow)
			{
				$count = $totalrow[0]['count'];
				$yearweek = $totalrow[0]['yearweek'];
				$total_weeks[$yearweek] = $count;
				$grand_total += $count;
				$weeks[] = $yearweek;
			}
			foreach($landing as $page)
			{
				$count = $page[0]['count'];
				$yearweek = $page[0]['yearweek'];
				$url = $page['tracking_requests']['url'];
				$landing_pages[$url][$yearweek] = $count;
	
				# Now see how many requests continue with good call to action (cart/build/browse, etc)
	
			}
			$landing_pages = array_reverse($landing_pages);

			foreach($landing_ctas as $landing_cta)
			{
				$landing_count = $landing_cta[0]['count'];
				$referer = $landing_cta['tracking_requests']['referer'];
				$landing_url = preg_replace("/.*(\/details.*)/", "\\1", $referer);
				$landing_yearweek = $landing_cta[0]['yearweek'];
	
				$landing_successes[$landing_url][$landing_yearweek] = $landing_count;
				# TODO, loop below, finish query.
			}

			$this->set("landing_pages", $landing_pages);
			$this->set("landing_successes", $landing_successes);
			$this->set("total_weeks", $total_weeks);




		}

		$this->set("grand_total", $grand_total);
		$this->set("start_date", $date_start);
		$this->set("end_date", $date_end);
		$this->set("weeks", $weeks);


	}

	function admin_trends_landing_links() # 'landing', 'build', 'checkout'
	{
		$landing_pages = array();
		$landing_successes = array();
		$total_weeks = array();
		$weeks = array();
		$grand_total = 0;

		$date_start = null;
		$date_end = null;

		$totalweeks = 8;

		$date_end = date('Y-m-d');
		$date_start = date('Y-m-d', time()-$totalweeks*7*24*60*60);

		if(true)
		{
			$stock_items=  array('ruler','paperweightkit','tassel','dpaperweightkit','Mpaperweightkit','charm','obamaruler','bookmark_presidents');
			$stock_csv = join("|", $stock_items);

			$landing_totals_query = "SELECT COUNT(*) AS count,YEARWEEK(date) AS yearweek FROM tracking_requests WHERE (date BETWEEN '$date_start 23:59:59' AND '$date_end 23:59:59') AND url REGEXP '^/details/[^/].*.php' AND url NOT REGEXP '^/details/($stock_csv)[.]php' GROUP BY yearweek";
			$landing_totals = $this->TrackingRequest->query($landing_totals_query);

			$stock_landing_totals_query = "SELECT COUNT(*) AS count,YEARWEEK(date) AS yearweek FROM tracking_requests WHERE (date BETWEEN '$date_start 23:59:59' AND '$date_end 23:59:59') AND url REGEXP '^/details/($stock_csv)[.]php' GROUP BY yearweek";
			$stock_landing_totals = $this->TrackingRequest->query($stock_landing_totals_query);

			$landing_total = array();
			foreach($landing_totals as $landing_total_row)
			{
				$yearweek = $landing_total_row[0]['yearweek'];
				$total_count = $landing_total_row[0]['count'];
				$landing_total[$yearweek] = $total_count;
				$weeks[$yearweek] = true;
			}
			$this->set("landing_totals", $landing_total);

			$stock_landing_total = array();
			foreach($stock_landing_totals as $landing_total_row)
			{
				$yearweek = $landing_total_row[0]['yearweek'];
				$total_count = $landing_total_row[0]['count'];
				$stock_landing_total[$yearweek] = $total_count;
				$weeks[$yearweek] = true;
			}
			$this->set("stock_landing_totals", $stock_landing_total);

			$landing_calls_to_action = array(
				"'/cart/add'",
				"'/cart/add.php'",
				"'/custom_images/add'",
				"'/custom_images'",
				"'/gallery'",
				"'/gallery/browse'"
			);
			$cta_joined = join(",", $landing_calls_to_action);
	
			# See how much people who go to landing pages actually continue in purchase process (EFFECTIVE landing pages)
			# One query is MUCH more efficient.
			$cta_query = "SELECT COUNT(*) AS count,YEARWEEK(date) AS yearweek,url,referer FROM tracking_requests WHERE '$date_start 23:59:59' <= date AND date <= '$date_end 23:59:59' AND url IN ($cta_joined) AND referer LIKE '%/details/%.php' GROUP BY referer,yearweek ORDER BY count,yearweek DESC";
			#echo "CTA=$cta_query";
			$landing_ctas = $this->TrackingRequest->query($cta_query);
	
	
			foreach($landing_ctas as $landing_cta)
			{
				$landing_count = $landing_cta[0]['count'];
				$referer = $landing_cta['tracking_requests']['referer'];
				$landing_url = preg_replace("/.*(\/details.*)/", "\\1", $referer);
				$landing_yearweek = $landing_cta[0]['yearweek'];
	
				$landing_successes[$landing_url][$landing_yearweek] = $landing_count;
				# TODO, loop below, finish query.
				$weeks[$landing_yearweek] = true;
			}

			$this->set("landing_pages", $landing_pages);
			$this->set("landing_successes", $landing_successes);
			$this->set("total_weeks", $total_weeks);

			# Now get general effectivenss of links on landing pages.

			$landing_links = array(
				'/cart/add'=>'Add to Cart',
				'/cart/add.php'=>'Add to Cart',
				'/custom_images/add'=>'Upload Image',
				'/custom_images'=>'Browse Existing Images',

				'/sample_requests/add'=>'Request Sample',
				'/quote_requests/add'=>'Request Custom Quote',
				'/templates/add'=>'Request Template',

				'/info/testimonials.php'=>'Reviews',
				'/info/contact_us.php'=>'Contact Us',
				'/index.php'=>'Home Page',
				'/gallery'=>'Choose Image (4-Step)',
				'/gallery/browse'=>'Browse Stamps',
				'/info/about.php'=>'About Us',
				'/info/faq.php'=>'FAQ',
				'/info/sitemap.php'=>'Sitemap',
				'/product/search.php'=>'Search',
				'/products/shipping'=>'Shipping Page',
				'/products'=>'Browse All Products',
				'/products/quantityPricing'=>'Pricing Page',
				'/products/wholesale_pricing'=>'Wholesale Pricing Page',
			);
			$this->set("landing_links", $landing_links);


			$landing_links_csv = "";
			foreach($landing_links as $link => $linkname) { $landing_links_csv .= (!empty($landing_links_csv)?",":"") . "'$link'"; }

			$links_query = "SELECT COUNT(*) AS count,YEARWEEK(date) AS yearweek,url FROM tracking_requests WHERE '$date_start 23:59:59' <= date AND date <= '$date_end 23:59:59' AND url IN ($landing_links_csv) AND referer LIKE '%/details/%.php' AND referer NOT REGEXP '.*/details/($stock_csv)[.]php' GROUP BY url,yearweek ORDER BY yearweek DESC, count DESC";
			$landing_links_result = $this->TrackingRequest->query($links_query);
			#echo "LINKS_Q=$links_query<br/>";

			$links_count = array();

			# Have it sorted beforehand - the most clicks for the most recent week.
			foreach($landing_links_result as $result)
			{
				$link_count = $result[0]['count'];
				$link_yearweek = $result[0]['yearweek'];
				$link_url = $result['tracking_requests']['url'];
				$links_count[$link_url][$link_yearweek] = $link_count;
			}
			#usort($links_count, "links_sort");

			$this->set("links_count", $links_count);

			# Stock item stats.
			$stock_links_query = "SELECT COUNT(*) AS count,YEARWEEK(date) AS yearweek,url FROM tracking_requests WHERE '$date_start 23:59:59' <= date AND date <= '$date_end 23:59:59' AND url IN ($landing_links_csv) AND referer REGEXP '.*/details/($stock_csv)[.]php' GROUP BY url,yearweek ORDER BY yearweek DESC, count DESC";
			$stock_landing_links_result = $this->TrackingRequest->query($stock_links_query);
			#echo "stock_LINKS_Q=$stock_links_query<br/>";

			$stock_links_count = array();

			# Have it sorted beforehand - the most clicks for the most recent week.
			foreach($stock_landing_links_result as $result)
			{
				$link_count = $result[0]['count'];
				$link_yearweek = $result[0]['yearweek'];
				$link_url = $result['tracking_requests']['url'];
				$stock_links_count[$link_url][$link_yearweek] = $link_count;
			}
			#usort($links_count, "links_sort");

			$this->set("stock_links_count", $stock_links_count);

			# Select-Image stats (/gallery), next step
			$choose_image_links = array(
				'/custom_images'=>'View saved images',
				'/products/get_started/custom_add'=>'I want to use my own image',
				'/products/get_started/gallery'=>'I want to browse stamp images for ideas',
				'/custom_images'=>'Login to browse existing images',
				'/custom_images/add'=>'Upload image (first)',
				'/build/customize'=>'I want to continue building this product (from choose different image)',
				'/gallery/browse'=>'Browse stamps (Image Subjects NAV)',
				'/products/select'=>'Select a different product (Choose Product 4-Step)',

				'/info/testimonials.php'=>'Reviews',
				'/info/contact_us.php'=>'Contact Us',
				'/index.php'=>'Home Page',
				'/'=>'Home Page',
				'/custom_images/index/reset'=>'My Images (Header)',
				'/cart/display.php'=>'My Cart',

				'/gallery'=>'Choose Image AGAIN (4-Step) - SELF',
				'/info/about.php'=>'About Us',
				'/info/faq.php'=>'FAQ',
				'/account/login'=>'Account Login',
				'/saved_items'=>'Saved Items',
				'/build/save'=>'Save For Later',

				'/info/sitemap.php'=>'Sitemap',
				'/product/search.php'=>'Search',
				'/products/shipping'=>'Shipping Page',
				'/products'=>'Browse All Products',
				'/products/quantityPricing'=>'Pricing Page',
				'/products/wholesale_pricing'=>'Wholesale Pricing Page',
			);
			$this->set("choose_image_links", $choose_image_links);
			$choose_image_links_csv = "";
			foreach($choose_image_links as $link => $linkname) { $choose_image_links_csv .= (!empty($choose_image_links_csv)?",":"") . "'$link'"; }

			$choose_image_links_query = "SELECT COUNT(*) AS count,YEARWEEK(date) AS yearweek,url FROM tracking_requests WHERE '$date_start 23:59:59' <= date AND date <= '$date_end 23:59:59' AND url IN ($choose_image_links_csv) AND referer LIKE '%/gallery' GROUP BY url,yearweek ORDER BY yearweek DESC, count DESC";
			#echo "CILQ=$choose_image_links_query<br/>\n";
			$choose_image_links_result = $this->TrackingRequest->query($choose_image_links_query);
			foreach($choose_image_links_result as $result)
			{
				$link_count = $result[0]['count'];
				$link_yearweek = $result[0]['yearweek'];
				$link_url = $result['tracking_requests']['url'];
				$choose_image_links_count[$link_url][$link_yearweek] = $link_count;
			}

			$this->set("choose_image_links_count", $choose_image_links_count);


		}

		$this->set("grand_total", $grand_total);
		$this->set("start_date", $date_start);
		$this->set("end_date", $date_end);
		$this->set("weeks", array_keys($weeks));
	}

	function admin_trends_landing_choose() # 'landing', 'build', 'checkout'
	{
		$landing_pages = array();
		$landing_successes = array();
		$total_weeks = array();
		$weeks = array();

		$date_start = null;
		$date_end = null;

		$totalweeks = 8;

		$date_end = date('Y-m-d');
		$date_start = date('Y-m-d', time()-$totalweeks*7*24*60*60);

		if(true)
		{
			$choose_image_totals_query = "SELECT COUNT(*) AS count,YEARWEEK(date) AS yearweek FROM tracking_requests WHERE (date BETWEEN '$date_start 23:59:59' AND '$date_end 23:59:59') AND url = '/gallery' GROUP BY yearweek";
			$choose_image_totals = $this->TrackingRequest->query($choose_image_totals_query);

			$choose_image_total = array();
			foreach($choose_image_totals as $choose_image_total_row)
			{
				$yearweek = $choose_image_total_row[0]['yearweek'];
				$total_count = $choose_image_total_row[0]['count'];
				$choose_image_total[$yearweek] = $total_count;
				$weeks[$yearweek] = true;
			}
			$this->set("choose_image_totals", $choose_image_total);

			# Select-Image stats (/gallery), next step
			$choose_image_links = array(
				'/custom_images'=>'View saved images',
				'/products/get_started/custom_add'=>'I want to use my own image',
				'/products/get_started/gallery'=>'I want to browse stamp images for ideas',
				'/custom_images'=>'Login to browse existing images',
				'/custom_images/add'=>'Upload image (first)',
				'/build/customize'=>'I want to continue building this product (from choose different image)',
				'/gallery/browse'=>'Browse stamps (Image Subjects NAV)',
				'/products/select'=>'Select a different product (Choose Product 4-Step)',

				'/info/testimonials.php'=>'Reviews',
				'/info/contact_us.php'=>'Contact Us',
				'/index.php'=>'Home Page',
				'/'=>'Home Page',
				'/custom_images/index/reset'=>'My Images (Header)',
				'/cart/display.php'=>'My Cart',

				'/gallery'=>'Choose Image AGAIN (4-Step) - SELF',
				'/info/about.php'=>'About Us',
				'/info/faq.php'=>'FAQ',
				'/account/login'=>'Account Login',
				'/saved_items'=>'Saved Items',
				'/build/save'=>'Save For Later',

				'/info/sitemap.php'=>'Sitemap',
				'/product/search.php'=>'Search',
				'/products/shipping'=>'Shipping Page',
				'/products'=>'Browse All Products',
				'/products/quantityPricing'=>'Pricing Page',
				'/products/wholesale_pricing'=>'Wholesale Pricing Page',
			);
			$this->set("choose_image_links", $choose_image_links);
			$choose_image_links_csv = "";
			foreach($choose_image_links as $link => $linkname) { $choose_image_links_csv .= (!empty($choose_image_links_csv)?",":"") . "'$link'"; }

			$choose_image_links_query = "SELECT COUNT(*) AS count,YEARWEEK(date) AS yearweek,url FROM tracking_requests WHERE '$date_start 23:59:59' <= date AND date <= '$date_end 23:59:59' AND url IN ($choose_image_links_csv) AND referer LIKE '%/gallery' GROUP BY url,yearweek ORDER BY yearweek DESC, count DESC";
			#echo "CILQ=$choose_image_links_query<br/>\n";
			$choose_image_links_result = $this->TrackingRequest->query($choose_image_links_query);
			foreach($choose_image_links_result as $result)
			{
				$link_count = $result[0]['count'];
				$link_yearweek = $result[0]['yearweek'];
				$link_url = $result['tracking_requests']['url'];
				$choose_image_links_count[$link_url][$link_yearweek] = $link_count;
			}

			$this->set("choose_image_links_count", $choose_image_links_count);


		}

		$this->set("start_date", $date_start);
		$this->set("end_date", $date_end);
		$this->set("weeks", array_keys($weeks));


	}

	function links_sort($a, $b)
	{
	}

	function admin_sequence()
	{
		$date_start = $this->Session->read("admin.tracking_requests.date_start");
		$date_end = $this->Session->read("admin.tracking_requests.date_end");
		$morning = date("Y-m-d 00:00:00", strtotime($date_start));;
		$midnight = date("Y-m-d 23:59:59", strtotime($date_end));

		$landing_url = "/\/details\/*/";
		$landing_pages = $this->TrackingRequest->query("SELECT * FROM tracking_requests WHERE '$morning' <= date AND date <= '$midnight' AND 
		
		");
	}


	function admin_daily_stats() {
		#$this->TrackingRequest->recursive = 0;
		#$this->set('trackingRequests', $this->paginate());

		$date_start = $this->Session->read("admin.tracking_requests.date_start");
		$date_end = $this->Session->read("admin.tracking_requests.date_end");
		$morning = date("Y-m-d 00:00:00", strtotime($date_start));;
		$midnight = date("Y-m-d 23:59:59", strtotime($date_end));

		$page_hits = $this->TrackingRequest->find('count', array('conditions'=>"'$morning' <= date AND date <= '$midnight' AND is_bot = 0 AND internal = 0"));
		$this->set("page_hits", $page_hits);

		#$user_count = $this->TrackingRequest->find('count', array('conditions'=>"'$morning' <= date AND date <= '$midnight' AND is_bot = 0 AND internal = 0",'group'=>'address'));
		$user_count = $this->TrackingRequest->find('count', array('fields'=>'DISTINCT address', 'conditions'=>"'$morning' <= date AND date <= '$midnight' AND is_bot = 0 AND internal = 0"));
		$this->set("user_count", $user_count);

		#$top_pages = $this->TrackingRequest->find("all", array('fields'=>'COUNT(*) AS count, url', 'group'=>'url', 'conditions'=>"'$morning' <= date AND date <= '$midnight' AND is_bot = 0 AND internal = 0", 'order'=>'count DESC'));
		#$this->set("top_pages", $top_pages);

		#$last_pages = $this->TrackingRequest->query("SELECT COUNT(*) AS count, url FROM tracking_requests WHERE tracking_request_id IN (SELECT MAX(tracking_request_id) FROM tracking_requests WHERE is_bot = 0 AND internal = 0 AND '$morning' <= date AND date <= '$midnight' GROUP BY address) GROUP BY url ORDER BY count DESC");
		# THIS QUERY MESSED THINGS UP!
		
		#find("all", array('group'=>'address', 'conditions'=>"'$morning' <= date AND date <= '$midnight' AND is_bot = 0", 'order'=>'date DESC'));
		#print_r($last_pages);
		#$this->set("last_pages", $last_pages);

	}

	function admin_chart_sales($weeks = 26)
	{
		$this->admin_sales_data($weeks);

		if (empty($_REQUEST['debug'])) { Configure::write("debug", 0); }
		include_once(dirname(__FILE__)."/../../includes/php-ofc-library/open-flash-chart.php");

		$date_start = $this->viewVars['date_start'];
		$date_end = $this->viewVars['date_end'];

		$data = array();
		$labels = array();
		$weekly_sales = array_reverse($this->viewVars['weekly_sales'],true);
		ksort($weekly_sales);

		$steps = ceil($weeks / 52);

		$i = 0; foreach($weekly_sales as $yearweek => $value)
		{
			preg_match("/(\d{4})(\d{2})/", $yearweek, $match); $year = $match[1]; $week = $match[2] - 1;
			$start_date = date("D M d Y", strtotime("$year-01-01 +$week weeks Sunday"));
			$end_date = date("D M d Y", strtotime("$start_date +6 days"));

			$last_sunday = date("Y-m-d", strtotime("$start_date -7 days"));
			$this_saturday = date("Y-m-d", strtotime($end_date));

			# Get comments for prior week.
			$comments = $this->UpdateComment->find('all', array('conditions'=>array('date BETWEEN ? AND ?'=>array($last_sunday,$this_saturday))));

			$commentsText = !empty($comments) ? preg_replace('/"/', '\\"', join("\n", Set::classicExtract($comments, "{n}.UpdateComment.comments"))) : "";

			$commentsText = wordwrap($commentsText);

			$data[] = "{\"tip\": \"$#val#\n$start_date -\n$end_date\n$commentsText\", \"top\": $value }";

			#if($i++ % $steps == 0)
			#{
			$labels[] = "\"$start_date - $end_date\"";
			#} else {
			#	$labels[] = ""; # Need to fill, just skips.
			#}
		}
		error_log("WEEKS=$weeks, STEPS=$steps, DATA=".count($data).", LABLES=".count($labels));

		# Allow at MOST 52 items.

		header("Content-Type: text/plain");
		?>
		{
			"title": { "text": "<?= $weeks ?> Week Sales <?= date("D M d Y", strtotime($date_start)); ?> - <?= date("D M d Y", strtotime($date_end)); ?>",
				"style": "{font-size: 20px; color:#0000ff; font-family: Verdana; text-align: center;}"
			},
			
			"y_legend": { "text": "Dollars",
				"style": "{color: #736AFF; font-size: 12px;}"
			},
			"elements": [
				{
					"type": "bar",
					"alpha": 0.5,
					"colour":    "#9933CC",
					"text": "Weekly sales",
					"font-size": 10,
					"values": [<?= join(",", $data) ?>]
				}

			],
			"x_axis": {
				"stroke":1,
				"steps": <?= $steps ?>,
				"tick_height":10,
				"colour":"#d000d0",
				"grid_colour":"#00ff00",
				"labels": {
					"steps": <?= $steps ?>,
					"rotate": 45,
					"labels": [<?= join(",", $labels) ?>]
				}
			},
			"y_axis": {
				"stroke": 4,
				"tick_length": 3,
		    		"colour":      "#d000d0",
		        	"grid_colour": "#00ff00",
			    	"offset":      0,
				"max": <?= intval(max(array_values($weekly_sales))*1) ?>

			}

		}

		<?
		exit(0);

		$this->Chart->create($raw_data,$date_labels);
		$this->Chart->set_x_axis_steps(1);
		$this->Chart->title("Sales $date_start - $date_end");
		$this->Chart->render();
		exit(0);

	}

	function admin_sales()
	{
		$this->admin_sales_data();
	}

	function admin_sales_data($totalweeks = 26)
	{
		$date_end = date("Y-m-d 23:59:59", time());
		$date_start = date("Y-m-d 00:00:00", time() - $totalweeks*7*24*60*60);
		$this->set("date_end", $date_end);
		$this->set("date_start", $date_start);
		$weeks = array();

		$weekly_sales = array();

		for($week = 0; $week <= $totalweeks; $week++)
		{
			$yearweek = date("YW", strtotime($date_start) + $week*7*24*60*60);
			#echo "$yearweek<br/>\n";
			$weeks[] = $yearweek;
			$weekly_sales[$yearweek] = 0;
		}
		$this->set("weeks", $weeks);

		$products = $this->Product->findAll();
		$products_by_id = Set::combine($products, "{n}.Product.product_type_id", "{n}");
		$this->set("products_by_id", $products_by_id);

		$admins = $this->Customer->find('all',array('conditions'=>array('is_admin'=>1)));
		$admin_ids = Set::extract("/Customer/customer_id", $admins);
		$admin_csv = join(", ", $admin_ids);

		$sales_query = "SELECT SUM(Quantity*Price) AS sales, YEARWEEK(purchase.Order_Date) AS yearweek, product_type_id FROM order_item JOIN purchase ON order_item.Purchase_id = purchase.purchase_id AND Order_date >= '$date_start' WHERE purchase.Customer_ID NOT IN ($admin_csv) GROUP BY product_type_id,yearweek ORDER BY sales DESC, yearweek DESC";
		error_log("SQ=$sales_query");
		# Exclude billme/internal.
		$sales_data = $this->TrackingRequest->query($sales_query);

		$product_sales = array();
		$product_totals = array();
		$grand_total = 0;

		foreach($sales_data as $data)
		{
			$pid = $data['order_item']['product_type_id'];
			$sale = $data[0]['sales'];
			$yearweek = $data[0]['yearweek'];
			$product_sales[$pid][$yearweek] = $sale;
			if(empty($weekly_sales[$yearweek])) { $weekly_sales[$yearweek] = 0; }
			$weekly_sales[$yearweek] += $sale;
			if(empty($product_totals[$pid])) { $product_totals[$pid] = 0; }
			$product_totals[$pid] += $sale;
			$grand_total += $sale;
		}
		arsort($product_totals); # So get best sellin products first.


		$this->set("product_sales", $product_sales);
		$this->set("product_totals", $product_totals);
		$this->set("weekly_sales", $weekly_sales);
		$this->set("grand_total", $grand_total);
	}

	function admin_browser()
	{
		$date_start = $this->Session->read("admin.tracking_requests.date_start");
		$date_end = $this->Session->read("admin.tracking_requests.date_end");
		$morning = date("Y-m-d 00:00:00", strtotime($date_start));
		$midnight = date("Y-m-d 23:59:59", strtotime($date_end));
		$query = "SELECT count(*) AS count, browser FROM tracking_requests WHERE '$morning' <= date AND date <= '$midnight' GROUP BY browser ORDER BY count DESC";
		$browsers = $this->TrackingRequest->query($query);

		$browser_vendors = array();
		$browser_versions = array();
		$total_count = 0;

		foreach($browsers as $browser)
		{
			$name = $browser['tracking_requests']['browser'];
			$count = $browser[0]['count'];
			
			$vendor = "Other";
			$version = "";
			if (preg_match("/(MSIE) ([^;]+);/", $name, $matches))
			{
				$vendor = $matches[1];
				$version = $matches[2];
			} else if (preg_match("/(Firefox)\/(\S+)/", $name, $matches)) {
				$vendor = $matches[1];
				$version = $matches[2];
			} else if (preg_match("/(Safari)\/(\S+)/", $name, $matches)) {
				$vendor = $matches[1];
				$version = $matches[2];
			} else if (preg_match("/(Opera) (\S+)/", $name, $matches)) {
				$vendor = $matches[1];
				$version = $matches[2];
			}

			if (!isset($browser_vendors[$vendor])) { $browser_vendors[$vendor] = 0; }
			$browser_vendors[$vendor] += $count;

			if ($version != "")
			{
				if (!isset($browser_versions[$vendor])) { $browser_versions[$vendor] = array(); }
				if (!isset($browser_versions[$vendor][$version])) { $browser_versions[$vendor][$version] = 0; }
				$browser_versions[$vendor][$version] += $count;
			}

			$total_count += $count;
		}

		$this->set("browser_vendors", $browser_vendors);
		$this->set("browser_versions", $browser_versions);
		$this->set("total_count", $total_count);


	}

	function admin_page_details()
	{
		$url = $_REQUEST['path'];
		# 
		# basic stats about a page:
		#
		# how many hits
		# what pages people came from (#, %)
		# where people went to next (#, %) -- including ABANDONED
		# what search engines people came from to page (#, %, % total)
		# what keywords people searched for to find the page....
		
		# list of click streams (with longest clickstreams up top)
	}

	function admin_trail()
	{
		$url = $_REQUEST['path'];
		$landing = isset($_REQUEST['landing']);

		# If we only want records based off landing pages, just search

		# Find records whose url is the one in question.
		# If we ask for landing pages only, ensure referer is external

		# And only get requests AFTER this url's...

		# Get all requests for the page....

		$date_start = $this->Session->read("admin.tracking_requests.date_start");
		$date_end = $this->Session->read("admin.tracking_requests.date_end");
		$morning = date("Y-m-d 00:00:00", strtotime($date_start));
		$midnight = date("Y-m-d 23:59:59", strtotime($date_end));


		$query = "SELECT * FROM tracking_requests WHERE url = '$url' AND '$morning' <= date AND date <= '$midnight'";
		if ($landing) { $query .= " AND referer LIKE 'http%' AND referer NOT LIKE '%harmonydesigns.com%'"; }
		$query .= " GROUP BY address";

		# Get session_id and date.
		$users = $this->TrackingRequest->query($query);

		$user_path = array();
		$user_referers = array();
		$last_visits = array();

		foreach($users as $user)
		{
			$session_id = $user['tracking_requests']['address'];
			$user_data[$session_id] = array();
			$date = $user['tracking_requests']['date'];
			$user_referers[$session_id] = $user['tracking_requests']['complete_referer'];

			# Now for this person, get all requests after this date

			$later_requests = $this->TrackingRequest->query("SELECT * FROM tracking_requests WHERE address = '$session_id' AND date >= '$morning' AND date <= '$midnight' ORDER BY date");

			$user_path[$session_id] = array();
			foreach($later_requests as $later_request)
			{
				$later_url = $later_request['tracking_requests']['url'];
				$user_path[$session_id][] = $later_request;
				$last_visits[$session_id] = $later_request['tracking_requests']['date'];
			}
		}

		# Now we have it separated by user.

		$this->set("user_referers", $user_referers);
		$this->set("user_paths", $user_path);
		$this->set("url", $url);
		$this->set("last_visits", $last_visits);

		#print_r($user_path);
	}
	
	function admin_trail_by_search()
	{
		$search = "q=".preg_replace("/ /", "+", $_REQUEST['search']);

		$date_start = $this->Session->read("admin.tracking_requests.date_start");
		$date_end = $this->Session->read("admin.tracking_requests.date_end");
		$morning = date("Y-m-d 00:00:00", strtotime($date_start));
		$midnight = date("Y-m-d 23:59:59", strtotime($date_end));

		# Get user addresses based off of searches.

		$query = "SELECT DISTINCT session_id FROM tracking_requests WHERE '$morning' <= date AND date <= '$midnight' AND referer_query_string LIKE '%$search%'";
		$address_records = $this->TrackingRequest->query($query);

		$addressess = array();
		foreach($address_records as $address_record)
		{
			$addresses[] = $address_record['tracking_requests']['session_id'];
		}

		$user_path = array();
		$user_referers = array();
		$last_visits = array();

		foreach($addresses as $session_id)
		{
			$user_data[$session_id] = array();

			# Now for this person, get all requests after this date

			$later_requests = $this->TrackingRequest->query("SELECT * FROM tracking_requests WHERE session_id = '$session_id' AND '$morning' <= date AND date <= '$midnight' ORDER BY date");

			$user_path[$session_id] = array();
			foreach($later_requests as $later_request)
			{
				$later_url = $later_request['tracking_requests']['url'];
				$user_path[$session_id][] = $later_request;
				$last_visits[$session_id] = $later_request['tracking_requests']['date'];
			}
		}

		# Now we have it separated by user.

		$this->set("user_paths", $user_path);
		$this->set("search", $search);
		$this->set("last_visits", $last_visits);

		#print_r($user_path);
	}

	function admin_product_flow_raw()
	{
		$date_start = $this->Session->read("admin.tracking_requests.date_start");
		$date_end = $this->Session->read("admin.tracking_requests.date_end");
		$morning = date("Y-m-d 00:00:00", strtotime($date_start));
		$midnight = date("Y-m-d 23:59:59", strtotime($date_end));

		$flow_records = $this->TrackingRequest->query("SELECT * FROM tracking_requests WHERE address IN (SELECT DISTINCT address FROM tracking_requests WHERE is_bot = 0 AND internal = 0 AND url LIKE '/details/%' AND '$morning' <= date AND date <= '$midnight') AND '$morning' <= date AND date <= '$midnight' ORDER BY date ASC");
		$sequence = array();
		#print_r($flow_records);
		foreach($flow_records as $record)
		{
			$session_id = $record['tracking_requests']['address'];
			# Group by user to get individual flows.
			$sequence[$session_id][] = $record['tracking_requests']['url'];
		}

		$this->set("sequence", $sequence);
		$this->action = "product_flow_raw";
	}

	function admin_product_flow()
	{
		$sequence = $this->viewVars['sequence'];

		$page_flows = array();

		$i = 0;
		foreach($sequence as $session_id => $pages)
		{
			foreach($pages as $page)
			{
				if(!isset($page_flows[$i][$page])) { $page_flows[$i][$page] = 0; }
				$page_flows[$i][$page]++; # Add count.
			}
		}

		# Now gather percentages 
		$this->set("page_flows", $page_flows);
		$this->action = "product_flow_summary";
	}

	function admin_track_process()
	# Step within checkout process
	{
		$date_start = $this->Session->read("admin.tracking_requests.date_start");
		$date_end = $this->Session->read("admin.tracking_requests.date_end");
		$morning = date("Y-m-d 00:00:00", strtotime($date_start));
		$midnight = date("Y-m-d 23:59:59", strtotime($date_end));

		$urls = array( # Regexp.
			#'/build$',
			#'/build/quantity',
			'/build/step',
			'/build/step/quote',
			'/build/step/border',
			'/build/step/tassel',
			'/build/step/charm',
			'/build/step/personalization',
			'/build/step/comments',
			'/build/cart',

			'/cart/add',
			'/cart/display',
			'/checkout',
			'/account/signup',
			'/checkout/shipping_edit',
			'/checkout/payment_edit',
			'/checkout/review',
			'/checkout/receipt',
		);

		$important_urls = array(
			'/build/cart',
			'/cart/display',
			'/checkout',
			'/account/signup',
			'/checkout/shipping_edit',
			'/checkout/payment_edit',
			'/checkout/review',
			'/checkout/receipt',
		);

		# x% make it to url X, y% to url Y, etc...

		#$url_csv = " AND url REGEXP '(".join("|", $urls).")'";
		$pages = array();

		for($i = 0; $i < count($urls); $i++)
		{
			$url = $urls[$i];

			$records = $this->TrackingRequest->query("SELECT url, COUNT(*) AS count FROM tracking_requests WHERE '$morning' <= date AND date <= '$midnight' AND url REGEXP '$url' GROUP BY url");
	
			# Need to track where they go next....
	
			foreach($records as $record)
			{
				$url = $record['tracking_requests']['url'];
				$count = $record[0]['count'];

				# Track next pages....
	
				# Get session id's associated with pages..
				$sessid_records = $this->TrackingRequest->query("SELECT DISTINCT session_id,tracking_request_id FROM tracking_requests WHERE '$morning' <= date AND date <= '$midnight' AND url = '$url' GROUP BY session_id");
	
				$next_pages = array();
				$prev_pages = array();

				$sess_csv = "";
	
				foreach($sessid_records as $sessid_record)
				{
					$session_id = $sessid_record['tracking_requests']['session_id'];
					$tid = $sessid_record['tracking_requests']['tracking_request_id'];
					# Get next page.

					$sess_csv .= ($sess_csv ? ", " : "") . "'$session_id'";
	
					$next_page_record = $this->TrackingRequest->query("SELECT url FROM tracking_requests WHERE '$morning' <= date AND date <= '$midnight' AND session_id = '$session_id' AND tracking_request_id > '$tid' AND url != '$url' ORDER BY tracking_request_id ASC LIMIT 1");
					$prev_page_record = $this->TrackingRequest->query("SELECT url FROM tracking_requests WHERE '$morning' <= date AND date <= '$midnight' AND session_id = '$session_id' AND tracking_request_id < '$tid' AND url != '$url' ORDER BY tracking_request_id DESC LIMIT 1");
					# EXCLUDE SELF, only indicates updates, etc...
	
					if (!empty($next_page_record))
					{
						$next_page = $next_page_record[0]['tracking_requests']['url'];
						if(empty($next_pages[$next_page])) { $next_pages[$next_page] = 0; }
						$next_pages[$next_page]++;
					}
					if (!empty($prev_page_record))
					{
						$prev_page = $prev_page_record[0]['tracking_requests']['url'];
						if(empty($prev_pages[$prev_page])) { $prev_pages[$prev_page] = 0; }
						$prev_pages[$prev_page]++;
					}
	
				}

				# Now try to tally how much people go to the important pages....
				$important_re = "";
				foreach($important_urls as $iu)
				{
					$important_re .= ($important_re ? "|" : "") . "$iu";
				}
				$important_records = $this->TrackingRequest->query("SELECT session_id,url FROM tracking_requests WHERE '$morning' <= date AND date <= '$midnight' AND url REGEXP '($important_re).*' AND session_id IN ($sess_csv)");
				$important = array();
				$important_sessions = array();
				foreach($important_records as $important_record)
				{
					$important_url = $important_record['tracking_requests']['url'];
					$important_sid = $important_record['tracking_requests']['session_id'];

					if (empty($important_sessions[$important_sid.$important_url])) {
						if (empty($important[$important_url])) { $important[$important_url] = 0; }
						$important[$important_url]++;
						$important_sessions[$important_sid.$important_url] = 1;
					} 
				}
	
				$pages[$url] = array(
					'count'=>$count,
					'next_pages'=>$next_pages,
					'prev_pages'=>$prev_pages,
					'important_pages'=>$important,
				);
			}
		}

		$this->set("urls", $urls);
		$this->set("pages", $pages);
		$this->set("important_pages", $important_urls);
	}

	function admin_top_pages($filtered = false)
	{
		$date_start = $this->Session->read("admin.tracking_requests.date_start");
		$date_end = $this->Session->read("admin.tracking_requests.date_end");
		$morning = date("Y-m-d 00:00:00", strtotime($date_start));
		$midnight = date("Y-m-d 23:59:59", strtotime($date_end));

		$filtered_where = $filtered ? " AND url NOT REGEXP '^(/details|/products|/gallery/browse|/gallery/view)' AND URL NOT REGEXP '^/$'" : "";

		$records = $this->TrackingRequest->query("SELECT url, COUNT(*) AS count FROM tracking_requests WHERE '$morning' <= date AND date <= '$midnight' $filtered_where GROUP BY url ORDER BY count DESC");
		$total = 0;
		foreach($records as $rec)
		{
			$total += $rec[0]['count'];
		}
		$this->set("total", $total);

		$this->set("top_pages", $records);
	}

	function admin_pricing_calculator($sessid = '')
	{
		$date_start = $this->Session->read("admin.tracking_requests.date_start");
		$date_end = $this->Session->read("admin.tracking_requests.date_end");
		$morning = date("Y-m-d 00:00:00", strtotime($date_start));
		$midnight = date("Y-m-d 23:59:59", strtotime($date_end));

		$session = "";

		if ($sessid != "")
		{
			$session = " AND session_id = '$sessid' ";
		}

		$records = $this->TrackingProductCalculatorRequest->findAll("'$morning' <= date AND date <= '$midnight' $session", null, "date DESC");
		# GROUP BY USER...
		$calculator_users = array();
		$user_tracking_requests = array();
		foreach($records as $record)
		{
			$session_id = $record['TrackingProductCalculatorRequest']['session_id'];
			if(!isset($calculator_users[$session_id])) { $calculator_users[$session_id] = array(); }
			$calculator_users[$session_id][] = $record['TrackingProductCalculatorRequest'];
		}
		foreach($calculator_users as $session_id => $calc_req)
		{
			$user_tracking_requests[$session_id] = $this->TrackingRequest->findAll("session_id = '$session_id' AND '$morning' <= date AND date <= '$midnight'",null,"date ASC");
		}
		$this->set("user_tracking_requests", $user_tracking_requests);
		$this->set("requests", $records);
		$this->set("products", Set::combine($this->Product->findAll(), '{n}.Product.code','{n}.Product'));
		$this->set("calculator_users", $calculator_users);
	}

	function admin_next_pages()
	{
		if(!empty($this->data))
		{
			$date_start = $this->Session->read("admin.tracking_requests.date_start");
			$date_end = $this->Session->read("admin.tracking_requests.date_end");
			$morning = date("Y-m-d 00:00:00", strtotime($date_start));
			$midnight = date("Y-m-d 23:59:59", strtotime($date_end));

			$select_url = $this->data['TrackingRequest']['select_url'];
			$url = $this->data['TrackingRequest']['url'];
			if (!empty($select_url)) { $url = $select_url; $this->data['TrackingRequest']['url'] = null; }

			#$requests = $this->TrackingRequest->query("SELECT session_id FROM tracking_requests WHERE '$morning' <= date AND date <= '$midnight' AND url LIKE '$url'"

			$requests = $this->TrackingRequest->find('all',array('conditions'=>"url LIKE '$url' AND '$morning' <= date AND date <= '$midnight'","order"=>"date DESC","group"=>"session_id"));
			$session_ids = Set::extract($requests, "{n}.TrackingRequest.session_id");
			# DOESNT QUITE GET WHAT HAPPENS _AFTER_ , just IN GENERAL...

			$bad_urls = " url NOT LIKE '%ajax%' AND URL NOT LIKE '%png' AND URL NOT LIKE '%track%' ";
			$group_urls = array("/gallery/image","/build/customize");

			$requests = $this->TrackingRequest->find('all',array('fields'=>'TrackingRequest.*, COUNT(*) AS count','conditions'=>array('session_id'=>$session_ids, "'$morning' <= date AND date <= '$midnight' $bad_urls ","order"=>"date DESC","group"=>"url"))); # Get unique urls.
			$url_counts = Set::combine($requests, "{n}.TrackingRequest.url", "{n}.0.count");
			$mod_url_counts = array();
			foreach($url_counts as $u=>$c)
			{
				$found_gu = false;
				foreach($group_urls as $gu)
				{
					if(preg_match("%gu%", $u))
					{
						$found_gu = true;
						$mod_url_counts[$gu] = $c;
					}
				}
				if(!$found_gu)
				{
					$mod_url_counts[$u] = $c;
				}
			}
			$this->set("url_counts", $mod_url_counts);
		}
		$products = $this->Product->findAll();
		$this->set("products", $products);
	}

	function admin_session_search()
	{
		if(!empty($this->data))
		{
			$date_start = $this->Session->read("admin.tracking_requests.date_start");
			$date_end = $this->Session->read("admin.tracking_requests.date_end");
			$morning = date("Y-m-d 00:00:00", strtotime($date_start));
			$midnight = date("Y-m-d 23:59:59", strtotime($date_end));

			$select_url = $this->data['TrackingRequest']['select_url'];
			$url = $this->data['TrackingRequest']['url'];
			if (!empty($select_url)) { $url = $select_url; $this->data['TrackingRequest']['url'] = null; }

			$requests = $this->TrackingRequest->find('all',array('conditions'=>"url LIKE '$url' AND '$morning' <= date AND date <= '$midnight'","order"=>"date DESC","group"=>"session_id"));
			$this->set("requests", $requests);
		}
		$products = $this->Product->findAll();
		$this->set("products", $products);
	}

	function admin_session($sessid)
	{
		$this->set("products", $this->Product->findAll());
		if (!$sessid)
		{
			$this->Session->setFlash("No session specified");
			$this->redirect(array('admin'=>true,'action'=>'index'));
		}
		$date_start = $this->Session->read("admin.tracking_requests.date_start");
		$date_end = $this->Session->read("admin.tracking_requests.date_end");
		$morning = date("Y-m-d 00:00:00", strtotime($date_start));
		$midnight = date("Y-m-d 23:59:59", strtotime($date_end));

		$session_id = null;
		
		if (preg_match("/\d+[.]\d+[.]\d+[.]\d+/", $sessid)) {  # IP ADDRESS
			$requests = $this->TrackingRequest->findAll("address = '$sessid' AND '$morning' <= date AND date <= '$midnight'",null,"date ASC");
		} else if (preg_match("/@/", $sessid)) { # EMAIL
			$customer = $this->Customer->find("eMail_Address = '$sessid'");
			$customer_id = $customer['Customer']['customer_id'];

			#$requests = $this->TrackingRequest->findAll("customer_id = '$customer_id' AND '$morning' <= date AND date <= '$midnight'",null,"date ASC");
			$requests = $this->TrackingRequest->findAll("customer_id = '$customer_id'",null,"date ASC");
		} else {
			$session_id = $sessid;
			#$requests = $this->TrackingRequest->findAll("session_id = '$sessid' AND '$morning' <= date AND date <= '$midnight'",null,"date ASC");
			$requests = $this->TrackingRequest->findAll("session_id = '$sessid' ",null,"date ASC");
		}
		$this->set("requests", $requests);

		# Create sensible names, etc.
		$page_names = array(
			"/build/customize"=>"Build",
			"/gallery"=>"Select Image",
			"/custom_images"=>"View Uploaded Images",
			"/custom_images/add"=>"Custom Image Upload",
			"/cart/add"=>"Add To Cart",
			"/cart/add_consolidated"=>"Add To Cart",
			"/cart/update.php"=>"Cart Update Quantity",
			"/cart/display.php"=>"Display Cart",
			"/index.php"=>"Homepage",
			"/cart/update"=>"Cart Update Quantity",
			"/cart/display"=>"Display Cart",
			"/products"=>"All Products Page",
			"/products/select"=>"Product Select Page",
			"/"=>"Home Page",
			"/custom_images/signup"=>"Signup To Save Unsaved Images",
			"/products/quantityPricing"=>"All Products Pricing Page",
			"/account/signup_anonymous"=>"Checkout Without Creating an Account",
			"/account/signup"=>"Signup For Account",
			"/account/login"=>"Account Login",
			"/checkout/receipt"=>"Order Receipt",
			"/checkout/shipping_select"=>"Checkout Select Shipping Speed",
			"/checkout/shipping_edit"=>"Checkout Edit Shipping Address",
			"/checkout/billing_edit"=>"Checkout Edit Billing Address",
			"/checkout/payment_edit"=>"Checkout Edit Payment",
			"/checkout/contact_edit"=>"Checkout Enter Contact Info",
			"/checkout/receipt"=>"Order Receipt",
			"/checkout"=>"Checkout",
			"/info/contact_us.php"=>"Contact Page"

		);

		$products = $this->Product->findAll();
		$this->set("products", $products);

		foreach($products as $p)
		{
			$purl = "/details/".$p['Product']['prod'].".php";
			$pname = $p['Product']['name'] . " Landing Page";
			$page_names[$purl] = $pname;

			$curl = "/build/customize/".$p['Product']['code'];

			$page_names[$curl] = $p['Product']['name'] . " Build Page";
		}

		$sigreq = array();
		foreach($requests as $req)
		{
			$requrl = $req['TrackingRequest']['url'];
			foreach($page_names as $purl => $pname)
			{
				#if(preg_match("@^$purl\$@", $url))
				if($purl == $requrl)
				{
					$req['TrackingRequest']['url_name'] = $pname;
					$sigreq[] = $req;
				}
			}
			if (preg_match("@/gallery/browse/(.*)@", $requrl, $matches)) 
			{
				$req['TrackingRequest']['url_name'] = "Browse Stamps: $matches[1]";
				$sigreq[] = $req;
			}

			if (preg_match("@/gallery/view/(.*)@", $requrl, $matches)) 
			{
				$req['TrackingRequest']['url_name'] = "View Stamp: $matches[1]";
				$sigreq[] = $req;
			}

			if (preg_match("@/build/ajax_complete_step/step_(.*)@", $requrl, $matches)) {
				$req['TrackingRequest']['url_name'] = "Build Complete Step: $matches[1]";
				$sigreq[] = $req;
			}
		}
		$this->set("significant_requests", $sigreq);


		if (!count($requests))
		{
			$this->Session->setFlash("No session found");
			$this->redirect(array('admin'=>true,'action'=>'index'));
		}

		#print_r($requests);
		$ip = $requests[0]['TrackingRequest']['address'];
		$address = gethostbyaddr($ip);
		$browser = $requests[0]['TrackingRequest']['browser'];
		$referer = $requests[0]['TrackingRequest']['referer'];
		$session_id = $requests[0]['TrackingRequest']['session_id'];
		$referer_query_string = $requests[0]['TrackingRequest']['referer_query_string'];

		# Now get visit for search words....
		$visit = $this->TrackingVisit->find(" session_id = '$session_id' ");

		if(!empty($visit['TrackingVisit']['referer_search']))
		{
			$search_string = $visit['TrackingVisit']['referer_search'];
		} else {
			parse_str($referer_query_string, $qs);
			$search_string = isset($qs['q']) ? preg_replace("/[+]/", " ", $qs['q']) : "";
		}
		$customer_id = null;

		foreach($requests as $req)
		{
			if ($req['TrackingRequest']['customer_id'] > 0)
			{
				$customer_id = $req['TrackingRequest']['customer_id'];
				break;
			}
		}
		$account = null;
		$custom_images = array();
		if (!empty($customer_id)) { 
			$account = $this->Customer->read(null, $customer_id);
			$custom_images = $this->CustomImage->findAll("CustomImage.customer_id = '$customer_id'");
		}
		$session_prev = $session_next = null;
		if ($session_id)
		{
			$custom_images = $this->CustomImage->findAll("CustomImage.session_id = '$session_id'");

			#$request = $this->TrackingRequest->find(" session_id = '$session_id' ", null, "tracking_request_id");
			#$tracking_request_id = $request['TrackingRequest']['tracking_request_id'];
#
#			$prev_request = $this->TrackingRequest->find(" tracking_request_id < '$tracking_request_id' AND session_id != '$session_id' AND session_id != '' ", null, "tracking_request_id DESC");
#			$next_request = $this->TrackingRequest->find(" tracking_request_id > '$tracking_request_id' AND session_id != '$session_id' AND session_id != '' ", null, "tracking_request_id ASC");
#
#			if (!empty($prev_request)) { $session_prev = $prev_request['TrackingRequest']['session_id']; }
#			if (!empty($next_request)) { $session_next = $next_request['TrackingRequest']['session_id']; }
		}
		$cart_items = array();
		if ($customer_id || $session_id)
		{
			$cart_items = $this->CartItem->findAll("customer_id = '$customer_id' OR session_id = '$session_id'");
		}
		if (empty($custom_images)) { $custom_images = array(); }

		$purchases = array();
		if ($customer_id)
		{
			$purchases = $this->Purchase->findAll(" Purchase.customer_id = '$customer_id' ");
		}

		$location = $this->GeoIp->lookupIP($ip);
		$this->set("custom_images", $custom_images);
		$this->set("cart_items", $cart_items);
		$this->set("purchases", $purchases);

		$this->set("location", $location);
		$this->set("account", $account);
		$this->set("session_id", $sessid);
		$this->set("address", $address);
		$this->set("address_ip", $ip);
		$this->set("browser", $browser);
		$this->set("referer", $referer);
		$this->set("keywords", $search_string);
		$this->set("session_prev", $session_prev);
		$this->set("session_next", $session_next);
		$this->set("session_start", $requests[0]['TrackingRequest']['date']);
		$this->set("session_end", $requests[count($requests)-1]['TrackingRequest']['date']);
		$this->set("session_length", strtotime($requests[count($requests)-1]['TrackingRequest']['date']) - strtotime($requests[0]['TrackingRequest']['date']));
	}

	function admin_visit()
	{
		$date_start = $this->Session->read("admin.tracking_requests.date_start");
		$date_end = $this->Session->read("admin.tracking_requests.date_end");
		$morning = date("Y-m-d 00:00:00", strtotime($date_start));
		$midnight = date("Y-m-d 23:59:59", strtotime($date_end));

		$records = $this->TrackingVisit->query("SELECT * FROM tracking_visits WHERE  AND referer NOT LIKE '%harmonydesigns.com%' AND '$morning' <= date AND date <= '$midnight' ORDER BY referer_query_string ASC");
	}

	function admin_top_search($keywords = false)
	{
		$date_start = $this->Session->read("admin.tracking_requests.date_start");
		$date_end = $this->Session->read("admin.tracking_requests.date_end");
		$morning = date("Y-m-d 00:00:00", strtotime($date_start));
		$midnight = date("Y-m-d 23:59:59", strtotime($date_end));
		$limitquery = null;
		if(!empty($_REQUEST['query']))
		{
			$q = preg_replace("/ /", "+", $_REQUEST['query']);
			#$q = $_REQUEST['query'];
			$limitquery = " AND (referer_query_string LIKE '%$q%') ";
		}

		$records = $this->TrackingRequest->query("SELECT referer_query_string,referer,tracking_request_id,session_id FROM tracking_requests WHERE referer_query_string != '' AND referer LIKE 'http%' AND referer NOT LIKE '%harmonydesigns.com%' $limitquery AND '$morning' <= date AND date <= '$midnight' AND session_id IS NOT NULL AND session_id != '' ORDER BY referer_query_string ASC");

		$searches = array();
		$referers = array();
		$phrases = array();

		$carts = array();
		$builds = array();

		$customimages = array();
		$browsegalleries = array();

		$checkouts = array();
		$purchases = array();

		$cart_sessions = $build_sessions = $checkout_sessions = $purchase_sessions = array();

		$this->set("keywords", $keywords);
		$total = 0;

		$session_ids = array();

		foreach($records as $record)
		{
			$referer = $record['tracking_requests']['referer'];

			$session_id = $record['tracking_requests']['session_id'];
			$session_ids[] = "'$session_id'";

			parse_str($record['tracking_requests']['referer_query_string'], $qs);
			if (empty($qs['q'])) { continue; }
			$total++;
			$search = preg_replace("/[+]/", " ", $qs['q']);
			if ($keywords)
			{
				$search_words = split(" ", $search);
				foreach($search_words as $sw)
				{
					if(!isset($phrases[$sw])) { $phrases[$sw] = array(); }
					if(!isset($phrases[$sw][$search])) { $phrases[$sw][$search] = 0; }
					$phrases[$sw][$search]++;
					if(!isset($searches[$sw])) { $searches[$sw] = 0; }
					$searches[$sw]++;
					if(!isset($referers[$sw])) { $referers[$sw] = array(); }
					if(!isset($referers[$sw][$referer])) { $referers[$sw][$referer] = 0; }
					$referers[$sw][$referer]++;
				}
			} else {
					if(!isset($searches[$search])) { $searches[$search] = 0; }
					$searches[$search]++;
					if(!isset($referers[$search])) { $referers[$search] = array(); }
					if(!isset($referers[$search][$referer])) { $referers[$search][$referer] = 0; }
					$referers[$search][$referer]++;
			}

		$buildresults = $this->TrackingRequest->query("SELECT count(*) AS count FROM tracking_requests WHERE '$morning' <= date AND date <= '$midnight' AND url LIKE '/build/customize%' AND session_id = '$session_id' ");
		if(empty($builds[$search])) { $builds[$search] = 0; }
		if($buildresults[0][0]['count'] && empty($build_sessions[$search][$session_id])) { $builds[$search]++;$build_sessions[$search][$session_id] = true;  }

		$checkoutresults = $this->TrackingRequest->query("SELECT count(*) AS count FROM tracking_requests WHERE '$morning' <= date AND date <= '$midnight' AND url LIKE '%/checkout%' AND session_id = '$session_id' ");
		if(empty($checkouts[$search])) { $checkouts[$search] = 0; }
		if($checkoutresults[0][0]['count'] && empty($checkout_sessions[$search][$session_id])) { $checkouts[$search]++;$checkout_sessions[$search][$session_id] = true;  }

		$purchaseresults = $this->TrackingRequest->query("SELECT count(*) AS count FROM tracking_requests WHERE '$morning' <= date AND date <= '$midnight' AND url = '/checkout/receipt' AND session_id = '$session_id' ");
		if(empty($purchases[$search])) { $purchases[$search] = 0; }
		if($purchaseresults[0][0]['count'] && empty($purchase_sessions[$search][$session_id])) { $purchases[$search]++;$purchase_sessions[$search][$session_id] = true;  }

		$cartresults = $this->TrackingRequest->query("SELECT count(*) AS count FROM tracking_requests WHERE '$morning' <= date AND date <= '$midnight' AND url IN ('/cart/add','/cart/add_consolidated','/cart/add.php') AND session_id = '$session_id' ");
		#print_r($cartresults);
		if(empty($carts[$search])) { $carts[$search] = 0; }
		if($cartresults[0][0]['count'] && empty($cart_sessions[$search][$session_id])) { $carts[$search]++; $cart_sessions[$search][$session_id] = true; }

		}


		$this->set("carts", $carts);
		$this->set("purchases", $purchases);
		$this->set("builds", $builds);
		$this->set("checkouts", $checkouts);

		$this->set("total", $total);

		$this->set("phrases", $phrases);
		$this->set("searches", $searches);
		$this->set("referers", $referers);
	}

	function admin_visit_length()
	{
		# Not just tracking visit length

		# but figuring out which pages contribute to each.... (may need whole trail...)

		# also put in keywords associated to session lengths.... (maybe wrong customer, maybe bad content)

		# ie, are people leaving? and if so when? and what from? what didnt they like? what were they looking for?

		$date_start = $this->Session->read("admin.tracking_requests.date_start");
		$date_end = $this->Session->read("admin.tracking_requests.date_end");
		$morning = date("Y-m-d 00:00:00", strtotime($date_start));
		$midnight = date("Y-m-d 23:59:59", strtotime($date_end));

		$visit_length = array();
		$session_ids = array();

		# 0-15 secs
		$records = $this->TrackingRequest->query("SELECT COUNT(*) AS count FROM tracking_visits WHERE (session_start BETWEEN '$morning' AND '$midnight' OR session_end BETWEEN '$morning' AND '$midnight') AND (UNIX_TIMESTAMP(session_end) - UNIX_TIMESTAMP(session_start) BETWEEN 0 AND 15)");
		$visit_length["0 - 15 secs"] = $records[0][0]['count'];
		$session_records = $this->TrackingRequest->query("SELECT DISTINCT session_id FROM tracking_visits WHERE (session_start BETWEEN '$morning' AND '$midnight' OR session_end BETWEEN '$morning' AND '$midnight') AND (UNIX_TIMESTAMP(session_end) - UNIX_TIMESTAMP(session_start) BETWEEN 0 AND 15)");
		$session_ids["0 - 15 secs"] = $session_records;

		# 16-30 secs
		$records = $this->TrackingRequest->query("SELECT COUNT(*) AS count FROM tracking_visits WHERE (session_start BETWEEN '$morning' AND '$midnight' OR session_end BETWEEN '$morning' AND '$midnight') AND (UNIX_TIMESTAMP(session_end) - UNIX_TIMESTAMP(session_start) BETWEEN 16 AND 30)");
		$visit_length["16 - 30 secs"] = $records[0][0]['count'];
		$session_records = $this->TrackingRequest->query("SELECT DISTINCT session_id FROM tracking_visits WHERE (session_start BETWEEN '$morning' AND '$midnight' OR session_end BETWEEN '$morning' AND '$midnight') AND (UNIX_TIMESTAMP(session_end) - UNIX_TIMESTAMP(session_start) BETWEEN 16 AND 30)");
		$session_ids["16 - 30 secs"] = $session_records;

		# 31-60 secs
		$records = $this->TrackingRequest->query("SELECT COUNT(*) AS count FROM tracking_visits WHERE (session_start BETWEEN '$morning' AND '$midnight' OR session_end BETWEEN '$morning' AND '$midnight') AND (UNIX_TIMESTAMP(session_end) - UNIX_TIMESTAMP(session_start) BETWEEN 31 AND 60)");
		$visit_length["31 - 60 secs"] = $records[0][0]['count'];
		$session_records = $this->TrackingRequest->query("SELECT DISTINCT session_id FROM tracking_visits WHERE (session_start BETWEEN '$morning' AND '$midnight' OR session_end BETWEEN '$morning' AND '$midnight') AND (UNIX_TIMESTAMP(session_end) - UNIX_TIMESTAMP(session_start) BETWEEN 31 AND 60)");
		$session_ids["31 - 60 secs"] = $session_records;

		# 1 min - 2 mins
		$records = $this->TrackingRequest->query("SELECT COUNT(*) AS count FROM tracking_visits WHERE (session_start BETWEEN '$morning' AND '$midnight' OR session_end BETWEEN '$morning' AND '$midnight') AND (UNIX_TIMESTAMP(session_end) - UNIX_TIMESTAMP(session_start) BETWEEN 1*60 AND 2*60)");
		$visit_length["1 min - 2 mins"] = $records[0][0]['count'];
		$session_records = $this->TrackingRequest->query("SELECT DISTINCT session_id FROM tracking_visits WHERE (session_start BETWEEN '$morning' AND '$midnight' OR session_end BETWEEN '$morning' AND '$midnight') AND (UNIX_TIMESTAMP(session_end) - UNIX_TIMESTAMP(session_start) BETWEEN 1*60 AND 3*60-1)");
		$session_ids["1 min - 2 mins"] = $session_records;

		# 3 mins - 5 mins
		$records = $this->TrackingRequest->query("SELECT COUNT(*) AS count FROM tracking_visits WHERE (session_start BETWEEN '$morning' AND '$midnight' OR session_end BETWEEN '$morning' AND '$midnight') AND (UNIX_TIMESTAMP(session_end) - UNIX_TIMESTAMP(session_start) BETWEEN 3*60 AND 6*60-1)");
		$visit_length["3 mins - 5 mins"] = $records[0][0]['count'];
		$session_records = $this->TrackingRequest->query("SELECT DISTINCT session_id FROM tracking_visits WHERE (session_start BETWEEN '$morning' AND '$midnight' OR session_end BETWEEN '$morning' AND '$midnight') AND (UNIX_TIMESTAMP(session_end) - UNIX_TIMESTAMP(session_start) BETWEEN 3*60 AND 6*60-1)");
		$session_ids["3 mins - 5 mins"] = $session_records;

		# 6 mins - 15 mins
		$records = $this->TrackingRequest->query("SELECT COUNT(*) AS count FROM tracking_visits WHERE (session_start BETWEEN '$morning' AND '$midnight' OR session_end BETWEEN '$morning' AND '$midnight') AND (UNIX_TIMESTAMP(session_end) - UNIX_TIMESTAMP(session_start) BETWEEN 6*60 AND 16*60-1)");
		$visit_length["6 mins - 15 mins"] = $records[0][0]['count'];
		
		$session_records = $this->TrackingRequest->query("SELECT DISTINCT session_id FROM tracking_visits WHERE (session_start BETWEEN '$morning' AND '$midnight' OR session_end BETWEEN '$morning' AND '$midnight') AND (UNIX_TIMESTAMP(session_end) - UNIX_TIMESTAMP(session_start) BETWEEN 6*60 AND 16*60-1)");
		$session_ids["6 mins - 15 mins"] = $session_records;

		# 6 mins - 30 mins
		$records = $this->TrackingRequest->query("SELECT COUNT(*) AS count FROM tracking_visits WHERE (session_start BETWEEN '$morning' AND '$midnight' OR session_end BETWEEN '$morning' AND '$midnight') AND (UNIX_TIMESTAMP(session_end) - UNIX_TIMESTAMP(session_start) BETWEEN 16*60 AND 31*60-1)");
		$visit_length["16 mins - 30 mins"] = $records[0][0]['count'];
		
		$session_records = $this->TrackingRequest->query("SELECT DISTINCT session_id FROM tracking_visits WHERE (session_start BETWEEN '$morning' AND '$midnight' OR session_end BETWEEN '$morning' AND '$midnight') AND (UNIX_TIMESTAMP(session_end) - UNIX_TIMESTAMP(session_start) BETWEEN 16*60 AND 31*60-1)");
		$session_ids["16 mins - 30 mins"] = $session_records;

		# 31 mins - 1 hour
		$records = $this->TrackingRequest->query("SELECT COUNT(*) AS count FROM tracking_visits WHERE (session_start BETWEEN '$morning' AND '$midnight' OR session_end BETWEEN '$morning' AND '$midnight') AND (UNIX_TIMESTAMP(session_end) - UNIX_TIMESTAMP(session_start) BETWEEN 31*60 AND 60*60-1)");
		$visit_length["31 mins - 1 hour"] = $records[0][0]['count'];
		
		$session_records = $this->TrackingRequest->query("SELECT DISTINCT session_id FROM tracking_visits WHERE (session_start BETWEEN '$morning' AND '$midnight' OR session_end BETWEEN '$morning' AND '$midnight') AND (UNIX_TIMESTAMP(session_end) - UNIX_TIMESTAMP(session_start) BETWEEN 31*60 AND 60*60-1)");
		$session_ids["31 mins - 1 hour"] = $session_records;

		# 1 hr+
		$records = $this->TrackingRequest->query("SELECT COUNT(*) AS count FROM tracking_visits WHERE (session_start BETWEEN '$morning' AND '$midnight' OR session_end BETWEEN '$morning' AND '$midnight') AND (UNIX_TIMESTAMP(session_end) - UNIX_TIMESTAMP(session_start) >= 60 * 60)");
		$visit_length["1 hour+"] = $records[0][0]['count'];

		$session_records = $this->TrackingRequest->query("SELECT DISTINCT session_id FROM tracking_visits WHERE (session_start BETWEEN '$morning' AND '$midnight' OR session_end BETWEEN '$morning' AND '$midnight') AND (UNIX_TIMESTAMP(session_end) - UNIX_TIMESTAMP(session_start) >= 60 * 60)");

		$session_ids["1 hour+"] = $session_records;

		$visit_count = 0;
		foreach($visit_length as $len => $count)
		{
			$visit_count += $count;
		}

		$this->set("total_visits", $visit_count);
		$this->set("visit_length", $visit_length);
		$this->set("session_ids", $session_ids);

	}

	function admin_visits()
	{
		$date_start = $this->Session->read("admin.tracking_requests.date_start");
		$date_end = $this->Session->read("admin.tracking_requests.date_end");
		$morning = date("Y-m-d 00:00:00", strtotime($date_start));
		$midnight = date("Y-m-d 23:59:59", strtotime($date_end));

		$records = $this->TrackingRequest->query("SELECT * FROM tracking_visits WHERE '$morning' <= date AND date <= '$midnight' ORDER BY url ASC");
		$this->set("visits", $records);
	}

	function admin_top_landing()
	{
		$date_start = $this->Session->read("admin.tracking_requests.date_start");
		$date_end = $this->Session->read("admin.tracking_requests.date_end");
		$morning = date("Y-m-d 00:00:00", strtotime($date_start));
		$midnight = date("Y-m-d 23:59:59", strtotime($date_end));

		# Get session id's 

		# Get the first record for each sesion_id
		# Select

		#$session_id_list = "SELECT DISTINCT session_id FROM tracking_visits WHERE session_start BETWEEN '$morning' AND '$midnight' OR session_end BETWEEN '$morning' AND '$midnight'";
		$min_record_list = "SELECT MIN(tracking_request_id) FROM tracking_requests WHERE date BETWEEN '$morning' AND '$midnight' GROUP BY session_id";

		#$records = $this->TrackingRequest->query("SELECT * FROM tracking_requests WHERE tracking_request_id IN ($min_record_list)");
		$records = $this->TrackingRequest->query("SELECT * FROM tracking_requests r1 JOIN (SELECT MIN(tracking_request_id) AS tracking_request_id FROM tracking_requests WHERE date BETWEEN '$morning' AND '$midnight' AND referer NOT LIKE '%harmonydesigns.com%' AND referer != '' GROUP BY session_id) AS r2 ON r1.tracking_request_id = r2.tracking_request_id");

		# Gather pages (% and count)
		$pages = array();
		# Gather search phrases
		$phrases = array();
		# Gather Referer sources
		$sources = array();

		foreach($records as $record)
		{
			#print_r($record);
			$url = $record['r1']['url'];
			parse_str($record['r1']['referer_query_string'], $qs);
			$search = !empty($qs['q']) ? preg_replace("/[+]/", " ", $qs['q']) : null;
			$source = $record['r1']['referer'];
			#echo "S=".print_r($record['r1']['referer_query_string']);

			if (empty($pages[$url])) { $pages[$url] = 0; }
			$pages[$url]++;

			if (empty($phrases[$search])) { $phrases[$search] = 0; }
			$phrases[$search]++;

			if (empty($sources[$source])) { $sources[$source] = 0; }
			$sources[$source]++;
		}
		$total = count($records);

		$this->set("pages", $pages);
		$this->set("sources", $sources);
		$this->set("phrases", $phrases);

		$this->set("total", $total);
	}

	function admin_top_landing_old()
	{
		$date_start = $this->Session->read("admin.tracking_requests.date_start");
		$date_end = $this->Session->read("admin.tracking_requests.date_end");
		$morning = date("Y-m-d 00:00:00", strtotime($date_start));
		$midnight = date("Y-m-d 23:59:59", strtotime($date_end));


		$records = $this->TrackingRequest->query("SELECT * FROM tracking_requests WHERE referer LIKE 'http%' AND referer NOT LIKE '%harmonydesigns.com%' AND '$morning' <= date AND date <= '$midnight' ORDER BY url ASC");
		# Do our own count because we want referers separately....

		$hits = array();
		$referers = array();
		foreach($records as $record)
		{
			$url = $record['tracking_requests']['url'];
			$referer = $record['tracking_requests']['referer'];
			$referer_query_string = $record['tracking_requests']['referer_query_string'];
			parse_str($referer_query_string, $qs);
			$phrase = isset($qs['q']) ? $qs['q'] : "";
			$phrase = preg_replace("/[+]/", " ", $phrase);

			if(!isset($hits[$url])) { $hits[$url] = 0; }
			$hits[$url]++;


			if(!isset($referers[$url])) { $referers[$url] = array(); }
			if(!isset($referers[$url][$referer])) { $referers[$url][$referer] = array(); }
			if(!isset($referers[$url][$referer][$phrase])) { $referers[$url][$referer][$phrase] = 0; }
			$referers[$url][$referer][$phrase]++;
		}

		$this->set("hits", $hits);
		$this->set("referers", $referers);
	}

	function admin_top($report)
	{
		$date_start = $this->Session->read("admin.tracking_requests.date_start");
		$date_end = $this->Session->read("admin.tracking_requests.date_end");
		$morning = date("Y-m-d 00:00:00", strtotime($date_start));
		$midnight = date("Y-m-d 23:59:59", strtotime($date_end));


		$url = isset($_REQUEST['url']) ? $_REQUEST['url'] : "";


		$report_sqls = array(
			'landing'=>array(
				'sql'=>'referer = "" OR referer IS NULL OR referer LIKE "http%" ',
				'group'=>'url',
				),
			'exit' => array(
				'sql'=>" tracking_request_id IN (SELECT MAX(tracking_request_id) FROM tracking_requests WHERE is_bot = 0 AND internal = 0 AND '$morning' <= date AND date <= '$midnight' GROUP BY address)",
				"group"=>'url',
				),
		);

		$this->set("report", $report);

		$report_sql = $report_sqls[$report]['sql'];
		$group_sql = $report_sqls[$report]['group'];
		if (!$report_sql)
		{
			$report_sql = "1=1";
		}
		if (!$group_sql)
		{
			$group_sql = 'url';
		}

		$top_records = $this->TrackingRequest->query("SELECT *, COUNT(*) AS count FROM tracking_requests WHERE $report_sql AND '$morning' <= date AND date <= '$midnight' GROUP BY $group_sql ORDER BY count DESC, url ASC");

		$this->set("top_records", $top_records);
	}

	function admin_top_exit()
	{
		$date_start = $this->Session->read("admin.tracking_requests.date_start");
		$date_end = $this->Session->read("admin.tracking_requests.date_end");
		$morning = date("Y-m-d 00:00:00", strtotime($date_start));
		$midnight = date("Y-m-d 23:59:59", strtotime($date_end));


		$url = isset($_REQUEST['url']) ? $_REQUEST['url'] : "";


		$records = $this->TrackingRequest->query("SELECT * FROM tracking_requests tr1 INNER JOIN (SELECT MAX(tracking_request_id),session_id FROM tracking_requests WHERE '$morning' <= date AND date <= '$midnight' AND NOW() > DATE_ADD(date, INTERVAL 30 MINUTE) GROUP BY session_id) AS tr2 ON tr1.session_id = tr2.session_id GROUP BY tr1.session_id"); # More than 30 minutes ago!

		$total_visits = $this->TrackingRequest->query("SELECT COUNT(DISTINCT session_id) AS count FROM tracking_requests WHERE '$morning' <= date AND date <= '$midnight'");
		$this->set("total_visits", $total_visits[0][0]['count']);
		# Well, unless they buy (hit conversion page), they're an 'exiter'...

		# SLOW?
		$last_pages = array();

		# GROUP BY SECTION...
		$sections = array("\/product\/build.php", "\/products\/calculator","\/details", "\/gallery\/browse", "\/gallery\/view","\/images\/preview","\/product_image\/view");

		foreach($records as $record)
		{
			$url = $record['tr1']['url'];
			$qs = $record['tr1']['query_string'];
			if (preg_match("/start_over|new/", $qs)) { $qs = ""; } # Ignore
			$section = "";
			$page = $url;
			foreach($sections as $sec)
			{
				if(preg_match("/($sec)(.*)/", $url, $matches))
				{
					$page = $matches[2];
					$section = $matches[1];
				}
			}
			$url_parts = split("/", $url);
			if (!$section && count($url_parts) > 1) # Just split based on path.
			{
				$page = array_pop($url_parts);
				$section = join("/", $url_parts) . "/";
			}


			if(!isset($last_page_sections[$section]))
			{
				$last_page_section_count[$section] = 0;
				$last_page_sections[$section] = array();
			}
			if(!isset($last_page_sections[$section][$page]))
			{
				$last_page_sections[$section][$page] = 0;
			}
			$last_page_sections[$section][$page]++;
			$last_page_section_count[$section]++;

			#if(!isset($last_pages[$url])) { $last_pages[$url] = 0; }
			if(!isset($last_pages_qs[$url])) { $last_pages_qs[$url] = array(); }
			if(!isset($last_pages_qs[$url][$qs])) { $last_pages_qs[$url][$qs]= 0; }
			#$last_pages[$url]++;
			$last_pages_qs[$url][$qs]++;
		}
		$this->set("total_exits", count($records));
		#$this->set("last_pages", $last_pages);
		$this->set("last_page_sections", $last_page_sections);
		$this->set("last_page_section_count", $last_page_section_count);
		$this->set("last_pages_qs", $last_pages_qs);
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid TrackingRequest.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('trackingRequest', $this->TrackingRequest->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->TrackingRequest->create();
			if ($this->TrackingRequest->save($this->data)) {
				$this->Session->setFlash(__('The TrackingRequest has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TrackingRequest could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid TrackingRequest', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->TrackingRequest->save($this->data)) {
				$this->Session->setFlash(__('The TrackingRequest has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TrackingRequest could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TrackingRequest->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for TrackingRequest', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->TrackingRequest->del($id)) {
			$this->Session->setFlash(__('TrackingRequest deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function admin_landing_visits()
	{
		# Get queries for each page from google, etc and count for each week.
		error_log("HI");

		# Get # visitors 
		$weeksago = 4; # MAX

		error_log("Q");

		$visitor_count = $this->TrackingVisit->query("SELECT count(DISTINCT session_id) AS count,YEARWEEK(session_start) AS yearweek FROM tracking_visits AS TrackingVisits WHERE session_start > NOW() - INTERVAL $weeksago WEEK GROUP BY yearweek");
		error_log("Q2");
		$visitors = array();
		$visitor_total = 0;

		foreach($visitor_count as $visitor)
		{
			$yearweek = $visitor[0]['yearweek'];
			$count = $visitor[0]['count'];
			$visitors[$yearweek] = $count;
			$visitor_total += $count;
		}
		$this->set("visitors", $visitors);
		$this->set("visitor_total", $visitor_total);

		error_log("Q3");

		$bad_urls = array(
			'/cart',
			'/tracking_links',
			'/images',
			'/products/stock_calc',
			'/product_image',
			'/products/calculator',
		);
		$bad_url_list = join("|", $bad_urls);

		$stats = $this->TrackingVisit->query("SELECT YEARWEEK(session_start) AS yearweek, TrackingVisit.* FROM tracking_visits AS TrackingVisit WHERE  session_start > NOW() - INTERVAL $weeksago WEEK AND referer_search != '' AND landingpage_url != '' AND landingpage_url NOT REGEXP '($bad_url_list)' ORDER BY yearweek ASC, landingpage_url ASC");
		error_log("Q4");
		error_log("STATS=".count($stats));

		$yearweeks = array();
		$landing_visits = array();
		$landing_visit_total = 0;
		$landing_visits_yearweek = array();
		$yearweek_goals = array();

		$old_pages = array(
			'/product/detail.php'=>'/gallery/browse',
			'/product/build.php'=>'/build/customize',
		);

		$page_names = array(
			'/gallery/view'=>'Stamp View',
			'/gallery/browse'=>'Stamp Browse',
			'/'=>'Home Page',
			'/product/browse.php'=>'Browse ALL Stamps',
			'/build/customize'=>'Build Page',
		);
		$group_pages = array( # ones to group
			'/build/customize',
			'/gallery/view',
			'/gallery/browse',
		);
		$products = $this->Product->find('all');
		foreach($products as $product)
		{
			$produrl = "/details/".$product['Product']['prod'].".php";
			$page_names[$produrl] = $product['Product']['short_name'];
		}

		$goalorder = array('upload','build','cart','checkout','order');
		$this->set("goalorder", $goalorder);

		$latergoals = array();
		for($i = 0; $i < count($goalorder); $i++) {
			$latergoals[$goalorder[$i]] = array();
			for($j = $i+1; $j < count($goalorder); $j++)
			{
				$latergoals[$goalorder[$i]][] = $goalorder[$j];
			}
		}
		$this->set("latergoals", $latergoals);

		#header("Content-Type: text/plain");
		foreach($stats as $stat)
		{
			$yearweek = $stat[0]['yearweek'];
			$search = preg_replace("/[+]/", " ", $stat['TrackingVisit']['referer_search']);
			$landing_url = $stat['TrackingVisit']['landingpage_url'];
			$session_id = $stat['TrackingVisit']['session_id'];
			#

			# show only LATEST step...
			$goals = array();
			foreach(array_reverse($goalorder) as $goal)
			{
				if(!empty($stat['TrackingVisit']["did_$goal"]))
				{
					$goals[$goal] = true;
					#break;
					# Should show all, even people who got further.
				}
			}


			foreach($group_pages as $group_page)
			{
				if(preg_match("@$group_page@", $landing_url))
				{
					$landing_url = $group_page;
				}
			}

			if(in_array($landing_url, $old_pages))
			{
				$landing_url = $old_pages[$landing_url];
			}

			#echo "$search x 1 @ $yearweek\n";
			# Maybe do some massaging here to ignore bogus ones ('gifts', etc) and group together good ones...
			if(empty($landing_visits[$landing_url][$yearweek][$search])) { $landing_visits[$landing_url][$yearweek][$search] = 1; }
			else { $landing_visits[$landing_url][$yearweek][$search]++; }

			if(empty($yearweek_topsearches[$yearweek][$search])) { $yearweek_topsearches[$yearweek][$search] = 1; }
			else { $yearweek_topsearches[$yearweek][$search]++; }


			if(empty($landing_visits_sessions[$landing_url][$yearweek][$search])) { $landing_visits_sessions[$landing_url][$yearweek][$search] = array(); }
			$landing_visits_sessions[$landing_url][$yearweek][$search][] = $session_id;

			if(empty($landing_visits_goals[$landing_url][$yearweek][$search])) { $landing_visits_goals[$landing_url][$yearweek][$search] = array(); }
			foreach($goals as $goal => $success)
			{
				if($success) { 
					if(empty($landing_visits_goals[$landing_url][$yearweek][$search][$goal]))
					{
						$landing_visits_goals[$landing_url][$yearweek][$search][$goal] = array();
					}
					$landing_visits_goals[$landing_url][$yearweek][$search][$goal][$session_id] = true;

					if(empty($yearweek_goals[$yearweek][$goal][$session_id])) 
					{
						$yearweek_goals[$yearweek][$goal][$session_id] = array();
					}
					$yearweek_goals[$yearweek][$goal][$session_id] = true;
				}
			}

			$landing_visit_total++;
			if(empty($landing_visits_yearweek[$yearweek])) { $landing_visits_yearweek[$yearweek] = 0; }
			$landing_visits_yearweek[$yearweek]++;
			if(!in_array($yearweek, $yearweeks))
			{
				$yearweeks[] = $yearweek;
			}
		}
		#exit(0);
		uasort($landing_visits, array($this, "urlDesc"));

		$this->set("yearweek_goals", $yearweek_goals);
		$this->set("landing_visit_total", $landing_visit_total);
		$this->set("prettyStats", $landing_visits);
		$this->set("yearweek_topsearches", $yearweek_topsearches);
		$this->set("landing_visits_sessions", $landing_visits_sessions);
		$this->set("landing_visits_goals", $landing_visits_goals);
		$this->set("landing_visit_yearweek", $landing_visits_yearweek);
		$this->set("yearweeks", $yearweeks);
		$this->set("page_names", $page_names);
	}

	function urlDesc($a,$b)
	{
		$akeys = array_keys($a);
		$aix = $akeys[count($akeys)-1];
		$acount = array_sum($a[$aix]);
		$bcount = empty($b[$aix]) ? 0 : array_sum($b[$aix]);
		if($acount == $bcount) { return 0; }
		return $acount < $bcount;
	}

}
?>
