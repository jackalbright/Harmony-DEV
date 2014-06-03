	<form method="POST" action="/admin/custom_images/search">
	Search: 

	<select name="data[field]" id="field">
		<option value="firstlast">Full Name</option>
		<option value="lastfirst">Last, First</option>
		<option value="email">Email</option>
		<option value="company">Company</option>
	</select>
	<?= $javascript->codeBlock("Event.observe(window, 'load', function() { \$('field').value = '". $this->data['field'] ."'; });"); ?>
	
	<input type="text" name="data[value]" value="<?= $this->data['value'] ?>"/>
	<input type="submit" value="Search"/>
	</form>
<? if (!empty($user)) { ?>
	Customer:
	<br/>
	<?= $user['Customer']['eMail_Address'] ?> (<?= $user['Customer']['First_Name'] . " " . $user['Customer']['Last_Name'] ?>)

	<script>
	function selectImage(id)
	{
		var item = window.parent.document.getElementById("EmailMessageImageId");
		item.value = id;
		parent.Shadowbox.close();
	}
	</script>

	<? if(!empty($custom_images)) { ?>
		<?= count($custom_images); ?> images
	<div>
		<? foreach($custom_images as $img) { ?>
			<div class="left" style="padding: 10px; text-align: center; height: 100px;">
				<a href="Javascript:void(0)" onClick="selectImage('<?= $img['CustomImage']['Image_ID'] ?>'); "><img src="<?= $img['CustomImage']['display_location'] ?>" height="75" /></a>
			</div>
		<? } ?>
		<div class="clear"></div>
	</div>
	<? } else { ?>
	No images found.
	<? } ?>

<? } else if(!empty($users)) { ?>
	<? foreach($users as $user) { ?>
	<div>
			<a href="/admin/custom_images/search/<?= $user['Customer']['eMail_Address']?>">
			<?= $user['Customer']['First_Name'] . " " . $user['Customer']['Last_Name'] ?>
			(<?= $user['Customer']['eMail_Address'] ?>)
			</a>
			<br/>
			<br/>
	</div>
	<? } ?>
<? } else if (isset($users) || isset($user)) { ?>
	No customers found.
<? } ?>

