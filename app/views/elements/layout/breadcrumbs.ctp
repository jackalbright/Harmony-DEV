<? if ($breadcrumbs) { ?>
<div class='breadcrumbs'>
<?
	$i = 0;
	foreach($breadcrumbs as $url => $name)
	{
		if ($i++ > 0) { echo " &raquo; "; }
		if ($url) { echo "<a href='$url'>$name</a>"; }
		else { echo "$name"; }
	}
?>
&nbsp;
</div>
<div class='divider'></div>
<? } ?>
