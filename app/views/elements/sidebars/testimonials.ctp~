<?
if (!empty($testimonials))
{
?>
<div id="testimonials_sidebar">
	<div class="subtitle center">
		<div>Reviews</div>
	</div>
	<?
	foreach($testimonials as $testimonial) 
	{
	$draggable = (isset($admin) ? "draggable" : "");
	?>
	<div class="testimonial_sidebar <?= $draggable ?>">
	<blockquote class="testimonial"><?= $testimonial['text'] ?></blockquote>
	<blockquote class="attribution"><?= $testimonial['attribution'] ?></blockquote>
	</div>
	<?
	}
?>
	<? if(!isset($admin)) { ?>
		<a target="_new" href="/info/testimonials.php" class="right">more...</a>
	<? } ?>
</div>
<? } ?>
