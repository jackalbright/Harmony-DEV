<script>
function setBookmark(lam)
{
	if(lam == '5mil')
	{
		//return console.log('SET=BB');
		return setProduct('BB');
	} else { // Set to other bookmark. Default to B since coming from BB, no tassel/charm set.
		return setProduct('B');

		/*

		if(currprod == 'BB')
		{
		} else {
		var charm = j('input[name=data\\[options\\]\\[charmID\\]][checked=checked]');
		var tassel = j('input[name=data\\[options\\]\\[tasselID\\]][checked=checked]');
		console.log("CH="+charm.val());
		console.log("TA="+tassel.val());
		if(charm && parseInt(charm.val()) > 0)
		{
			return console.log('SET=BC');
			return setProduct('BC');
		}
		else if(tassel && parseInt(tassel.val()) > 0)
		{
			return console.log('SET=B');
			return setProduct('B');
		} else {
			return console.log('SET=BNT');
			return setProduct('BNT');
		}

		return console.log('SET=B');
		return setProduct('B');
		*/
	}
}
</script>
<div class="clear">
	<input onChange="setBookmark(this.value);" type="radio" name="data[options][laminate]" <?= (empty($build['options']['laminate']) || $build['options']['laminate'] == '10mil' || (in_array($prod,array('B','BNT','BC')))) ? "checked='checked'" : "" ?> value="10mil">Thicker 10-mil laminate (opt'l tassel+charm - $$)
	<br/>
	<br/>
	<input onChange="setBookmark(this.value);" type="radio" name="data[options][laminate]" <?= ((!empty($build['options']['laminate']) && $build['options']['laminate'] == '5mil') ||$prod == 'BB') ? "checked='checked'" : "" ?> value="5mil">Thinner 5-mil laminate (no tassel/charm - $)
	<br/>

</div>
