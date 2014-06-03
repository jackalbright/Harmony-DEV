<? $w = Configure::read('wholesale_site'); ?>
<? if(empty($type)) { $type = 'wholesale'; } ?>
<? $snippet_id = "{$type}_form"; ?>
<? $this->set("body_title", $snippet_titles[$snippet_id]); ?>
<? #$this->layout = 'default_plain'; ?>
<div class="specialtyPageProspects form resizable " style="padding: 0px 15px; width: <?= $w ? 600 : 800 ?>px;">

<script>


j( document ).ready(function() {
  j("#SpecialtyPageRequestAddForm").validate({
  rules: {
    // simple rule, converted to {required:true}
    "data[SpecialtyPageProspect][name]":{ 
										required: true,
										minlength: 4
										},
	"data[SpecialtyPageProspect][organization]": { 
										required: true,
										minlength: 4
										},
	"data[SpecialtyPageProspect][address1]": { 
										required: true,
										minlength: 4
										},
	"data[SpecialtyPageProspect][city]": { 
										required: true,
										minlength: 2
										},
	"data[SpecialtyPageProspect][state]": { 
										required: true,
										minlength: 2
										},
	"data[SpecialtyPageProspect][zipcode]": { 
										required: true,
										minlength: 5,
										digits: true
										},
    // compound rule
    "data[SpecialtyPageProspect][email]": {
      required: true,
      email: true
    },
  messages: {
    "data[SpecialtyPageProspect][name]":{ 
										required: "Please enter your name",
										minlength: "Name is too short"
										},
	"data[SpecialtyPageProspect][organization]": { 
										required: "Please enter your organization"
										},
    "data[SpecialtyPageProspect][email]": {
      									required: "We need your email address to contact you",
      									email: "Incorrect email format"
    									}
  },
  errorElement: "div",
            wrapper: "div",  // a wrapper around the error message
            errorPlacement: function(error, element) {
                offset = element.position();
                error.insertBefore(element)
                error.addClass('validate_error_message');  // add a class to the wrapper
                error.css('position', 'absolute');
                error.css('left', offset.left + element.outerWidth());
                error.css('top', offset.top);
            }
  }
});
});

/*j('#SpecialtyPageRequestAddForm').submit(function(event) {
	return verifyRequiredFields(this, event);
});*/
</script>
<?= $form->create('SpecialtyPageProspect',array('url'=>$this->here,'id'=>'SpecialtyPageRequestAddForm','type'=>'file'));?>
<? if(!empty($this->params['isAjax']) || !empty($this->params['requested'])) { ?>
<script>
/*j('#SpecialtyPageRequestAddForm').submit(function(e) {
        j(this).ajaxSubmit({target: '#wholesale'});
        e.preventDefault();
        return false;
});
*/
</script>
<? } ?>
	<?= !empty($snippets[$snippet_id]) ? $snippets[$snippet_id] : null?>

<? if(in_array($type, array('wholesale','museum')) && !Configure::read("wholesale_site")) { ?>
<!--<div style="width: 400px; margin: auto;">-->
<div>
	<div class='grey_header_top'><span>&nbsp;</span></div>
        <div style="background-color: #CCC; text-align: center; font-size: 16px;">
            <?= $this->Html->link("Continue to wholesale.harmonydesigns.com", "http://wholesale.harmonydesigns.com/", array('escape'=>false)); ?>
        </div>
        <div class='grey_header_bottom'><span>&nbsp;</span>
        </div>
	</div>
<? } else { ?>
	<table width="100%" cellpadding=2 cellspacing=0 >
	<tr>
	<td valign="top" rowspan=2>
		<?= $form->hidden('type',array('value'=>$type)); ?>
		<table width="100%" border=0 cellpadding=2 cellspacing=0 border=2>
		<tr>
			<td colspan=2> 
            <!--<label for="data[SpecialtyPageProspect][name]">Full Name</label>
            <input type="text" name="data[SpecialtyPageProspect][name]" size="40">-->
<?php echo $form->input('name',array('class'=>'full','label'=>'<span class=\'requiredLabel\'>*</span> Full Name')); ?> 
            
            </td>
		</tr>
		<tr>
			<td colspan=2> <?= $form->input('organization',array('label'=>'<span class=\'requiredLabel\'>*</span> Organization','class'=>'full')); ?> </td>
		</tr>
		<tr>
			<td valign="top" width="220"> <?= $form->input('address1',array('label'=>'<span class=\'requiredLabel\'>*</span>Address','class'=>'most')); ?> </td>
			<td valign="top"> <?= $form->input('address2',array('label'=>"&nbsp;",'class'=>'rest')); ?> </td>
		</tr>
		<tr>
			<td colspan=2> <?= $form->input('city', array('label'=>'<span class=\'requiredLabel\'>*</span> City','class'=>'full')); ?> </td>
		</tr>
		<tr>
			<td valign="top"> <?= $form->input('state',array('label'=>'<span class=\'requiredLabel\'>*</span> State','class'=>'most')); ?> </td>
			<td colspan=1 valign="top">
				<?= $form->input('zipcode',array('label'=>'<span class=\'requiredLabel\'>*</span> Zip Code','class'=>'rest')); ?>
			</td>
		</tr>
		<tbody>
		<tr class="">
			<td valign="top">
				<?= $form->input('email',array('label'=>'<span class=\'requiredLabel\'>*</span> Email','class'=>'most')); ?>
			</td>
			<td valign="top">
				<? if($type == 'wholesale') { ?>
					<?= $form->input('resale_number',array('label'=>'<span class=\'requiredLabel\'>*</span> Resale Number','class'=>'required rest')); ?>
				<? } ?>
			</td>
		</tr>
		<tr>
			<td valign="top" width="220">
				<?= $form->input('phone',array('label'=>'<span class=\'requiredLabel\'>*</span> Phone','class'=>'required','size'=>18,'after'=>' x ')); ?>
			</td>
			<td valign="top">
				<?= $form->input('phone_extension',array('label'=>'Ext','size'=>6)); ?>
			</td>
		</tr>
		</tbody>
		</table>

		<br/>

		<div class="alert bold">* Required fields</div>
	<? if($w) { ?>
		<?= $form->hidden("want_account", array('value'=>1)); ?>
	<? } else { ?>
	</td>
	<td valign="top" width="350" style="padding-top: 15px;">
	<div>
    <?php
	echo $form->input("comment", array('label'=>'Comments','type' => 'textarea'));
	?>
    </div>
		<? if($type == 'wholesale') { ?>
		<? } else if(in_array($type, array('museum'))) { ?>
			<?= $form->input("want_account", array('label'=>'Get a wholesale account')); ?>
			<?#= $form->input("want_catalog", array('label'=>'Request a catalog')); ?>
		<? } ?>

		<?= $form->input("want_consultation", array('label'=>'Get a free consultation')); ?>
		<?= $form->input("want_sample", array('label'=>'Get samples','onClick'=>"j('#samples').toggle(j(this).is(':checked')); ")); ?>

		<div id="samples" style="display:none; border: solid #999 1px; padding: 5px; background-color: #E4F1FB;">
			<?= $form->input("sample1", array('options'=>$sample_products, 'empty'=>'[Choose a sample product]','label'=>false,'style'=>'width: 100%;')); ?>
			<?= $form->input("sample2", array('options'=>$sample_products, 'empty'=>'[Optional 2nd sample product]','label'=>false,'style'=>'width: 100%;')); ?>
			<?= $form->input("sample3", array('options'=>$sample_products, 'empty'=>'[Optional 3rd sample product]','label'=>false,'style'=>'width: 100%;')); ?>
		</div>

		<?= $form->input("want_quote", array('label'=>'Get price quote','onClick'=>"j('#quote').toggle(j(this).is(':checked'));")); ?>
		<div id="quote" style="display:none; border: solid #999 1px; padding: 5px; background-color: #E4F1FB;">
			<table>
			<tr>
				<td valign="top">
					<?= $form->input("product_type_id", array('options'=>$sample_products,'label'=>'Product','empty'=>'Select a product:')); ?>
				</td>
				<td valign="top">
					<?= $form->input("quantity", array('size'=>4)); ?>
				</td>
			</tr>
			</table>
			<?= $form->input("project_details", array('style'=>'height: 75px;','class'=>'width95p', 'label'=>'Additional details about your project/questions')); ?>
		</div>

		<? if($type != 'wholesale') { ?>
		<?= $form->input("purchase_order", array('label'=>'Attach purchase order','onClick'=>"j('#purchase_order').toggle(j(this).is(':checked'));")); ?>
		<div id="purchase_order" style="display: none;">
			<div class='grey_header_top'><span class='alert2'>Attach purchase order</span></div>
			<div class='' style="background-color: #CCC; padding: 5px;">
				<?= $this->Form->input("PurchaseOrder.file", array('type'=>'file','label'=>false)); ?>
			</div>
			<div class='grey_header_bottom'><span></span></div>
		</div>
		<? } ?>
	<? } ?>


		<table width="350" cellpadding=0 cellspacing=0>
		<tr>
			<td valign="middle" style="padding-left: 0px;">
				<?php echo $this->Captcha->show(); ?>
			</td>
			<td valign="middle" align="right">
				<input type="image" src="/images/webButtons2014/green/large/send.png"/>
			</td>
		</tr>
		</table>
		<div align="right" class="alert2 errormsg"></div>

	</td>
	</tr>
	</table>
<? } ?>


<?php echo $form->end();?>

	<script>
	var checkFields = function(form)
	{
		if(j('#SpecialtyPageProspectWantQuote').is(":checked"))
		{
			verifyField(form, 'SpecialtyPageProspectProductTypeId');
			verifyField(form,'SpecialtyPageProspectQuantity');
		}

		if(j('#SpecialtyPageProspectWantSample').is(":checked"))
		{
			verifyField(form,'SpecialtyPageProspectSample1');
		}
		// error classes present will trigger failure
	}
	</script>


</div>
<? Configure::write("debug", 0); ?>
<style>
.ui-widget div.form label
{
	font-size: 0.8em;
}
input
{
	margin: 0px;
}
input.most
{
	width: 210px;
}
input.rest
{
	width: 105px;
}
input.full
{
	width: 330px;
}
</style>

