<table width="100%">
<tr>
	<td valign="top">
		<h2><?= $snippet_titles['wholesale2'] ?></h2>
		<br/>
		<br/>

		<?= $snippets['wholesale2']; ?>
	</td>
	<td style="width: 225px;" valign="top">
		<?= $html->link("Log in to your wholesale account", "/account/login",array('escape'=>false)); ?>
		<br/>
		<br/>
		<div align="center" class="bold">
			OR
		</div>
		<br/>
		<div style="border: solid #CCC 1px;">
			<h4 style="padding: 5px; background-color: #CCC; font-weight: bold;">Sign up for a wholesale account</h4>
			<div style="padding: 5px;">
				<div id="signup_form">

					<?= $this->requestAction("/wholesale/add_account",array('return')); ?>
					<br/>
				</div>

			</div>
		</div>
	</td>
</tr>
</table>
