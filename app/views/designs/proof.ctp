<div class='proofOptionsDetails' >
		<label for="no_proof_checkbox">
			<input id="no_proof_checkbox" type="radio" <?= (empty($design['proof']) || $design['proof'] == 'no') ? "checked='checked'" : "" ?> name="data[Design][proof]" value="no"/> <b>I do not want an email proof.</b>
		</label>
		<br/>
		<label for="proof_checkbox" class="">
			<input id="proof_checkbox" type="radio" <?= (!empty($design['proof']) && $design['proof'] == 'yes') ? "checked='checked'" : "" ?> name="data[Design][proof]" value="yes"/> <b>I would like an email proof with my paid order.</b> <span class="alert2">(This may delay your order 24-48 hours.)</span> 
		</label>
			<a href='javascript:void(0);' id='proof_details_toggle' >Details</a><br>
			<span class='proof_details' id='proof_details' style='display: none;'>
			When we receive your order, we will email you a proof. You are entitled to one free email proof plus one free revision.
			</span>
			<?php
			//print_r($design);
			?>
</div><!--proofOptionsDetails-->

<script>
//j('#proof_details_toggle').click(function() {
// j('.proof_details').toggle(); 
 
// });
 j('#proof_details_toggle').click(function() {
	if( document.getElementById("proof_details").style.display == "none" ){
		j('.proof_details').show('slow');
		j('#proof_details_toggle').html('Hide details');
	}else{
		j('.proof_details').hide();
		j('#proof_details_toggle').html('Details');
	}
 
 });
 
 
 
</script>

