<div class="">
	<?php echo $form->create('CustomImage',array('id'=>'CustomImageForm', 'name'=>'CustomImageForm','type'=>'file','url'=>'/custom_images/iframe_add','onSubmit'=>'parent.showPleaseWait();')); ?>

	<table border=0 width="100%">
	<tr>
	<td valign="middle" width="50%">
	
	<div class="" style="padding-right: 20px;" onClickXXX="document.CustomImageForm.file.click(); $('CustomImageForm').submit();">
		<label class="bold">Step 1: Choose Your Image</label>
		<br/>
		<input type="file" id="file" class="file" style="margin-left: 0px;" name="data[CustomImage][file]" onChangeXX="$('faketext').value = 'Loading Preview...'; hideFlash(); parent.showPleaseWait();" style=""/>

		<div class="fakefile hidden">
			<input type="text" class="hidden" id="faketext" value="Your Image Here"/>
			<br/>
			Step 1: <a href="Javascript:void(0)"><img src="/images/buttons/Upload-Image.gif" align="top"/></a>
		</div>
		<div class="clear">
			<input type="radio" name="data[template]" <?= (empty($this->data['template']) || $this->data['template'] == 'standard') ? "checked='checked'" : "" ?> value="standard"/> Image and Text
			<input type="radio" name="data[template]" <?= (!empty($this->data['template']) && $this->data['template'] == 'imageonly') ? "checked='checked'" : "" ?> value="imageonly"/> Image Only
		</div>
	<div class="clear padded bold">
			Step 2: <input id="submit" name="" type="image" src="/images/buttons/small/Preview-Products.gif" align="top"/>
	</div>
		Preview will show below
	</div>

	</td>
	<td valign="middle" align="left">
				<b>OR</b> <a target="_top" href="/gallery/browse"><img src="/images/buttons/small/Browse-Our-Images-grey.gif" align="middle"/></a>
				<br/>
				<br/>
				<b>OR</b> <a class="" target="_top" href="/custom_images">Use a previously uploaded image</a>
	</td>
	</table>

	</form>

	<? if(!empty($this->data)) { ?>
	<script>
		Event.observe(window,'load', function() { parent.loadCustomProductImages(); });
	</script>
	<? } ?>
</div>
