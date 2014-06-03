<?
if (!empty($testimonials))
{
?>
<div class="testimonials_container">
	<?
	foreach($testimonials as $testimonial) 
	{
	?>
	<div class="testimonial_sidebar">
	<blockquote class="testimonial"><?= $testimonial['text'] ?></blockquote>
	<blockquote class="attribution"><?= $testimonial['attribution'] ?></blockquote>
	</div>
	<?
	}
?>
	<div class="right_align"><a target="_new" href="/info/testimonials.php" class="">more...</a></div>
</div>
<? } ?>
