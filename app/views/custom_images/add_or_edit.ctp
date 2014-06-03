<? $this->element("steps/steps",array('step'=>'image')); ?>
<div class="customImage form">
<?
	#echo "<div class='right_align top_padded small_bottom_padded'>";
	#echo $html->link(__('View All Images', true), array('action'=>'index'));
	#echo "</div>";
?>

	
	<fieldset>
		<?php echo $form->create('CustomImage',array('type'=>'file','onSubmit'=>'return verifyRequiredFields(this);')); ?>
			<? echo $form->input('Image_ID'); ?>
			<? 
			#$form->input('Title',array('class'=>'','label'=>'Title (optional)')); 
			?>
			<? if ($mode == 'edit') { ?>
			<label>Approval Status</label>
			<div>
				<? switch($this->data['CustomImage']['Approved']) { 
					case 'Yes':
						echo "Approved";
						break;
					case 'No':
						echo "Denied";
						break;
					case 'Pending':
					default:
						echo $this->data['CustomImage']['Approved'];
				} ?>
			</div>
			<? } ?>
			<table width="100%" border=0>
			<tr>
				<td valign="top" width="70%">
				</td>
				<td valign="top" width="30%" class="bold">

					<? if (!$customer_id) { ?>
					<p style="color: #009900;">
					<a class="alert2" href="/account/login?goto=/custom_images">Signup</a> to save your art for later.
					</p>
					<? } ?>
				</td>

			</tr>
			<tr>
				<td valign="top" width="70%" >
				<div style="width: 80%;">
					<table width="500" style="border: solid #CCC 1px; background-color: #FEFEFE;">
					<tr>
					<td valign="top">
						<img src="/images/icons/upload.gif" height="50"/>
					</td>
					<td>
						<div class="" style="">
							<label>Step 1. Choose Your Image</label>
							<input type="file" id="file" name="data[CustomImage][file]" onChange="hideFlash();" onChangeOLD="parent.showPleaseWait(); $('CustomImageAddForm').submit();" style=""/>

							<br/>
							<br/>

							<div class="bold">Step 2.</div>
							<input align="top" type="image" name="submit" src="/images/buttons/Upload-Image.gif"/>
						</div>

						<div class="alert">
							Please be sure your image is 5MB or less for successful uploading.
						</div>
					</td>
					</tr>
					</table>

					<br/>
					<br/>

					<div align=left>
						<p>
						<div style="color: #009900;" class="">Upload tips</div>
			
						<ul>
							<li> Supported formats: JPG, PNG, GIF, TIF, PSD, PDF, EPS
							<li>  If your image fills half your computer screen at 100% if will probably reproduce well on your items.
							<li>Questions?  Please call:  888.293.1109
						</ul>
						<br/>
						<br/>

						<div style="color: #009900;" class="">Want to submit your art via email?</div>
						<div style="border: solid #CCC 1px; background-color: #FEFEFE; width: 500px;">
									<table width="100%">
									<tr>
										<td rowspan=2 valign="top">
											<a href="Javascript:void(0);" onClick="mail(this, '<?= base64_encode("graphics@harmonydesigns.com?subject=Completed Art"); ?>')">
												<img align="middle" class="" src="/images/icons/email.jpg" height=50>
											</a>
										</td>
										<td valign="top">
											<a href="Javascript:void(0);" onClick="mail(this, '<?= base64_encode("graphics@harmonydesigns.com?subject=Completed Art"); ?>')">
												Send email with art attached
											</a>
										</td>
									</tr>
									</table>
						</div>
						<br/>
						<ul>
						</ul>
						</p>
					</div>
				</div>
				</td>
				<td rowspan=1 width="30%" valign="top">
					<? if(!empty($customImages)) { ?>
					<div>
						<table border=0 width="100%" cellpadding=5 cellspacing=0 style="border: solid #CCC 1px;">
						<? $i = 0; foreach($customImages as $img) { ?>
						<tr style="background-color: <?= $i++ % 2 == 0 ? "#EFEFEF" : "#FFFFFF"; ?>;">
							<td align="center" valign="top">
								<a href="/custom_images/select/<?= $img['CustomImage']['Image_ID'] ?>">
									<img height="100" src="<?= $img['CustomImage']['thumbnail_location'] ?>"/>
								</a>
								<br/>
								<b><?= $img['CustomImage']['Title'] ?></b>
								<br/>
								<a href="<?= $img['CustomImage']['Image_Location'] ?>" rel="shadowbox">+ View Larger</a>
							</td>
							<td width="100" valign="middle" align="center">
								<a href="/custom_images/select/<?= $img['CustomImage']['Image_ID'] ?>"><img src="/images/buttons/small/<?= !empty($build['Product']) ? "Preview-Product.gif" : "Preview-Products-new.gif" ?>"/></a>
								<br/>
								<br/>
								<a href="/custom_images/delete/<?= $img['CustomImage']['Image_ID'] ?>" onClick="return confirm('Are you sure you want to delete this image?');">Delete Image</a>
							</td>
						</tr>
						<? } ?>
						</table>
					</div>
					<? } ?>
				</td>

		</td>
		</tr>
	</table>
	<?php echo $form->end(); ?>

	</fieldset>
</div>
