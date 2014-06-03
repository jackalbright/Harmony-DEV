<div>
<p>A user on the website received a fatal error: <?= $msg ?>
<p>They were on the web page: <?= $url ?>

<p>Information they sent:

<pre>
	<? print_r($data); ?>
</pre>

<p>Information about their session/account:

<pre>
	<? print_r($sessinfo); ?>
</pre>

</div>
