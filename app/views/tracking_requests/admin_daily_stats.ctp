<?= $this->element("admin/tracking_requests/header"); ?>

<div class="trackingRequests index">
<h2><?php __('TrackingRequests');?></h2>

<p>Today's stats</p>

<table>
<tr>
	<th> Page Hits </th>
	<th> Simultaneous Users </th>
</tr>
<tr>
	<td>
		<?= $page_hits ?>
	</td>
	<td>
		<?= $user_count ?>
	</td>
</tr>
</table>

<table>
</table>
<? if(empty($date_end)) { $date_end = $date_start; } ?>

<select onChange="load_chart(this.value);">
	<option value="<?= date("Y-m-d", strtotime($date_start)-24*60*60*7); ?>">1 week</option>
	<option selected='selected' value="<?= date("Y-m-d", strtotime($date_start)-24*60*60*30); ?>">1 month</option>
	<option value="<?= date("Y-m-d", strtotime($date_start)-24*60*60*90); ?>">3 months</option>
	<option value="<?= date("Y-m-d", strtotime($date_start)-24*60*60*180); ?>">6 months</option>
	<option value="<?= date("Y-m-d", strtotime($date_start)-24*60*60*365); ?>">1 year</option>
	<option value="<?= date("Y-m-d", strtotime($date_start)-24*60*60*365*2); ?>">2 year</option>
	<option value="<?= date("Y-m-d", strtotime($date_start)-24*60*60*365*3); ?>">3 year</option>
</select>

<script type="text/javascript">
function load_chart(backdate)
{
swfobject.embedSWF("/open-flash-chart.swf", "my_chart", "100%", "400", "9.0.0","expressInstall.swf",{"data-file":"/tracking_requests/chart_data/daily_visitors/"+backdate+"/<?= $date_end ?>"});
}

load_chart('<?= date("Y-m-d", strtotime($date_start)-24*60*60*30); ?>');

</script>

</div>


<div id="my_chart">Loading...</div>

</div>
