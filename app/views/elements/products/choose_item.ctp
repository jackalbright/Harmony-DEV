<table width="100%">
<tr>
	<th align="center">
		<h3> <?= $p['name'] ?> </h3>
	</th>
</tr>
<tr>
	<td align="center">
		<img src="/images/products/diagram/<?= $p['code'] ?>.jpg"/>
	</td>
</tr>
<tr>
	<td align="center">
		BLAH BLAH BLAH
	</td>
</tr>
<tr>
	<td align="center">
		PRICE.....
	</td>
</tr>
<tr>
	<td align="center">
		<? $prod = $p['code'] ?>
		<a href="/gallery?prod=<?= $prod ?>" class="bold" onClick="track('products','get_started',{productCode: '<?= $prod ?>'});"><img src="/images/buttons/Select.gif"/></a><br/>
	</td>
</tr>
</table>
