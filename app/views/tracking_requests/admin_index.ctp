<?= $this->element("admin/tracking_requests/header"); ?>
<div>

<h4>Enter in a date range to filter</h4>
<?= $form->create(false, array('action'=>'index')); ?>
<?= $form->input("date_start",array('value'=>$this->data['date_start'])); ?>
<?= $form->input("date_end",array('value'=>$this->data['date_end'])); ?>
<?= $form->submit("Update"); ?>
</form>

<h4>Click on a report for details</h4>

<h3><a href="/admin/tracking_requests/performance">Website Performance</a></h3>

<ul class="large">
	<li> 
		<a href="/admin/tracking_requests/landing_visits">Search Engine Landing Page Results</a>
	<li> 
		<a href="/admin/tracking_links">Click Tracking</a>
		<br/>
		<br/>
		<br/>
	<li> Trends: 
		<a href="/admin/tracking_requests/trends_landing">Landing</a> | 
		<a href="/admin/tracking_requests/trends_landing_links">Landing Link Effectiveness</a> | 
		<a href="/admin/tracking_requests/trends_landing_choose">Choose Image Page Effectiveness</a> | 
		<br/>
		<a href="/admin/tracking_requests/trends/build">Build</a> | 
		<a href="/admin/tracking_requests/trends/checkout">Checkout</a>
	<li> <a href="/admin/tracking_requests/sales">Sales Chart

	<hr/>
	<li>
		<a href="/admin/tracking_requests/daily_stats">Daily stats</a>
	</li>
	<li>
		<a href="/admin/tracking_requests/product_flow_raw">Page sequence for product pages</a>
	</li>
	<li>
		<a href="/admin/tracking_requests/sequence">Landing page sequence</a>
	</li>
	<li>
		<a href="/admin/tracking_requests/top_pages">Top Pages</a>
	</li>
	<li>
		<a href="/admin/tracking_requests/top_pages/1">Top Significant Pages (Excluding Landing Pages)</a>
	</li>
	<li>
		<a href="/admin/tracking_requests/top_landing">Top landing pages</a>
	</li>
	<li>
		<a href="/admin/tracking_requests/top_exit">Top exit pages</a>
	</li>
	<li>
		<a href="/admin/tracking_requests/visit_length">Visit Length</a>
	</li>
	<li>
		<a href="/admin/tracking_requests/top_search">What are people looking for? (top searches)</a>
	</li>
<!--	<li>
		<a href="/admin/tracking_requests/top_search/1">Top search words</a>
	</li>
-->
	<li>
		<a href="/admin/tracking_requests/browser">Browser stats</a>
	</li>
	<li>
		<a href="/admin/tracking_requests/track_process">Build/Checkout Process</a>
	</li>
	<li>
		<a href="/admin/tracking_requests/pricing_calculator">Pricing calculator requests</a>
	</li>
	<li>
		<a href="/admin/tracking_areas">Conversion Tracking</a>
	</li>
	<li>
		<a href="/admin/tracking_requests/session_search">Search Session By Page</a>
	</li>
	<li>
		<a href="/admin/tracking_requests/next_pages">Next Pages</a>
	</li>
	<li class='red'>
		<a href="/admin/tracking_requests/top_companies">Top Company Visitors</a>
	</li>
</ul>
</div>
