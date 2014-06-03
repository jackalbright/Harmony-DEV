<div>
<h2>Link Tracking</h2>

<ul style="line-height: 200%;">
	<? foreach($sections as $section) { ?>
	<li><a href="/admin/tracking_links/view/<?= $section['tracking_links']['section'] ?>"><?= ucfirst($section['tracking_links']['section']) ?></a></li>
	<? }?>
</ul>
</div>
