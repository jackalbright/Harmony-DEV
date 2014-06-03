<?= $this->element("admin/tracking_requests/header"); ?>
<div>
<h4>What people do after going to a page:</h4>

Page: <?= $url ?>

<table>
<tr>
	<th>Address</th>
	<th>Next Pages</th>
	<th>Referer</th>
	<th>Last At Site</th>
</tr>
	<? foreach($user_paths as $session_id => $pages) { ?>
	<tr>
	<td>
		<a href="/admin/tracking_requests/session/<?=$session_id?>">
		<?= $session_id ?>
		</a>
	</td>
	<td>
		<? $i = 0; foreach($pages as $page) { ?>
			<? if($i++ > 0) { ?>&raquo;<? }?> <b><a target="_new" href="http://harmonydesigns.com/<?= $page['tracking_requests']['url'] ?> "><?= $page['tracking_requests']['url'] ?></a> </b>(<?= $page['tracking_requests']['method'] ?>) 
		<? } ?>
	</td>
	<td width="40%">
		<?= join("<br/>&nbsp;&nbsp;&nbsp;", split("/[?]/", $user_referers[$session_id])); ?>
	</td>
	<td>
		<?= $last_visits[$session_id] ?>
	</td>
	</tr>
	<? } ?>
</table>
</div>
