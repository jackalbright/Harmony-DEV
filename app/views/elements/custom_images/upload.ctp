<!--<div id="upload_top" class="grey_header_top"><span></span></div>-->
<div id="upload_box" valign="top" align="left">
<?php echo $form->create('CustomImage',array('url'=>'/custom_images/add', 'type'=>'file','onSubmit'=>'return verifyRequiredFields(this);')); ?>
		<div class="bold upload_box_heading" ><p>Upload a picture from your computer</p>
		
           <!-- <div>-->
            <input type="file" id="file" name="data[CustomImage][file]" XXXonChange="j('#upload_container').css({visibility: 'visible'});" onChange="j.spin(); j(this).closest('form').submit();" style="width: 200px;" size="15"/>
            <!--</div>-->
		</div><!--upload_box_heading-->
        <div id="upload_box_restrictions">
			<p><span class="restriction_label">File Types:</span> <span class="restriction_value">JPG, PNG, GIF, TIF, PDF</span></p>
            <p><span class="restriction_label">File Size:&nbsp;</span> <span class="restriction_value">&nbsp;2 MB limit</span></p>
			<div class='clear'></div>
		</div>

		<div id="upload_container" style="visibility: hidden;">
		<div class="bold" style="font-size: 14px; color: black;">Step 2.</div>
			<input type="image" src="/images/buttons/Upload.gif" onClick="showPleaseWait(true);"/>
		</div>

		<? if(!empty($product)) { ?>
		<br/>
		<div> <a id="download_template" href="/products/template/<?= $product['Product']['code'] ?>">Download template &amp; specifications<br/>
			<!--for <?= strtolower(Inflector::pluralize($product['Product']['short_name'])); ?>-->
			</a>
        
        </div>
        <hr class="">
		<? } ?>
<?= $form->end(); ?>
<? if (!$customer_id) { ?>
      <div>
      <a class="alert2" href="/account/login?goto=/custom_images">Login</a> to your account to view saved images.
      </div>
<? } ?>
</div>
<!--<div id="upload_bottom" class="grey_header_bottom"><span></span></div>-->
