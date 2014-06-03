		<h4>Create an account (optional):</h4>
		Signup for an account to receive discounts and easy access to order history.
		<br/>
		<br/>
		<b>
		<?= $form->checkbox("create_account", array('onClick'=>"$('password_fields').toggleClassName('hidden');")); ?> Yes, I would like to create an account. </b>
		<div class="<?= empty($this->data['Customer']['create_account']) ? "hidden" : "" ?>" id="password_fields">
		<br/>
		To create an account, please provide a password to use with your email.
		<br/>
		<?= $form->input('Password',array('type'=>'password','value'=>'','class'=>'required','after'=>'<br/>Please create a password with 6 characters or more<br/><br/>')); ?>
		<?= $form->input('Password2',array('type'=>'password','value'=>'','label'=>'Re-Type Your Password','after'=>'','class'=>'required')); ?>
		</div>

