<div id="loading2" style="display: none; width: 100px; height: 100px; background-color: green;">
LOADING...
</div>
<div id="browse">
	<?= $this->requestAction("quotes/index/".$build['Product']['code'], array('return')); ?>
</div>
