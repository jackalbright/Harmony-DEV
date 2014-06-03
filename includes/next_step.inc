<? function display_nextstep($prodname = '', $prodid = '') { ?>
	<div id="nextSteps">
			<table>
				<tr>
					<th colspan="3">
						Next Step
					</th>
				</tr>
				<tr>
					<td width="40%">
						<a href="/custom/imageUpload.php">Use your own art <?= $prodname ? "on $prodname" : "" ?></a>
					</td>
					<td id="divider" valign="middle" width="20%">
					<h6>-&nbsp;or&nbsp;-</h6>
					</td>
					<td width="40%">
						<a href="/product/browse.php?browseNode=1&amp;resultOffset=1&amp;prod=<?= $prodid ?>">Find a subject <?= $prodname ? "for stamp $prodname" : "" ?></a>
					</td>
				</tr>
			<tr>
				  <td colspan="3" id="reproNote">Note: due to copyright, some stamp images are not available for reproduction<?= $prodname ? " on stamp $prodname" : "" ?>.</td>
			</tr>						
			</table>
		</div>

<? } ?>
