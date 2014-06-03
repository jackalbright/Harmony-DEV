
				<?= $ajax->form('add_account','post',array('model'=>'Customer','update'=>'signup_form')); ?>
					<?= $form->input("First_Name"); ?>
					<br/>
					<?= $form->input("Last_Name"); ?>
					<br/>
					<?= $form->input("eMail_Address"); ?>
					<br/>
					<?= $form->input("Company",array('label'=>'Organization')); ?>
					<br/>
					<?= $form->input("Phone"); ?>
					<br/>
					<?= $form->input("reseller_number"); ?>
					<br/>
					<?= $form->submit('Send Request'); ?>
					<br/>
				<?= $form->end(); ?>
