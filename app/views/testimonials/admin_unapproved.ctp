<div class="testimonials index">

<h2><?php __('Testimonials');?></h2>
<div id="testimonials">

<a href="/admin/testimonials/index">View Active/Live</a>
<br/>

<?  $i = 0; foreach ($testimonials as $testimonial): ?>
	<div class="<?= $i++ % 2 == 0 ? "altrow" : "" ?> " id="testimonial_<?= $testimonial['Testimonial']['testimonial_id'] ?>" style="width: 700px;">
		<table width="100%">
		<tr>
			<td>
				<img src="/images/icons/up-down.png"/>
			</td>
			<td>
				<?php echo $testimonial['Testimonial']['text']; ?>
				<span class="italic"><?php echo $testimonial['Testimonial']['attribution']; ?></a>
			</td>
			<td>
				<?php echo $html->link(__('Edit', true), array('action'=>'edit', $testimonial['Testimonial']['testimonial_id'])); ?><br/>
				<br/>
				<br/>
				<?php echo $html->link(__('Delete', true), array('action'=>'delete', $testimonial['Testimonial']['testimonial_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $testimonial['Testimonial']['testimonial_id'])); ?>
			</td>
			<td class="bold">
				<? foreach($testimonial['Products'] as $product) { ?>
					<?= $product['name'] ?><br/>
				<? } ?>
			</td>
		</tr>
		</table>
		<br/>
	</div>
<?php endforeach; ?>
</table>
</div>

<?= $ajax->sortable('testimonials', array('url'=>'resort','tag'=>'div')); ?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Testimonial', true), array('action'=>'add')); ?></li>
	</ul>
</div>
