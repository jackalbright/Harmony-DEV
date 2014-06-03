<?

function printTestimonialSidebar($database, $ids = array(18,12,9)) # Default ones...
{
		?>
		<div id="testimonials_sidebar">
		<?
		if (count($ids) > 0)
		{
			$testimonial_id_list = join(",", $ids);
			$testimonial_result = mysql_query("SELECT * FROM testimonial WHERE testimonial_id IN ($testimonial_id_list)", $database);
			#$testimonials = $this->getDBRecords("testimonial", array("testimonial_id"=>$ids));
			?>
			<div class="subtitle">Testimonials</div>
			<?
			while($testimonial = mysql_fetch_assoc($testimonial_result))
			{
			?>
			<div class="testimonial_sidebar">
			<blockquote class="testimonial"><?= $testimonial['text'] ?></blockquote>
			<blockquote class="attribution"><?= $testimonial['attribution'] ?></blockquote>
			</div>
			<?
			}
		}
		?>
		<a target="_new" href="/info/testimonials.php" class="right">more...</a>
		</div>
		<?
}
?>
