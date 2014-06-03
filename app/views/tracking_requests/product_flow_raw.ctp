<?= $this->element("admin/tracking_requests/header"); ?>
<div>
<h4>Page flow from product pages</h4>

<table>
	<? foreach($sequence as $session_id => $pages) { ?>
	<tr>
	<td>
		<?= $session_id ?>
	</td>
	<td>
		<? $i = 0; foreach($pages as $page) { ?>
			<? if($i++ > 0) { ?>&raquo;<? }?> <b><?= $page ?> </b>
		<? } ?>
	</td>
	</tr>
	<? } ?>
</table>
</div>
