<? if ($session->check('Message.auth')) $session->flash('auth'); ?>

<div id="login">

<h4>New Customer?</h4>
<form method="POST" action="/account/signup">
<input type="image" src="/images/buttons/Signup-Now.gif"/>
</form>

<br/>
<br/>

<h4>Existing Customers:</h4>
<?php echo $form->create('Customer',array('url'=>array('controller'=>'account','action'=>'login')));?>
	<?= $form->input('eMail_Address', array('label'=>'Email:')); ?>
	<?= $form->input('Password', array('type'=>'password')); ?>
	<input type="image" src="/images/buttons/Log-In.gif"/>
</form>

<div id="forgot"><a href="/account/forgot">forgot password?</a></div>

</div>
