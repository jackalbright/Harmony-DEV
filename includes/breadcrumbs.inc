<div class='breadcrumbs'>
<? 
if (!$breadcrumb_trail && $this) { $breadcrumb_trail = $this->breadcrumb_trail; }
if ($breadcrumb_trail) { ?>
<?
	$i = 0;
	foreach($breadcrumb_trail as $url => $name)
	{
		if ($i > 0) { echo " &raquo; "; }
		if ($url) { echo " <a href='$url'>$name</a>"; }
		else { echo " $name"; }
	}
?>
<? } ?>
&nbsp;
</div>
<div class='divider'></div>
