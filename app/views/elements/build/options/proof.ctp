<div id="" style="padding: 10px;">
		<label for="no_proof_checkbox">
			<input id="no_proof_checkbox" onClick="update_build_review(); completeBuildStep('step_proof');" type="radio" <?= (empty($build['proof']) || $build['proof'] == 'no') ? "checked='checked'" : "" ?> name="data[proof]" value="no"/> <b>I do not want an email proof.</b>
		</label>
		<br/>
		<label for="proof_checkbox" class="">
			<input id="proof_checkbox" onClick="update_build_review(); completeBuildStep('step_proof');" type="radio" <?= (!empty($build['proof']) && $build['proof'] == 'yes') ? "checked='checked'" : "" ?> name="data[proof]" value="yes"/> <b>I would like an email proof with my paid order.</b> <span class="alert2">(This may delay your order 24-48 hours.)</span> When we receive your order, we will email you a proof. You are entitled to one free email proof plus one free revision.</label>

</div>
