<?  $limit = "2M"; ?>
<table width="100%" cellpadding=0 cellspacing=0 border=0>
<tr><td width="50%" valign="top" align="left">
<div id="side1">
	<div id="side1_preview" align="center">
	<? if(!empty($this->data['CompletedImage'][0]['id'])) { ?>
		<?= $this->Form->hidden("CompletedImage.0.id"); ?>
		<b>Side 1:</b><br/>
		<img src='/completed_images/thumb/<?= $this->data['CompletedImage'][0]['id'] ?>?rand=<?= rand(10000,99999); ?>' style="max-width: 150px; max-height: 200px;"/>
		<br/>
		<?= $this->Html->link("Change Picture", "javascript:void(0)", array('onClick'=>"j('#side1_upload').show(); j('#side1_preview').html('');")); ?>
		<br/>
		<br/>
		<?= $this->Html->link("Delete", "javascript:void(0)", array('onClick'=>"j('#side1_upload').show(); j('#side1_preview').html('');",'class'=>'alert')); ?>
	<? } ?>
	</div>

	<div id="side1_upload" style="<?= !empty($this->data['CompletedImage'][0]['id']) ? "display:none;" : "" ?>">
		<? echo $this->Form->input('CompletedImage.0.file',array('id'=>'side1_file','type'=>'file','label'=>'Upload Your Art','value'=>'')); ?>
		<div style="padding-left: 175px; color: grey;">JPG, PNG, GIF, TIF, PSD, PDF, EPS. <?= $limit ?> limit</div>
	</div>
</div>
</td><td valign="top" align="left">
<div id="side2" style="<?= (empty($this->data['CompletedProject']['printing_on_back']) || ($this->data['CompletedProject']['printing_on_back'] != 'different')) ? "display:none;":""?>">
	<div id="side2_preview">
		<? if(!empty($this->data['CompletedImage'][1]['id'])) { ?>
			<?= $this->Form->hidden("CompletedImage.1.id"); ?>
			<b>Side 2:</b><br/>
			<img src='/completed_images/thumb/<?= $this->data['CompletedImage'][1]['id'] ?>?rand=<?= rand(10000,99999); ?>' style="max-width: 150px; max-height: 200px;"/>
			<br/>
			<?= $this->Html->link("Change Picture", "javascript:void(0)", array('onClick'=>"j('#side2_upload').show(); j('#side2_preview').html('');")); ?>
			<br/>
			<br/>
			<?= $this->Html->link("Delete", "javascript:void(0)", array('onClick'=>"j('#side2_upload').show(); j('#side2_preview').html('');",'class'=>'alert')); ?>
		<? } ?>
	</div>

	<div id="side2_upload" style="<?= (!empty($this->data['CompletedImage'][1]['id'])) ? "display:none; " : "" ?>">
		<? echo $this->Form->input('CompletedImage.1.file',array('id'=>'side2_file','type'=>'file','label'=>('Upload Side 2 Art'),'value'=>'')); ?>
		<div style="padding-left: 175px; color: grey;">JPG, PNG, GIF, TIF, PSD, PDF, EPS. <?= $limit ?> limit</div>
	</div>
</div>
</td></tr></table>

<script>
	j('form#CompletedProjectEditForm input[type=file]').change(function() {
		j('#flashMessage').remove();
		var form = j(this).closest('form');
		showPleaseWait();
		j(form).ajaxSubmit({
			target: '#completed_image_upload_container',
			url: "/completed_images/upload"
		});
	});
	// careful since we are in an iframe potentially.
	j(document).ready(function() {
		j.unspin();

	});
</script>
