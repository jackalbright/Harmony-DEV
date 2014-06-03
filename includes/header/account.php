<?
$this_customer = !empty($_SESSION['Auth']['Customer']) ? $_SESSION['Auth']['Customer'] : null;
if(!empty($this_customer['guest'])) { $this_customer = null; }
?>
			<div align="left">
				<? if (empty($this_customer)) { ?>
				<div class="right">
					<a href="?login=1"><img src="/images/buttons/small/Log-In.gif"/></a>
				</div>
				<a class="bold" href="/account">My Account</a>
				<? } else { ?>
			     	<i>Hello, <?= $this_customer['First_Name'] != "" ? $this_customer['First_Name'] : ($this_customer['eMail_Address'] ? $this_customer['eMail_Address'] : "guest"); ?></i> | 
					<a href="/account">My Account</a> | 
					<a href="/account/logout">Logout</a>
				<? } ?>
			</div>
			<div class="clear"></div>

