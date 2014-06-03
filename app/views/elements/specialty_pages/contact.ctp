<div align="left" class="bold">
	<style>
	input[type=text]
	{
		margin-bottom: 5px;
	}
	</style>

	<script>
	function checkFields(form)
	{
		if(!verifyField(form,'name')) { return false; }
		//if(!verifyField(form,'organization')) { return false; }

		// email OR phone... XXX TODO
		if(!verifyField(form,'email',null) && !verifyField(form,'phone',null)) { alert("Missing contact information"); return false; }

		if($('quote').checked && !verifyField(form,'project')) { return false; }

		if(
			($('catalog').checked || $('sample').checked) &&
			(
				!verifyField(form,'address1') ||
				!verifyField(form,'city') ||
				!verifyField(form,'state') ||
				!verifyField(form,'zipcode')
			)
		)
		{ return false; }

		if($('sample').checked && !verifyField(form,'sample1')) { return false; }

		return true;
	}
	</script>

	<form method="POST" action="/specialty_page_prospects/add" onSubmit="return checkFields($(this));">
		<input type="hidden" name="data[SpecialtyPageProspect][specialty_page_id]" value="<?= $specialtyPage['SpecialtyPage']['specialty_page_id'] ?>"/>

	<div class="white">
		<label class="white" for="quote"><input id="quote" type="checkbox" name="data[SpecialtyPageProspect][want_quote]" value="yes" onClick="$('project').toggleClassName('hidden');"/> Request a quote</label>

		<label class="white" for="catalog"><input id="catalog" type="checkbox" name="data[SpecialtyPageProspect][want_catalog]" value="yes" onClick="if($('catalog').checked || $('sample').checked) { $('address').removeClassName('hidden') } else { $('address').addClassName('hidden'); }"/> Request a catalog</label>
		<label class="white" for="consult"><input id="consult" type="checkbox" name="data[SpecialtyPageProspect][want_consultation]" value="yes"/> Request a free consultation</label>
	</div>

	<div class="white">
		<label class="white" for="sample"><input id="sample" type="checkbox" name="data[SpecialtyPageProspect][want_sample]" value="yes" onClick="$('samples').toggleClassName('hidden'); if($('catalog').checked || $('sample').checked) { $('address').removeClassName('hidden') } else { $('address').addClassName('hidden'); }"/> Request a random sample</label>

	</div>

	<br/>

	<div align="left" class="white">
		<div>
			<label class="white" for="name">Name</label>
			<input style="width: 100%;" id="name" type="text" name="data[SpecialtyPageProspect][name]" width="100%"/>
		</div>
		<div>
			<label class="white" for="organization">Organization</label>
			<input style="width: 100%;" id="organization" name="data[SpecialtyPageProspect][organization]" type="text" width="100%"/>
		</div>
	</div>

	<div>
		<br/>
		<label class="black">
		Enter email, phone or both:
		</label>
		<div>
			<label class="white" for="email">Email</label>
			<input style="width: 100%;" id="email" name="data[SpecialtyPageProspect][email]" type="text" width="100%"/>
		</div>
		<div>
			<label class="white" for="phone">Phone</label>
			<input style="width: 100%;" id="phone" name="data[SpecialtyPageProspect][phone]" type="text" width="100%"/>
		</div>
	</div>


	<div>
		<div class='hidden' id='project'>
			<br/>
			<label for="project_details">Project details</label>
			<textarea name="data[SpecialtyPageProspect][project_details]" id="project_details" style="width: 100%; height: 100px;"></textarea>
		</div>
	</div>
	<div>
		<div class="hidden" id="address">
		<br/>
			Specify your address:
			<label class="white" for="address1">Address</label>
			<input style="width: 100%;" type="text" id="address1" name="data[SpecialtyPageProspect][address1]" width="100%"/>
			<input style="width: 100%;" type="text" id="address2" name="data[SpecialtyPageProspect][address2]" width="100%"/>
			<label class="white">City</label>
			<input style="width: 100%;" type="text" id="city" name="data[SpecialtyPageProspect][city]" width="100%"/>
			<label class="white" for='state'>State</label>
			<input style="width: 100%;" type="text" id="state" name="data[SpecialtyPageProspect][state]" width="100%"/>
			<label class="white" for="zipcode">Zip</label>
			<input style="width: 100%;" type="text" id="zipcode" name="data[SpecialtyPageProspect][zipcode]" width="100%"/>
		</div>
	</div>
	<div>


		<div class="hidden" id="samples">
		<br/>
		<label for="sample1">Choose your sample</label>
		<select name="data[SpecialtyPageProspect][sample1]" id="sample1">
			<option value="">[Choose a sample product]</option>
			<? foreach($all_products as $p) { ?>
			<option value="<?= $p['Product']['code'] ?>"><?= $p['Product']['name'] ?></option>
			<? } ?>
		</select>
		<br/>
		<br/>
		<select name="data[SpecialtyPageProspect][sample2]" id="sample2">
			<option value="">[Optional 2nd sample product]</option>
			<? foreach($all_products as $p) { ?>
			<option value="<?= $p['Product']['code'] ?>"><?= $p['Product']['name'] ?></option>
			<? } ?>
		</select>
		<br/>
		<br/>
		<select name="data[SpecialtyPageProspect][sample3]" id="sample3">
			<option value="">[Optional 3rd sample product]</option>
			<? foreach($all_products as $p) { ?>
			<option value="<?= $p['Product']['code'] ?>"><?= $p['Product']['name'] ?></option>
			<? } ?>
		</select>

		</div>
	</div>

	<div align="center">
		<br/>
		<input type="image" src="/images/webButtons2014/grey/large/send.png"/>
	</div>

	</form>

</div>
