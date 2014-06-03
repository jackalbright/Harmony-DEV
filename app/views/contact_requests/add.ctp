<? $this->set("page_title", "Contact Us"); ?>
<div>

	<table width="100%">
	<tr>
	<td width="50%" valign="top">
	<p class="bold larger">Harmony Designs, Inc.</p>
	<p>
		129 East Harmony Road<br/>
		West Grove, PA 19390
	</p>
	<br/>
	<br/>
	<br/>

	<p>
		<b style="width: 175px; display: block; float: left;">Toll-Free Phone:</b> 888.293.1109<br/>
		<b style="width: 175px; display: block; float: left;">Outside of U.S.:</b> 610.869.4234<br/>
		<b style="width: 175px; display: block; float: left;">Product Development:</b> 610.869.4234<br/>
		<b style="width: 175px; display: block; float: left;">Fax:</b> 610.869.7415<br/>
		<br/>
		<br/>
		<b style="width: 175px; display: block; float: left;">Business Hours:</b> 9am - 5pm EST<br/>
	</p>

	</td>
	<td valign="top">

	<b class="larger">Contact us online:</b>

	<p>
	We will respond to your inquiry within the same business day.
	</p>

	<?#= $form->create('ContactRequest', array('class'=>'form','onSubmit'=>"if($('ContactRequestPhone').value == '' && $('ContactRequestEmail').value == '') { alert('Please specify at least one form of contact.'); return false; }; return verifyRequiredFields(this);")); ?>
	<?= $form->create('ContactRequest', array('class'=>'form','onSubmit'=>"return verifyRequiredFields(this);")); ?>

	<?= $form->input("name", array('size'=>30,'class'=>'required')); ?>
	<br/>
	<div class="required_one">
	<table>
	<tr>
		<td valign="top">
			<?= $form->input("phone", array('size'=>12)); ?>
		</td>
		<td valign="bottom">
			&nbsp; and/or &nbsp;
		</td>
		<td valign="top">
			<?= $form->input("email", array('size'=>20)); ?>
		</td>
	</tr>
	</table>
	</div>
	<br/>

	<?= $form->input("message", array('label'=>'Your Message','cols'=>50,'rows'=>5,'class'=>'required')); ?>

	<br/>

	<?= $this->Captcha->show(); ?>

	<br/>
	<input type="image" src="/images/webButtons2014/grey/large/send.png" value="Send" name="data[submit]"/>

	</form>

	</td>
	</tr>
	</table>
</div>
<hr/>

<? /* ?>

<div class="contactRequests form">
<?php echo $this->Form->create('ContactRequest');?>
	<fieldset>
		<legend><?php __('Add Contact Request'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('phone');
		echo $this->Form->input('email');
		echo $this->Form->input('message');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Contact Requests', true), array('action' => 'index'));?></li>
	</ul>
</div>
<? */ ?>
