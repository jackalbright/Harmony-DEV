<div class="customer index">


<div class="right">
	<a href="/custserv/logout.php">Logout</a>
</div>
<p>
Hello, <?= $customer['Customer']['First_Name'] ?>!
</p>

<div class="divider"></div>

<table width="100%">
<tr>
	<td>
		<?= $this->element("customers/account"); ?>
	</td>
	<td>
		<?= $this->element("customers/past_orders"); ?>
	</td>
</tr>
<tr>
</tr>
</table>
</div>
