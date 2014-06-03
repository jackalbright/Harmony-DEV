<?= $this->Session->flash('auth'); ?>

<div id="loginForm" align="center" style="width: 300px; margin: 0 auto;">
		<div class="grey_border padded greybg" style="">
		<?php echo $form->create('AdminUser', array('url'=>$this->here)); ?>
			<?= $form->input('email'); ?>
			<?= $form->input('password',array('value'=>'')); ?>
			<br/>
			<input type="image" src="/images/buttons/Log-In.gif"/>
		</form>
		</div>
</div>
