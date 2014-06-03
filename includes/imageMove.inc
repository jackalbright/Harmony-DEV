<?php
	# Physically move files....
	$customer_id = $customer->customer_id;
	$base = dirname(__FILE__)."/../app/webroot";

	$session_id = session_id();
	$existing_images_result = mysql_query("SELECT * FROM custom_image WHERE customer_id IS NULL AND session_id = '$session_id'", $database);
	#error_log("CUSTID=$customer_id, SID=$session_id");
	#error_log("EIR=".print_r($existing_images_result,true));
	while($existing_image = mysql_fetch_assoc($existing_images_result))
	{
		$image_id = $existing_image['Image_ID'];
		if ($customer_id)
		{
			$Image_Location = $existing_image['Image_Location'];
			$Image_Location_new = preg_replace("#/anon/(\w+)/#", "/members/$customer_id/", $Image_Location);
			$display_location = $existing_image['display_location'];
			$display_location_new = preg_replace("#/anon/(\w+)/#", "/members/$customer_id/", $display_location);
			$thumbnail_location = $existing_image['thumbnail_location'];
			$thumbnail_location_new = preg_replace("#/anon/(\w+)/#", "/members/$customer_id/", $thumbnail_location);

			#error_log("IL=$Image_Location_new, $display_location_new, $thumbnail_location_new");

			mkdir(dirname("$base/$Image_Location_new"), 0777, true);
			mkdir(dirname("$base/$display_location_new"), 0777, true);
			mkdir(dirname("$base/$thumbnail_location_new"), 0777, true);

			rename("$base/$Image_Location", "$base/$Image_Location_new");
			rename("$base/$display_location", "$base/$display_location_new");
			rename("$base/$thumbnail_location", "$base/$thumbnail_location_new");

			$q = "UPDATE custom_image SET customer_id = '$customer_id', Image_Location = '$Image_Location_new', display_location = '$display_location_new', thumbnail_location = '$thumbnail_location_new' WHERE Image_ID = '$image_id'";
			mysql_query($q);
			#error_log("Q=$q");

			#mysql_query("UPDATE custom_image SET customer_id = '$customer_id' WHERE Image_ID = '$image_id'");
		}
	}
	
	#$query = "INSERT into custom_image(Title, Description, Customer_ID, thumbnail_location, display_location, Image_Location, Submission_Date) VALUES ('$title', '$description', $customerID, '$thumbnail', '$display', '$image', NOW() )";



		#$fileBase = $_SERVER['DOCUMENT_ROOT'];
		$fileBase = dirname(__FILE__)."/../";
		foreach ($tempImages as $tempID => $temp) {
			$title = $temp->Title;
			$description = $temp->Description;
			$customerID = $customer->customer_id;
			$thumbInfo = explode('~', $temp->thumbnail_location);
			$thumbnail = '/custom-images/thumbnails/' . $customerID . '~' . $thumbInfo[1];
			$imgInfo = explode('~', $temp->Image_Location);
			$image = '/custom-images/upload/' . $customerID . '~' . $imgInfo[1];
			$dispInfo = explode('~', $temp->display_location);
			$display = '/custom-images/display/' . $customerID . '~' . $dispInfo[1];
			
			rename("$fileBase$temp->thumbnail_location", "$fileBase$thumbnail");
			rename("$fileBase$temp->display_location", "$fileBase$display");
			rename("$fileBase$temp->Image_Location", "$fileBase$image");
			
			$query = "INSERT into custom_image(Title, Description, Customer_ID, thumbnail_location, display_location, Image_Location, Submission_Date) VALUES ('$title', '$description', $customerID, '$thumbnail', '$display', '$image', NOW() )";
			$result = mysql_query($query, $database);
			if ($result) {
				$newID = mysql_insert_id($database);
				unset($tempImages[$tempID]);
				foreach ($shoppingCart as $key=>$item) {
					if ($item->parts->customImageID == $tempID) {
						$shoppingCart[$key]->parts->customImageID = $newID;
					}
				}
			}
		}
?>
