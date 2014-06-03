<?php
class CustomImageController extends AppController {

	var $name = 'CustomImage';
	var $title = 'My Images';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->CustomImage->recursive = 0;
		$session_id = session_id();
		$this->set('customImages', $this->paginate("CustomImage", "session_id = '$session_id'"));
	}

	function add() {
		$session_id = session_id();

		if (!empty($this->data)) {
			$this->CustomImage->create();
			$this->data['CustomImage']['session_id'] = $session_id;
			# If logged in, use their customer_id instead.
			# XXX TODO

			$path = "/images/custom/anon/$session_id"; # May want to change once logged in.

			$prefix = time() . rand(0, 10000);

			$return = $this->savePhotoFile($path, $prefix); # Done separately from actual db

			if ($return && is_array($return))
			{
				$this->Session->setFlash("Unable to save image: " .  join("<br/>\n", $return) );
				#$this->render();
			} else {
				$filename = $return;

				# Now update Image_location
				$this->data['CustomImage']['Image_Location'] = "$path/$filename";
				$this->data['CustomImage']['Display_Location'] = "$path/$filename";
				$this->data['CustomImage']['Thumbnail_Location'] = "$path/thumbs/$filename";
	
				# REALLY SHOULD BE FIGURED ON THE FLY, but oh well...
				# when switch over, must change these paths too...
	
				if ($this->CustomImage->save($this->data)) {
					$this->Session->setFlash(__('Your image has been saved', true));
					$this->redirect(array('action'=>'index'));
				} else {
					$this->Session->setFlash(__('Your image could not be saved. Please, try again.', true));
				}
			}
		}
	}

	function savePhotoFile($path, $prefix)
	{
		$objclass = $this->name;
		if (($fileobj = $this->data[$objclass]["file"])) { # IF uploading too...

			if ($fileobj["size"] < 1024) # Probably invalid!
			{
				return array("Invalid image. File size too small.");
			}

			$name = $fileobj["name"];
			$ext = preg_replace("/^.*[.](\w+)$/", "$1", $name);
			if (!$ext) { $ext = 'jpg'; }

			$destname = $prefix ? "$prefix.$ext" : $name;

			# XXX TODO shouldnt we rename the file to something more sane/standard? maybe the primary key?
			#die();

			# Now save file to disk...
			$dest_path = sprintf(APP . "/webroot/$path/%s", $destname);

			$dest_dir = dirname($dest_path);
			$dest_file = basename($dest_path);

		#	error_log("DEST_DIR=$dest_dir, DEST_FILE=$dest_file");

			if (!is_dir($dest_dir))
			{
				if (!mkdir($dest_dir, 0755, true))
				{
					$this->Session->setFlash("Unable to create folder $dest_dir");
					$this->render();
				} else {
					#error_log("CREATED $dest_dir");
				}
			}

			#error_log("SAVING AS $dest_path");

			$this->Upload->upload($fileobj, "$dest_dir/", $dest_file);
			$errors = $this->Upload->errors;

			return is_array($errors) ? $errors : $destname;
		}
	}


	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CustomImage', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CustomImage->save($this->data)) {
				$this->Session->setFlash(__('The CustomImage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CustomImage could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CustomImage->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CustomImage', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CustomImage->del($id)) {
			$this->Session->setFlash(__('CustomImage deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function _scalePhoto($basefolder, $filename, $size, $ext = 'jpg')
	{
		#error_log("SCALE_PHOTO=$basefolder, $filename $size, $ext");
		if ($size != 'smallmedium' && $size != 'medium' && $size != 'small') { error_log("Invalid call to _scalePhoto($basefolder, $filename, $size"); }
		$sizeto = array(
			'medium'=>array(198,206), # Since array, MUST be AT LEAST, so not short of rigid ratio
			'smallmedium'=>125,
			'small'=>85, # 85x85
		);


        	#App::import('Vendor','phpthumb',array('file'=>'phpThumb'.DS.'phpthumb.class.php'));  
		#$thumb = new phpthumb;
		#$thumb->src = "$basefolder/large/$filename";
		#$thumb->w = $w;
		#$thumb->h = $h;
		#$thumb->q = 100;
	        #$thumb->config_imagemagick_path = '/usr/bin/convert';  
	        #$thumb->config_prefer_imagemagick = true;  
	        #$thumb->config_output_format = $ext;
	        #$thumb->config_error_die_on_error = true;  
	        #$thumb->config_document_root = '';  
	        #$thumb->config_temp_directory = APP . 'tmp';  
	        #$thumb->config_cache_directory = "$basefolder/$size/";
	        #$thumb->config_cache_disable_warning = true;  
		#$thumb->cache_filename = "$basefolder/$size/$filename";

		$srcfile = "$basefolder/large/$filename";
		$dstfile = "$basefolder/$size/$filename";

		list($oldwidth, $oldheight) = getimagesize($srcfile);

		$newsize = $sizeto[$size];

		if (is_array($newsize))
		{
			$neww = $newsize[0];
			$newh = $newsize[1];
			$h2w_ratio = $oldwidth / $oldheight;

			$h = $newh; # So we can have all in a row of equal heights...
			$w = $h2w_ratio * $newh;

			##error_log("OLD=$oldwidth / $oldheight, NEWH=$newh, NEWW=$neww, H2W=$h2w_ratio, H=$h, W=$w");

			if ($w < $neww) # Not wide enough to fit....
			{
				$w = $neww;
				$h = $newh / $h2w_ratio;
				#error_log("CHANGING W=$w, H=$h");
			}
		} else {
			$h = $newsize; # So we can have all in a row of equal heights...
			$w = $oldwidth / $oldheight * $newsize;
		}

		if (!is_dir("$basefolder/$size")) { mkdir("$basefolder/$size", 0755, true); }

		# Generate thumbnail...
		#error_log("EXT=$ext");
		if (strtolower($ext) == 'jpg')
		{
			$src = imagecreatefromjpeg($srcfile);
		} else if (strtolower($ext) == 'gif') {
			$src = imagecreatefromgif($srcfile);
		} else if (strtolower($ext) == 'png') {
			$src = imagecreatefrompng($srcfile);
		} else {
			# Invalid....
			# BARF somehow...
			error_log("Could not generate thumbnail, unknown filetype");
			return;
		}

		if (strtolower($ext) == 'gif')
		{
			$newimg = imagecreate($w, $h);
		} else {
			$newimg = imagecreatetruecolor($w, $h);
		}

		imagecopyresampled($newimg,$src,0,0,0,0,$w,$h,$oldwidth,$oldheight); 
		#imagecopyresized($newimg,$src,0,0,0,0,$w,$h,$oldwidth,$oldheight); 
		
		# Just straight copy, maybe imagecreate original is broken?


		# Save to disk.
		if (strtolower($ext) == 'jpg')
		{
			$ok = imagejpeg($newimg, $dstfile);
		} else if (strtolower($ext) == 'gif') {
			$ok = imagegif($newimg, $dstfile);
		} else if (strtolower($ext) == 'png') {
			$ok = imagejpeg($newimg, $dstfile);
			#$ok = imagepng($newimg, $dstfile);
		}

		if (!$ok)
		{
			error_log("Could not generate thumbnail to ". $dstfile);
		}
	}

	function _scalePhoto_old($basefolder, $filename, $size, $ext = 'jpg')
	{
		#error_log("SCALE_PHOTO=$basefolder, $filename $size, $ext");
		if ($size != 'medium' && $size != 'small') { error_log("Invalid call to _scalePhoto($basefolder, $filename, $size"); }
		$sizeto = array(
			'medium'=>200, # 200x200
			'small'=>85 # 85x85
		);

		$w = $sizeto[$size];
		$h = $sizeto[$size];

        	App::import('Vendor','phpthumb',array('file'=>'phpThumb'.DS.'phpthumb.class.php'));  
		$thumb = new phpthumb;
		$thumb->src = "$basefolder/large/$filename";
		$thumb->w = $w;
		$thumb->h = $h;
		$thumb->q = 100;
	        $thumb->config_imagemagick_path = '/usr/bin/convert';  
	        $thumb->config_prefer_imagemagick = true;  
	        $thumb->config_output_format = $ext;
	        $thumb->config_error_die_on_error = true;  
	        $thumb->config_document_root = '';  
	        $thumb->config_temp_directory = APP . 'tmp';  
	        $thumb->config_cache_directory = "$basefolder/$size/";
	        $thumb->config_cache_disable_warning = true;  
		$thumb->cache_filename = "$basefolder/$size/$filename";

		if (!is_dir("$basefolder/$size")) { mkdir("$basefolder/$size", 0755, true); }

		if ($thumb->GenerateThumbnail())
		{
			$thumb->RenderToFile($thumb->cache_filename);
		} else {
			error_log("Could not generate thumbnail to ".$thumb->cache_filename);
		}
	}

        function view($id = null) {
                if (!$id) {
                        $this->Session->setFlash(__('Invalid CustomImage.', true));
                        $this->redirect(array('action'=>'index'));
                }
                $this->set('customImage', $this->CustomImage->read(null, $id));
        }


	function view_img($size = null, $id = null) 
	{
		$this->_displayPhoto($size, $id);
		# XXX FIX SO WE PASS OWN TYPES OF PARAMETERS, view_primary PASSES OTHER...
	}

	function _displayPhoto($size = null, $id = null, $member_id = null) 
	{
		# MODIFY SO can handle given error images
		# and can handle photo_id and size
		# THIS should handle thumbnails! Not damned helper!

		#if (!$id || !$size) {
		#	$this->Session->setFlash(__('Invalid photo.', true));
		#	$this->redirect(array('action'=>'editlist'));
		#}

		# SINCE NO PHOTO, no member to cross reference!

		$photo = $this->MemberPhoto->read(null, $id);
		if (!$member_id) { $member_id = $photo["MemberPhoto"]["member_id"]; }

		$member = $this->Member->read(null, $member_id);

		if ($member['Member']['member_type'] == 'model')
		{
			$profile = $member['MemberModelProfile'];
		} else {
			#$profile = $member['MemberProfessionalProfile'];
			$profile = $member['MemberModelProfile'];
			# FOR NOW...
		}

		$genderpostfix = ($profile['gender'] == 'Female' ? '_female' : '_male'); # Default male.

		$ext = $photo["MemberPhoto"]["ext"];
		#error_log("EXT=$ext");
		if (!$ext) { $ext = "jpg"; }
		if (!preg_match("/[.]\w+$/", $id)) # Only add extension if not already there...
		{
			$relname = "$id.$ext";
		} else {
			$relname = $id;
		}

		###$this->view = 'Media';
		# BROKEN AS HELL!

		$base = APP;
		$img = "webroot/images";
		$memberfolder = "$img/members/$member_id";
		$file = "";

		$defaultfile = "default$genderpostfix.jpg";


		$defaultimage = array(
			#'large'=> "$img/members/default/large/error.jpg",
			#'medium'=> "$img/members/default/medium/error.jpg",
			#'small'=> "$img/members/default/small/error.jpg",

			'large'=> "$img/members/default/large/$defaultfile",
			'medium'=> "$img/members/default/medium/$defaultfile",
			'smallmedium'=> "$img/members/default/smallmedium/$defaultfile",
			'small'=> "$img/members/default/small/$defaultfile",
		);

		if ($size == 'large')
		{
			$file = $defaultimage['large'];
			if (file_exists("$base/$memberfolder/large/$relname"))
			{
				$file = "$memberfolder/large/$relname";
			}
		} else if ($size == 'smallmedium' || $size == 'medium' || $size == 'small') {
			# Resize if necessary.

			$file = $defaultimage[$size];
			# If large version exists and medium doesn't, scale.
			$sized = "$base/$memberfolder/$size/$relname";
			$large = "$base/$memberfolder/large/$relname";
			$default = "$base/".$defaultimage[$size];

			if (file_exists($sized) && filesize($sized))
			{
				$file = "$memberfolder/$size/$relname";
			} else if (file_exists($large) && filesize($large)) { # large exists.
				$this->_scalePhoto("$base/$memberfolder", $relname, $size, $ext);
				$file = "$memberfolder/$size/$relname";
			} else if (!file_exists($default) || !filesize($default)) { 
				# Scale large default.
				$this->_scalePhoto("$base/$img/members/default", "$defaultfile", $size, 'jpg');
				#error_log("SCALED!");
				$file = $defaultimage[$size];
			} # else, medium default exists, use THAT.
		}

		#error_log("DISPLAYING PHOTO=$file");

		$params = array(
			'id' => basename($file),
			'name' => '',
			'download' => false,
			'extension' => $ext,
			'path' => dirname("$file") . DS
		);

		#error_log("APP=".APP);

		#error_log("VIEW SETTING=".print_r($params,true));

		$this->set($params);

		$this->tm_media_view($params); # Hack until Media viewer gets fixed!
	}


	function admin_index() {
		$this->CustomImage->recursive = 0;
		$this->set('customImages', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CustomImage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('customImage', $this->CustomImage->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->CustomImage->create();
			if ($this->CustomImage->save($this->data)) {
				$this->Session->setFlash(__('The CustomImage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CustomImage could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CustomImage', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CustomImage->save($this->data)) {
				$this->Session->setFlash(__('The CustomImage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CustomImage could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CustomImage->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CustomImage', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CustomImage->del($id)) {
			$this->Session->setFlash(__('CustomImage deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
