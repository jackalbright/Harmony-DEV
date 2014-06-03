<div>
<?
$subject = $subjects[$id];
$children = !empty($subject_children[$id]) ? $subject_children[$id] : array();

$subject_list = !empty($this->data['SpecialtyPage']['subjects']) ? split(",", $this->data['SpecialtyPage']['subjects']) : array();
?>
<input type="checkbox" name="data[SpecialtyPage][subject_id][]" <?= in_array($id, $subject_list) ? "checked='checked'" : "" ?> value="<?= $id ?>"/> <?= $subject['GalleryCategory']['browse_name'] ?>

<div style="padding-left: 20px;">
<? foreach($children as $cid) { ?>
	<?= $this->element('specialty_pages/subject_tree',array('id'=>$cid, 'subjects'=>$subjects, 'subject_children'=>$subject_children)); ?>
<? } ?>
</div>
</div>

