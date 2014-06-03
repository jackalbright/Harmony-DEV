<?= $this->element("steps/steps",array('step'=>2)); ?>
<div class="customImage form">
<?php echo $form->create('CustomImage',array('type'=>'file'));?>
	<fieldset>
		<table border=0>
	<?php
		echo $html->tableCells(array(
			array(
				$form->input('file',array('type'=>'file','label'=>'Upload File: ')),
			),
			array(
				$form->input('Title'),
			),
			array(
				$form->input('Description',array('type'=>'text','size'=>50)),
			),
		));
	?>
		</table>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List CustomImage', true), array('action'=>'index'));?></li>
	</ul>
</div>
