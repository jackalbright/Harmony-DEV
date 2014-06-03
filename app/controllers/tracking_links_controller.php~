<?php
class TrackingLinksController extends AppController {

	var $name = 'TrackingLinks';
	var $helpers = array('Html', 'Form');
	var $uses = array('TrackingLink','Product');

	function index() {
		$this->TrackingLink->recursive = 0;
		$this->set('trackingLinks', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid TrackingLink', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('trackingLink', $this->TrackingLink->read(null, $id));
	}

	function add() {
		$ip = $_SERVER['REMOTE_ADDR'];
		$test = !empty($this->malysoft) || !empty($this->hdtest);

		if(!empty($this->params['form']) && ($test || !in_array($ip, array('71.224.15.91','71.224.15.94','24.127.150.29','71.224.1.11'))))
		{
			$product_type_id = null;
			if(!empty($this->params['form']['productCode']))
			{
				$this->Product->recursive = -1;
				$product = $this->Product->find(" code = '{$this->params['form']['productCode']}' ");
				if(!empty($product))
				{
					$product_type_id = $product['Product']['product_type_id'];
				}
			}
			$form = array('TrackingLink'=>array(
				'name'=>trim($this->params['form']['name']),
				'url'=>$this->params['form']['url'],
				'x'=>$this->params['form']['x'],
				'y'=>$this->params['form']['y'],
				'referer'=>$this->params['form']['referer'],
				'session_id'=>session_id(),
				'product_type_id'=>$product_type_id,
				'section'=>$this->params['form']['section'],
				'template'=>$this->params['form']['template'],
				'ip_address'=>$ip
			));
			$this->TrackingLink->create();
			$this->TrackingLink->save($form);
		}

		echo "OK";
		exit(0);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid TrackingLink', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->TrackingLink->save($this->data)) {
				$this->Session->setFlash(__('The TrackingLink has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The TrackingLink could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TrackingLink->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for TrackingLink', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->TrackingLink->del($id)) {
			$this->Session->setFlash(__('TrackingLink deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The TrackingLink could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

	function admin_index($section = '')
	{
		if(!empty($section)) { $this->redirect(array('action'=>'view',$section)); }

		# List available sections.
		$sections = $this->TrackingLink->query("SELECT DISTINCT section FROM tracking_links WHERE section != '' AND section IS NOT NULL");
		$this->set("sections", $sections);
	}


	function admin_view($section = 'product') { # product, build
	#error_log("URL=".print_r($this->params,true));
		if(!empty($this->params['url']['section']))
		{
			$section = $this->params['url']['section'];
		}
		$this->TrackingLink->recursive = 0;
		#$this->set('trackingLinks', $this->paginate());

		# SOMEDAY put in dates.

		# Get # visitors 
		$visitor_count = $this->TrackingLink->query("SELECT count(DISTINCT session_id) AS count,YEARWEEK(created) AS yearweek FROM tracking_links AS TrackingLink WHERE section = '$section' AND created > NOW() - INTERVAL 8 WEEK GROUP BY yearweek");
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


		#$this->set("visitorCount", $visitors[0]['count']);


		$stats = $this->TrackingLink->query("SELECT count(*) AS count,YEARWEEK(created) AS yearweek, TrackingLink.* FROM tracking_links AS TrackingLink WHERE name != '' AND section = '$section' AND created > NOW() - INTERVAL 8 WEEK GROUP BY name,url,yearweek,product_type_id ORDER BY yearweek ASC,count DESC");

		$namemap = array(
			'CLOSE'=>'CLOSE VIEW LARGER',
			'View all'=>'View all sample images',
			'Hide'=>'Hide sample images',
		);
		#print_r($stats);

		$products = $this->Product->findAll();
		$product_id_to_code = Set::combine($products, "{n}.Product.product_type_id", "{n}.Product.prod");

		# Combine similar items. And convert form buttons to images, etc....
		$prettyStats = array();
		$yearweeks = array();
		foreach($stats as $stat)
		{
			$name = $stat['TrackingLink']['name'];
			$name = preg_replace("@http(s)?://(www[.])?harmonydesigns.com/@", "/", $name); # In case in image, merge https with http, etc.

			$url = $stat['TrackingLink']['url'];
			$url = preg_replace("@http(s)://(www[.])?harmonydesigns.com/@", "/", $url);

			$referer = $stat['TrackingLink']['referer'];
			$count = $stat[0]['count'];
			$yearweek = $stat[0]['yearweek'];
			if(!in_array($yearweek, $yearweeks)) { $yearweeks[] = $yearweek; }

			preg_match("%details/([^/]*)[.]php%", $referer, $prodmatch);
			$prod = $prodmatch[1];

			$pid = $stat['TrackingLink']['product_type_id'];

			$productCode = !empty($pid) ? $product_id_to_code[$pid] : null;

			if (preg_match("/Circle-Dollar-Sign/", $name)) {
				$name = "<img src='$name'/><b>PRICING BUTTON</b>";
			} else if (preg_match("/STEP (\d+)[.] (.*)/", $name, $stepmatch)) {
				$name = "STEP $stepmatch[2]";
			} else if (preg_match("/Next-green/", $name) && preg_match("/javascript:void\('(\w+)'\)/i", $url, $stepmatch)) {
				$step = ucfirst($stepmatch[1]);
				$name = "$step NEXT";

			}
			else if(preg_match("/<img.*src=\"(.*)\"/i", $name, $imgmatch) || preg_match("%^(https://|http://|/).*[.](gif|jpg|jpeg|png)%", $name, $urlmatch))
			{
				$imgtag = $name;
				$src = !empty($imgmatch) ? $imgmatch[1] : $name;
				if(preg_match("%/images/galleries/(cached/)?products/([^/]*)%", $src, $prodimgmatch) || preg_match("/build_view/", $src)) # Combine.
				{
					$imgprod = $prodimgmatch[2];
					if(preg_match("/master_sample/", $imgtag) || preg_match("/build_view/", $src))
					{
						$name = '+ View Larger';
					} else {
						$name = 'Click Sample Image';
						$stat['TrackingLink']['name'] = $name;
					
						$stat[0]['img'] = "<img src='$imgtag'/>";
					}

				} else { # Some other picture, keep separate.
					$name = "<img src='$name' ".(preg_match("/build_view/", $name) ? 'height=150' : '') ."/>";
				}
			#} else if(preg_match("%^(http://|/).*[.](gif|jpg|jpeg|png)%", $name)) {  # Form submit button.
			#	$name = "<img src='$name'/>";
			} else if (!empty($namemap[$name])) { 
				$name = $namemap[$name];
			} else if (preg_match("/#/", $url)) {
				$name = "$name LINK";
			} else if (preg_match("@cart/display@", $url)) {
				$name = "VIEW CART";
			} else if (preg_match("/quantityPricing/", $url)) {
				$name = "PRICING PAGE";
			} else if (preg_match("/[.]php$/", $url)) {
				$short_url = preg_replace("/.*[.]com\//", "", $url);
				$name .= " <b> SEPARATE PAGE</b> ($short_url)";
			}
			$stat['TrackingLink']['name'] = $name;

			#echo "NAME=$name\n<br/>";

			$tag = $name;
			$distinguish = array('Pricing'); # Same names for different things, keep separate.
			if(in_array($tag, $distinguish))
			{
				$tag = $name.$url;
			}

			if(empty($prettyStats[$tag]))
			{
				$prettyStats[$tag] = array();
				$prettyStats[$tag][$yearweek] = $stat;
				if(!empty($productCode))
				{
					$prettyStats[$tag][$yearweek][0]['productCode'][$productCode] = 1;
				}
			} else {
				# Update.

				# XXX TODO
				# Add numbers together...
				$prettyStats[$tag][$yearweek][0]['count'] += $count;
				if(!empty($productCode))
				{
					if(empty($prettyStats[$tag][$yearweek][0]['productCode'][$productCode])) { $prettyStats[$tag][$yearweek][0]['productCode'][$productCode] = 1; }
					else { $prettyStats[$tag][$yearweek][0]['productCode'][$productCode]++; }
				}
			}
			if(!empty($stat[0]['img'])) { 
				if(empty($prettyStats[$tag][$yearweek][0]['images'][ $stat[0]['img'] ])) { $prettyStats[$tag][$yearweek][0]['images'][ $stat[0]['img'] ] = 0; }

				$prettyStats[$tag][$yearweek][0]['images'][ $stat[0]['img'] ] = 
					$prettyStats[$tag][$yearweek][0]['images'][ $stat[0]['img'] ] + $stat[0]['count']; 
			}
			#echo "NAME=$name";
			#print_r($prettyStats);
		}

		$this->set("yearweeks", $yearweeks);

		#print_r($prettyStats);

		if($section == 'build') # Do something different...
		{ # Get it in order, see if people get further along...
		# Ignore other links....
			$orderSteps = array(
				'STEP Select a Style',
				'Style NEXT',
				'STEP Choose Layout',
				'Layout NEXT',
				'STEP Quotation/Text',
				'Quote NEXT',
				'STEP Tassel',
				'Tassel NEXT',
				'STEP 24k Gold-Plated Charm',
				'Charm NEXT',
				'STEP Border',
				'Border NEXT',
				'STEP Personalization (optional)',
				'Personalization NEXT',
				'STEP Proof (optional)',
				'Proof NEXT',
				'Comments NEXT',
				'STEP Review',
				# MAKE SURE SHOWS UP!
				'Add-to-Cart',
				'Update-Cart',
				'Save for later?'
			);
			$orderedPrettyStats = array();
			foreach($orderSteps as $step)
			{
				foreach($prettyStats as $tag => $stat)
				{
					if(preg_match("@$step@", $tag))
					{
						$orderedPrettyStats[$tag] = $stat;
					}
				}
				
			}
			$this->set("prettyStats", $orderedPrettyStats);
		}  else {
			usort($prettyStats, array($this, "countDesc"));
			$this->set("prettyStats", $prettyStats);
		}
		$this->set("linkStats", $stats);
		#print_r($stats);

		$clicksumweek = array(); foreach($stats as $stat) { $yearweek = $stat[0]['yearweek']; $clicksumweek[$yearweek] += $stat[0]['count']; }
		$clicksum = 0; foreach($stats as $stat) { $clicksum += $stat[0]['count']; }
		$this->set("clickSumWeeks", $clicksumweek);
		$this->set("clickSumTotal", $clicksum);
	}

	function countDesc($a, $b)
	{
		$bix = $aix = max(array_merge(array_keys($a), array_keys($b)));
		#$bix = max(array_keys($b));
		if(empty($a[$aix]) && empty($b[$bix])) { return 0; }
		if(empty($a[$aix]) && !empty($b[$bix])) { return 1; }
		if(!empty($a[$aix]) && empty($b[$bix])) { return -1; }

		if($a[$aix][0]['count'] == $b[$bix][0]['count']) { return 0; }
		return($a[$aix][0]['count'] < $b[$bix][0]['count']);
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->TrackingLink->create();
			if ($this->TrackingLink->save($this->data)) {
				$this->Session->setFlash(__('The TrackingLink has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The TrackingLink could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid TrackingLink', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->TrackingLink->save($this->data)) {
				$this->Session->setFlash(__('The TrackingLink has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The TrackingLink could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TrackingLink->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for TrackingLink', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->TrackingLink->del($id)) {
			$this->Session->setFlash(__('TrackingLink deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The TrackingLink could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>
