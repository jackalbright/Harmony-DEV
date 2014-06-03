<br/>
<br/>
<?
$w = Configure::read("wholesale_site");
if($w)
{
	$this->set("body_title", "Wholesale Account Signup / Login");
}

if(empty($goto)) {
	 $goto = ""; 
}

if (!empty($blurb))
{
	echo "$blurb<br>";
	//echo $this->element("account/blurb/$blurb"); 
} ?>



<div id="loginForm" class="wholesaleLoginContainer">
<?php 
echo $this->Session->flash('auth'); 
?>
<div class="login_box" id="leftside_login_box">
	<? if(empty($this->params['admin'])) { ?>
	<!--<td width="50%" valign=top  align="left">-->
		<!--<h4 style="font-size: 15px;" class="grey_header">-->
        <h4>Sign up for a <?php echo $w ? "wholesale" : "new" ?> account</h4>
		<div class="loginFormBox">
		<p >
		Signing up is easy. 
		<? 
		if($w) { ?>
			With your wholesale account...
            <ul>
            <li>You can automatically see wholesale pricing when you log in</li>
            <li>You can save your images and ordering preferences</li>
            <li>You can order as few as 12 items with your total order of $100 or more</li>
            </ul>
		<? 
		}else{ // if w 
		?>
		You can save your images and order preferences for easy checkout<?= $w ? " and reordering":"";
		}?>.
		</p>
		<? 
		if($w) { 
		?>
			<div align='center'>
			<br/>
			<?php $signup = $this->Html->image("/images/webButtons2014/orange/large/signupNow.png"); ?>
			<?php echo $this->Html->link($signup, "/specialty_page_prospects/add", array('title'=>'Signup for a wholesale account', 'class'=>'modal','escape'=>false)); ?>
			</div>
		<?
		 } else 
		 {
		 echo $form->create('Customer',array('id'=>'SignupForm','url'=>array('controller'=>'account','action'=>'signup'),'style'=>'margin: 0 auto; text-align: left; width: 225px;','autocomplete'=>'off'));				?>
		<br/>
			<input type="hidden" name="goto" value="<?php echo $goto?>"/>
			
			<?
			if(!empty($wholesale_site)) {
				echo $form->hidden('is_wholesale', array('value'=>1));
			 	echo $form->hidden('pricing_level', array('value'=>100));
			} // if not empty wholesale

			echo $form->input('eMail_Address', array('label'=>'Email:')); ?>
			<br/>
			<?php 
			echo $form->input('Password', array('type'=>'password','label'=>"Create password", 'after'=>'<br/>6 or more characters required')); ?>
			<br/>
			<?php
            echo $form->input('Password2', array('type'=>'password','label'=>'Password verification','after'=>'<br/>Repeat password for verification')); ?>
			<? 
			#$form->input('Phone', array('type'=>'text','after'=>'<br/>A phone number lets us contact you regarding order details and shipping questions.<br/><br/>')); 
			?>
			<br/>
			<div align="center">
			<input type="image" src="/images/webButtons2014/orange/large/signupNow.png" onClick="<?= !empty($checkout) ? "track('checkout','signup');" : "" ?>"/>
			</div>
		</form>
		<? } // if w else
		?>
		</div>

		<br/>

		<div id="loginBox_messageArea">
			We never share customer information with anyone. <a href="/info/privacy.php">Privacy Policy</a>
		</div>
</div><!--leftside_login_box-->
	

	<? 
	} // if empty params admin
	 ?>
	<div class="login_box" id="rightside_login_box">
		<h4 >Log in to an existing account</span></h4>
		<div class="loginFormBox">
		<?php echo $form->create('Customer',array('id'=>'LoginForm','url'=>array('controller'=>'account','action'=>'login'),'style'=>'margin: 0 auto; text-align: left; width: 200px;'));?>
			<input type="hidden" name="goto" value="<?= $goto ?>"/>
			<?= $form->input('eMail_Address', array('label'=>'Email:')); ?>
			<br/>
			<?= $form->input('Password', array('type'=>'password')); ?>
			<div align="center">
			<br/>
			<input id='login' type="image" src="/images/webButtons2014/orange/large/logIn.png" onClick="showPleaseWait(); <?= !empty($checkout) ? "track('checkout','login');" : "" ?>"/>
			
			<? /* j(this).attr('disabled','disabled'); setTimeout(function() { j('#login').removeAttr('disabled'); }, 15*1000); "/> */ ?>
			</div>
		</form>
		</div>

		<div id="forgot"><a href="/account/forgot">Forgot password?</a></div>
	
	<? //if($w) { ?>

	<? //} ?>
</div><!--rightside_login_box-->


</div><!--wholesaleLoginContainer-->

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
<style>
#loginForm form input[type=text],
#loginForm form input[type=password]
{
	width: 100%;
}
</style>

