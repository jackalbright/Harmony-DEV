<div id="" style="width: 400px;" class="members form">
<h2>Change Password</h2>

	<div class="bold">
		<?= $this->Html->link("< Back to My Account", "/account"); ?>
	</div>
	<br/>

<?php echo $form->create('Customer',array('url'=>array('controller'=>'account','action'=>'change_password'),'autocomplete'=>'off','onSubmit'=>'return verifyRequiredFields(this);'));
	echo $form->input('customer_id');
?>

<div class="grey_header_top"><span></span></div>
<table width="100%" class="greybg">
	<?php
		echo $html->tableCells(array(
			array(
				$form->input('Password',array('type'=>'password','value'=>'','label'=>'New Password','class'=>'required')),
			),
			array(
				$form->input('Password2',array('type'=>'password','value'=>'','label'=>"Re-type Password",'class'=>'required')),
			)
		));
	?>
</table>
<div class="grey_header_bottom"><span></span></div>
<input type="image" src="/images/buttons/Change-Password-grey.gif"/>
</form>
</div>


