<?
if(empty($goto)) { $goto = ""; }

?>
<? if (!empty($blurb))
{
	echo $this->element("account/blurb/$blurb"); 
} ?>

<?= $this->Session->flash('auth'); ?>

<div id="loginForm" align="center">
<table>
<tr>
	<? if(empty($this->params['admin'])) { ?>
	<td width="250" valign=top colspan=2 align="left">
		<h4 class="grey_header"><span>Sign up for a new account</span></h4>
		<div class="grey_border padded whitebg" style="">
		<p align="left">
		Signing up is easy. You can save your images, designs, and order preferences for easy checkout.
		</p>
		<?php echo $form->create('Customer',array('id'=>'SignupForm','url'=>array('controller'=>'account','action'=>'signup'),'style'=>'margin: 0 auto; text-align: left; width: 225px;','autocomplete'=>'off'));?>
		<br/>
			<input type="hidden" name="goto" value="<?= $goto ?>"/>
			<?
				#$form->input('First_Name'); 
				?>
			<?
				#$form->input('Last_Name'); 
				?>
			<?= $form->input('eMail_Address', array('label'=>'Email:')); ?>
			<br/>
			<?= $form->input('Password', array('type'=>'password','label'=>"Create password", 'after'=>'<br/>6 or more characters required')); ?>
			<br/>
			<?= $form->input('Password2', array('type'=>'password','label'=>'Password verification','after'=>'<br/>Repeat password for verification')); ?>
			<? 
			#$form->input('Phone', array('type'=>'text','after'=>'<br/>A phone number lets us contact you regarding order details and shipping questions.<br/><br/>')); 
			?>
			<br/>
			<div align="center">
			<input type="image" src="/images/buttons/Signup-Now.gif" onClick="<?= !empty($checkout) ? "track('checkout','signup');" : "" ?>"/>
			</div>
		</form>
		</div>

		<br/>

		<div>
			We never share customer information with anyone. <a href="/info/privacy.php">Privacy Policy</a>
		</div>
	</td>
	<td style="vertical-align: top; font-weight: bold; font-size: 16px; padding: 75px 15px;">
		OR
	</td>
	<td width="250" valign=top align="left">
		<h4 class="grey_header"><span>Wholesale customers</span></h4>
		<div class="grey_border padded whitebg" style="padding: 10px;">
			To receive wholesale pricing and offers, please request a wholesale account. We will be in touch within one business day.
			<br/>
			<br/>
			<div align='center'>
			<a class="" style="" rel="shadowbox;type=html;width=625;height=625" href="/specialty_page_prospects/add">
				<img src="/images/buttons/Get-Wholesale-Account.gif"/>
			</a>
			</div>
		</div>
	</td>
	<td style="vertical-align: top; font-weight: bold; font-size: 16px; padding: 75px 15px;">
		OR
	</td>
	<? } ?>
	<td width="250" valign=top align="left">
		<h4 class="grey_header"><span>Log in to an existing account</span></h4>
		<div class="grey_border padded whitebg" style="">
		<?php echo $form->create('Customer',array('id'=>'LoginForm','url'=>array('controller'=>'account','action'=>'login'),'style'=>'margin: 0 auto; text-align: left; width: 200px;'));?>
			<input type="hidden" name="goto" value="<?= $goto ?>"/>
			<?= $form->input('eMail_Address', array('label'=>'Email:')); ?>
			<br/>
			<?= $form->input('Password', array('type'=>'password')); ?>
			<div align="center">
			<br/>
			<input id='login' type="image" src="/images/buttons/Log-In.gif" onClick="showPleaseWait(); <?= !empty($checkout) ? "track('checkout','login');" : "" ?>"/>
			<script>
			j('#login').click(function() {
				j(this).attr('disabled','disabled');
				j('#LoginForm').submit(); // have to manually call....
				return true;
			});
			j(document).ready(function() {
				j('#login').removeAttr('disabled');
			});
			</script>
			<? /* j(this).attr('disabled','disabled'); setTimeout(function() { j('#login').removeAttr('disabled'); }, 15*1000); "/> */ ?>
			</div>
		</form>
		</div>

		<div id="forgot"><a href="/account/forgot">Forgot password?</a></div>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
</table>
</div>

<style>
#loginForm form input[type=text],
#loginForm form input[type=password]
{
	width: 100%;
}
</style>

