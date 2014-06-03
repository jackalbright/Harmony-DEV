<?
if (!empty($testimonials))
{
?>
<div class="testimonials_container">
	<?
	if (!empty($random)) { shuffle($testimonials); }
	if (!empty($limit))
	{
		$limit_testimonials = array();
		for($i = 0; $i < $limit; $i++)
		{
			$limit_testimonials[] = $testimonials[$i];
		}
		$testimonials = $limit_testimonials;
	}
	?>
	<?
	foreach($testimonials as $testimonial) 
	{
		$original_text = strip_tags($testimonial['text']);
		$text = "";
		$text_words = split(" ", $original_text);
		$wc = 0;
		do
		{
			$text = join(" ", array_slice($text_words, 0, $wc));
			$strlen = strlen($text);
		} while(++$wc && $wc < 25 && $wc < count($text_words));
		if ($strlen < strlen($original_text)) { $text .= " ..."; }
	?>
	<div class="relative" style="font-size: 11px; margin-top: 0px; padding: 5px;">
	<span style="font-size: 24px; position: absolute; top: -2px;">&#8220;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $text ?><span style="font-size: 24px; position: absolute; bottom: -5px;">&#8221;</span>
	</div>
	<?
	}
?>
	<div class="right_align"><a target="_new" href="/info/testimonials.php" class="">read more</a></div>
</div>
<? } ?>
