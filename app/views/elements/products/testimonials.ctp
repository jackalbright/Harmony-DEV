<?
if (!empty($testimonials))
{
?>
<div class="testimonials_container" style="border: 0px; padding: 0px;">
	<?
	if (!empty($random)) { shuffle($testimonials); }
	if(!empty($limit)) { $testimonials_limit = $limit; }
	if (!empty($testimonials_limit))
	{
		$limit_testimonials = array();
		for($i = 0; $i < $testimonials_limit; $i++)
		{
			$limit_testimonials[] = $testimonials[$i];
		}
		$testimonials = $limit_testimonials;
	}
	$i = 0; foreach($testimonials as $testimonial) 
	{
		$text = strip_tags($testimonial['text']);
		$text = preg_replace("/^[\n\r]+/", "", $text);
		$text = preg_replace("/[\n\r]+$/", "", $text);
		$text = nl2br($text);
	?>
	<div class="testimonial_sidebar" style="border: 0px; padding: 5px 0px; background-color: <?= $i++ % 2 == 0 ? "#FFF" : "#DDD" ?>; ">
	<blockquote class="testimonial"><span style="font-size: 1em;">&#8220;</span><?= $text ?><span style="font-size: 1em; ">&#8221;</span></blockquote>
	<blockquote class="attribution"><?= $testimonial['attribution'] ?></blockquote>
	</div>
	<?
	}
?>
	<div style="border: 0px; padding: 5px 0px;" class="right_align"><a href="/info/testimonials.php" class="">More reviews...</a></div>
</div>
<? } ?>
