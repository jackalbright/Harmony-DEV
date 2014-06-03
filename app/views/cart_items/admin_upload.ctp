<? $cid = !empty($this->data['CartItem']['customer_id']) ? $this->data['CartItem']['customer_id'] : null; ?>
		<? if(!empty($custom_images)) { ?>
		<?= $form->input("options.customImageID", array('label'=>'Custom Image','options'=>$custom_images,'empty'=>'- None -')); ?>
		<? } ?>
		<?= $form->input("CustomImage.file", array('type'=>'file','label'=>'Upload')); ?>
		<script>
		j('#CustomImageFile').change(function() {
			// upload image.
			var cid = j('#CartItemCustomerId').val();
			showPleaseWait();
			j('#CartItemAdminEditForm').ajaxSubmit({
				target: '#upload_container',
				url: "/admin/cart_items/upload/"+cid

			});
			j('#optionsCatalogNumber').val('').change();

		});
		</script>

		<div align="center">
		<br/>
		<img id="CustomImagePreview" src=""/>
		</div>
		<script>
		j('#optionsCustomImageID').change(function() {
			var imgid = j(this).val();
			var src = imgid ? "/custom_images/display/"+imgid : "/images/sprite.gif";
			j('#CustomImagePreview').attr('src', src).show();
			if(imgid)
			{
				j('#optionsCatalogNumber').val('').change();
				j('#GalleryImagePreview').hide();
			}
		});
		j(document).ready(function() { j('#optionsCustomImageID').change(); parent.hidePleaseWait(); });
		</script>

		<?= $form->input("CartItem.picture_only", array('type'=>'checkbox','label'=>'Show Picture Only (image includes physical product)')); ?>

