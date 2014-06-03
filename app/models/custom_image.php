<?php
class CustomImage extends AppModel {

	var $name = 'CustomImage';
	var $useTable = 'custom_image';
	var $primaryKey = 'Image_ID';

#	var $validate = array(
#		'Title'=>array(
#			'rule'=>'notEmpty',
#			'required'=>true,
#		),
#	);

	var $belongsTo = array(
		'Customer'=>array(
			'className'=>'Customer',
			'foreignKey'=>'Customer_ID',
		),

	);
	
	function moveAnonymousImages($session_id, $customer_id)
	{
		error_log("MOVING ANON IMAGES");
		############return; # DONT DO THIS AUTOMATICALLY ANY MORE...
		# DO this automatically, so we link their image to their account in case they sign up somewhere. so we can approve their image, send email, etc.

		#error_log("SID=$session_id, CID=$customer_id");
		if (!$customer_id)
		{
			error_log("NO CUSTOMER ASSIGNED TO PASSED SESSION $session_id..... WONT MOVE!");
			return;
		}
		#$images = $this->findAll("CustomImage.session_id = '$session_id' AND CustomImage.customer_id IS NULL");
		$images = $this->findAll("CustomImage.session_id = '$session_id'");

		foreach($images as $image)
		{
			error_log("SAVING {$image['CustomImage']['Image_ID']} TO $session_id => $customer_id");
			$this->saveImage($image, $session_id, $customer_id);
		}
	}

	function saveImage($image, $session_id, $customer_id)
	{
		$new_image = $image;

		$new_image['CustomImage']['Customer_ID'] = $customer_id;
		$image_parts = split("/", $image['CustomImage']['Image_Location']);
		$image_file = $image_parts[count($image_parts)-1];
		$new_image['CustomImage']['Image_Location'] = "/images/custom/customers/$customer_id/$image_file";
		$new_image['CustomImage']['display_location'] = "/images/custom/customers/$customer_id/display/$image_file";
		$new_image['CustomImage']['thumbnail_location'] = "/images/custom/customers/$customer_id/thumbs/$image_file";

		if (!file_exists(APP."/webroot".dirname($new_image['CustomImage']['Image_Location']))) { mkdir(APP."/webroot".dirname($new_image['CustomImage']['Image_Location']), 0755, 1); }
		if(!file_exists(APP."/webroot".dirname($new_image['CustomImage']['display_location']))) { mkdir(APP."/webroot".dirname($new_image['CustomImage']['display_location']), 0755, 1); }
		if(!file_exists(APP."/webroot".dirname($new_image['CustomImage']['thumbnail_location']))) { mkdir(APP."/webroot".dirname($new_image['CustomImage']['thumbnail_location']), 0755, 1); }

		#error_log("MOVING IMAGE=".APP."/webroot".$image['CustomImage']['Image_Location']." TO " .APP."/webroot".$new_image['CustomImage']['Image_Location']);

		if ($image['CustomImage']['Image_Location'] != $new_image['CustomImage']['Image_Location'])
		{
			@rename(APP."/webroot".$image['CustomImage']['Image_Location'], APP."/webroot".$new_image['CustomImage']['Image_Location']);
		}
		if ($image['CustomImage']['display_location'] != $new_image['CustomImage']['display_location'])
		{
			@rename(APP."/webroot".$image['CustomImage']['display_location'], APP."/webroot".$new_image['CustomImage']['display_location']);
		}
		if ($image['CustomImage']['thumbnail_location'] != $new_image['CustomImage']['thumbnail_location'])
		{
			@rename(APP."/webroot".$image['CustomImage']['thumbnail_location'], APP."/webroot".$new_image['CustomImage']['thumbnail_location']);
		}

		$this->id = !empty($new_image['CustomImage']['Image_ID']) ? $new_image['CustomImage']['Image_ID'] : null;

		#error_log("NEW_IM=".print_r($new_image,true));

		$this->save($new_image);
	}

	function beforeSave()
	{
		$webroot = APP."/webroot";
		# Do image conversion/copying if needed.
		if(!empty($this->data[$this->alias]['file']) && !empty($this->data[$this->alias]['filename']))
		{
			$customer_id = !empty($this->data[$this->alias]['Customer_ID']) ? $this->data[$this->alias]['Customer_ID'] : null;
			$session_id = session_id();
			
			$master_dir = $this->data[$this->alias]['path'];
			$image_file = $master_file = $this->data[$this->alias]['filename'];
			$master = "/$master_dir/$master_file";

			# Make sure medium/small are png's
			$image_file_png = preg_replace("/[.]\w+$/", ".png", $image_file);


			$large = $this->data['CustomImage']['Image_Location'] = $customer_id ? 
				"/images/custom/customers/$customer_id/$image_file_png":
				"/images/custom/anon/$session_id/$image_file_png"; # Large should be PNG....
			$medium = $this->data['CustomImage']['display_location'] = $customer_id ? 
				"/images/custom/customers/$customer_id/display/$image_file_png":
				"/images/custom/anon/$session_id/display/$image_file_png";
			$small = $this->data['CustomImage']['thumbnail_location'] = $customer_id ? 
				"/images/custom/customers/$customer_id/thumbs/$image_file_png":
				"/images/custom/anon/$session_id/thumbs/$image_file_png";

			error_log("FILE=$image_file, $large");



			if(!file_exists(APP."/webroot".dirname($large))) { mkdir(APP."/webroot".dirname($large), 0755, 1); }
			if(!file_exists(APP."/webroot".dirname($medium))) { mkdir(APP."/webroot".dirname($medium), 0755, 1); }
			if(!file_exists(APP."/webroot".dirname($small))) { mkdir(APP."/webroot".dirname($small), 0755, 1); }

			# Now create scaled/copied versions.
			error_log("WEBM=$master, $large");
			error_log("CONVERTING $webroot$master => $webroot$large");
			#@copy(APP."/webroot".$master, APP."/webroot".$large);
			$convert = "convert $webroot$master $webroot$large"; # Convert from PDF/etc to PNG always....
			exec($convert);
			error_log("CONV=$convert");

			$webroot = APP."/webroot";

			# 350x
			exec("convert $webroot$master -resize 350x $webroot$medium");

			# x80
			exec("convert $webroot$master -resize x80 $webroot$small");

			error_log("Data=".print_r($this->data['CustomImage'],true));

		}
		return true;
	}

}
?>
