<? $user = $this->Session->read("Auth.AdminUser"); ?>
<table width="100%">
<tr>
	<td >
		<img src="/images-shared/large-logo.gif"/>
	</td>
	<!--<td>
		<a href="/admin">ADMIN</a>
	</td>-->
	<td width="200">
		<? if (!empty($user)) { ?>
			Welcome, <?= $user['email'] ?>
			<a href="/admin/account/logout">Logout...</a>
		<? } else { ?>
			<a href="/admin/account/login">Login...</a>
		<? } ?>
	</td>
</tr>
</table>
