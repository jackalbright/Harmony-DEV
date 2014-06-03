<div class="specialtyPageSampleImage form">
<?
	echo "<div class='right_align top_padded small_bottom_padded'>";
	echo $html->link(__("View All " . $specialtyPage['SpecialtyPage']['page_title'] . " Images", true), array('action'=>'index',$specialty_page_id));
	echo "</div>";
?>
	<fieldset>
	<table border="0" width="100%">
	<tr>
		<td valign="top">
		<?php echo $form->create('SpecialtyPageSampleImage',array('type'=>'file')); ?>
			<? echo $form->input('specialty_page_image_id'); ?>
			<? echo $form->hidden('specialty_page_id'); ?>
			<? echo $form->input('title'); ?>
			<? echo $form->input('product_type_id',array('options'=>$products,'label'=>'Product')); ?>
			<? echo $form->input('description'); ?>
			<? echo $form->input('file',array('type'=>'file','label'=>"Upload File")); ?>
			<br/>

		<? if ($mode == 'edit') { ?>
			<input type="submit" value="Update Image"/>
			&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;
			<!-- <a href="/admin/specialty_page_sample_images/delete/<?= $this->data['SpecialtyPageSampleImage']['specialty_page_image_id'] ?>" onClick="return confirm('Are you sure you want to delete this image?');"> -->
			<a href="/admin/specialty_page_sample_images/delete/<?= $this->data['SpecialtyPageSampleImage']['specialty_page_image_id'] ?>">
				Delete Image
			</a>
		<? } else { ?>
			<input type="submit" value="Add Image"/>
		<? } ?>
			<?php echo $form->end(); ?>
		</td>
		<td width="50%" align="center" valign="top">
			<? if($mode == 'edit') { ?>
			<a href="/images/galleries/specialties/<?= $specialtyPage['SpecialtyPage']['page_url'] ?>/<?= $this->data['SpecialtyPageSampleImage']['specialty_page_image_id']; ?>.<?= $this->data['SpecialtyPageSampleImage']['file_ext']; ?>">
				<img src="/images/galleries/specialties/<?= $specialtyPage['SpecialtyPage']['page_url'] ?>/thumbs/<?= $this->data['SpecialtyPageSampleImage']['specialty_page_image_id']; ?>.<?= $this->data['SpecialtyPageSampleImage']['file_ext']; ?>"/>
			</a>
			<br/>

			<? } else { ?>
			&nbsp;
			<? } ?>
		</td>
	</tr>
	</table>
	</fieldset>
</div>
