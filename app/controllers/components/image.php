<?
/*
	For handling uploading of images from a web page, saving to disk, scaling to create thumbnails, etc...

*/

class ImageComponent extends Object
{
	var $name = 'Image';
	var $components = array('Upload');
	var $config = array();
	var $controller = null;
	var $force_type = null;
	var $allowed = null;
	var $model = null;
	var $all_types = array('jpeg','jpg','gif','png','pdf','tif','eps');
	var $viewable_types = array('jpeg','jpg','gif','png');

	function startup(&$controller)
	{
		$this->controller = $controller;
		$this->model = $this->controller->modelClass;
	}

	function viewable_filename($filename)
	{
		list($fprefix, $fext) = preg_split("/[.]/", $filename);

		$viewable_ext = "png"; # For now.

		$is_viewable = false;
		foreach($this->viewable_types as $type)
		{
			if ($fext == $type)
			{
				$is_viewable = true;
				break;
			}
		}

		return strtolower($is_viewable?$filename : "$fprefix.$viewable_ext");
	}

	function getFileExtension($field)
	{
		$ext = 'jpg';
		if (is_array($field))
		{
			$objclass = $field[0];
			$fieldname = $field[1];
		} else {
			$objclass = $this->controller->modelClass;
			$fieldname = $field;
		}
		if (($fileobj = $this->controller->data[$objclass][$fieldname])) 
		{ # IF uploading too...
			$name = $fileobj["name"];
			$ext = preg_replace("/^.*[.](\w+)$/", "$1", $name);
		}
		return $ext;
	}

	function getOriginalFilenamePrefix($field)
	{
		$fileobj = $this->getUploadObject($field);
		#print_r($fileobj);
		$filename = preg_replace("/[.]\w+$/", "", basename($fileobj['name']));
		return $filename;
	}

	function didSupplyUpload($field)
	{
		$fileobj = $this->getUploadObject($field);
		#error_log("DATA=".print_r($this->controller->params,true));
		#error_log("FILE_OBBJ=".print_r($fileobj,true));
		return (!empty($fileobj) && $fileobj['tmp_name'] != "") ? true : false; # IF uploading too...
	}

	function failedUpload($field)
	{
		$fileobj = $this->getUploadObject($field);
		return (!empty($fileobj) && $fileobj['error'] == UPLOAD_ERR_INI_SIZE) ? true : false; # IF uploading too...
	}

	function getUploadObject($field)
	{
		if (is_array($field))
		{
			$objclass = $field[0];
			$fieldname = $field[1];
		} else if (preg_match("/[.]/", $field)) { 
			list($objclass, $fieldname) = pluginSplit($field);
		} else {
			$objclass = $this->model; # Can set to something else in case not standard.
			$fieldname = $field;
		}

		$fileobj = !empty($this->controller->data[$objclass][$fieldname]) ? $this->controller->data[$objclass][$fieldname] : null;
		#error_log("FORM=".print_r($this->controller->data,true));
		return $fileobj;
	}

	function saveUpload($field, $path, $prefix, $width = null, $height = null)
	# Needs to be named data[OBJCLASS][$field]
	{
		if(empty($this->allowed)) { $this->allowed = $this->all_types; }
		#error_log("SAVING $field AS $path / $prefix");
		#print_r($this->controller->data);
		#echo "OBJCL=$objclass, FI=$fieldname";
		if ($this->didSupplyUpload($field) && ($fileobj = $this->getUploadObject($field)))
		{
			#error_log("UPLOAD2=".print_r($fileobj,true));
			

			if ($fileobj["size"] < 1024) # Probably invalid!
			{
				return array("Invalid image. File size too small.");
			}

			$name = $fileobj["name"];
			$ext = preg_replace("/^.*[.](\w+)$/", "$1", $name);
			if (!$ext) { $ext = 'jpg'; }

			$destname = $prefix !== "" ? "$prefix.$ext" : $name;

			# XXX TODO shouldnt we rename the file to something more sane/standard? maybe the primary key?
			#die();

			# Now save file to disk...
			$rel_dest_path = sprintf("/$path/%s", $destname);
			$dest_path = APP . "/webroot/$rel_dest_path";

			$rel_dest_dir = dirname($rel_dest_path);
			$dest_dir = dirname($dest_path);
			$dest_file = basename($dest_path);

			#error_log("DEST_DIR=$dest_dir, DEST_FILE=$dest_file");

			if (!is_dir($dest_dir))
			{
				if (!mkdir($dest_dir, 0755, true))
				{
					return array("Sorry, unable to create folder $dest_dir");
				} else {
					#error_log("CREATED $dest_dir");
				}
			}

			#error_log("SAVING AS $dest_path");

			$this->Upload->upload($fileobj, "$dest_dir/", $dest_file, null, $this->allowed);
			$errors = $this->Upload->errors;
			if (is_array($errors))
			{
				return $errors;
			} else {
				if ($this->force_type)
				{
					# Convert!
					$dest_file_oldtype = $dest_file;
					$oldtype = preg_replace("/.*[.](\w+)$/", '$1', $dest_file);
					if ($oldtype != $this->force_type) # Dont try to convert if already same file type. will clobber!
					{
						$dest_file_prefix = preg_replace("/(.*)[.]\w+$/", '$1', $dest_file);
						$dest_file = "$dest_file_prefix.".$this->force_type;
						#error_log("DOING FORCING FROM $dest_dir / $dest_file_oldtype TO= $dest_dir / $dest_file");
						$rc = $this->scaleFile("$dest_dir/$dest_file_oldtype", "$dest_dir/$dest_file", $width, $height);
						#error_log("RC=".print_r($rc,true));
						if (is_array($rc)) {
							return $rc;
						} else if (!$rc)
						{
							return array("Could not convert image");
						} else {
							unlink("$dest_dir/$dest_file_oldtype");
						}
					}
				}
				#error_log("WID=$width, HEI=$height");
				if ($height || $width)
				{
					#echo "REL_DEST=$rel_dest_dir, DF=$dest_file";
					$rc = $this->scaleFile("$dest_dir/$dest_file", "$dest_dir/$dest_file", $width, $height);
					if (is_array($rc)) {
						return $rc;
					} else if (!$rc) {
						return array("Could not scale image down");
					}
				}

				return $destname;
			}

		} else {
			error_log("No file supplied for upload...");
			#return array("No file supplied. Internal error?");
			return null;
		}
	}

	function convertPSD_SLOW($src, $dest)
	{
		list($dprefix, $dext) = preg_split("/[.]/", $dest);
		include_once(dirname(__FILE__)."/../../../includes/classPhpPsdReader.php");
		set_time_limit(120);
		ini_set("mysql.connect_timeout", 120);

		$img = imagecreatefrompsd($src);
		$data = null;
		if ($dext == 'jpeg' || $dext == 'jpg')
		{
			$data = imagejpeg($img, $dest);
		} else if ($dext == 'png') { 
			$data = imagepng($img, $dest);
		} else if ($dest == 'gif') {
			$data = imagegif($img, $dest);
		} else {
			error_log("convertPSD: unsupported file format: $dest");
			return ; #BARF
		}
	}

	function convertPSD($src, $dest)
	{
		$cmd = "convert -flatten $src $dest";
		exec($cmd, $errors);

		#list($dprefix, $dext) = preg_split("/[.]/", $dest);
		#include_once(dirname(__FILE__)."/../../../includes/classPhpPsdReader.php");
		#set_time_limit(120);
		#ini_set("mysql.connect_timeout", 120);
#
#		$img = imagecreatefrompsd($src);
#		$data = null;
#		if ($dext == 'jpeg' || $dext == 'jpg')
#		{
#			$data = imagejpeg($img, $dest);
#		} else if ($dext == 'png') { 
#			$data = imagepng($img, $dest);
#		} else if ($dest == 'gif') {
#			$data = imagegif($img, $dest);
#		} else {
#			error_log("convertPSD: unsupported file format: $dest");
#			return ; #BARF
#		}
	}

	function convertTIF($src, $dest)
	{
		$cmd = "convert $src $dest";
		error_log("CONVERT_TIF=$cmd");
		exec($cmd, $errors);
	}

	function convertEPS($src, $dest)
	{
		$cmd = "convert $src $dest";
		exec($cmd, $errors);
	}

	function convert($src, $dest, $args = '')
	{
		$cmd = "convert $src $args $dest";
		exec($cmd, $errors);
	}

	function convertPDF($src, $dest)
	{
		#$cmd = "convert -flatten $src $dest";
		$cmd = "convert -density 300 -units pixelsperinch -trim '{$src}[0]' $dest"; # Remove extra whitespace, likely letter-sized page.
		# the [0] will extract page 1, otherwise it saves to multiple files.
		#error_log("COMMEND=$cmd");
		exec($cmd, $errors);
		if(!empty($errors))
		{
			error_log("ERR=".print_r($errors,true));
		}
	}

	function scaleFile($srcname, $dstname = null, $w = null, $h = null, $relative = false, $rotdeg = 0)
	#Does conversion from one type to another too...
	{
		error_log("SCALEFILE, $srcname => $dstname, w=$w, h=$h, rel=$relative, rot=$rotdeg");
		# Source should NOT start with a slash....
		$srcfile = (preg_match("/^\//", $srcname) && !$relative) ? $srcname : APP . "/webroot/$srcname" ;
		$dstfile = (!$relative && (!$dstname || preg_match("/^\//", $dstname))) ? $dstname : APP . "/webroot/$dstname";
		#error_log("GETTING IMAGE SIZE=$srcfile ($srcname)");
		#error_log("FROM $srcname TO $dstname");

		# Make sure source file is in readable format. If not, convert.
		$viewable_srcfile = strtolower($this->viewable_filename($srcfile));
		$viewable_srcfile_png = preg_replace("@[.]\w+$@", ".png", $viewable_srcfile);

		#error_log("VIEWABLE=$viewable_srcfile");

		if(strtolower($viewable_srcfile) != strtolower($srcfile))
		{
			list($sprefix, $sext) = preg_split("/[.]/", strtolower($srcfile));
			error_log("EXT=$sext");
			if ($sext == 'psd')
			{
				$this->convertPSD($srcfile, $viewable_srcfile_png);
				$srcfile = $viewable_srcfile;
			} else if ($sext == 'eps') {
				$this->convertEPS($srcfile, $viewable_srcfile_png);
				$srcfile = $viewable_srcfile;
			} else if ($sext == 'pdf') {
				$this->convertPDF($srcfile, $viewable_srcfile_png);
				$srcfile = $viewable_srcfile;
			} else if ($sext == 'tif') {
				$this->convertTIF($srcfile, $viewable_srcfile_png);
				$srcfile = $viewable_srcfile;
			} # Else, dunno!
		}

		try
		{
			list($oldwidth, $oldheight) = getimagesize($srcfile);
		} catch (Exception $e) {
			return array("Could not get image size for saving/resizing: ". $e->getMessage());
		}
		#$oldwidth = 100;
		#$oldheight = 100;

		# XXX TODO IF SVG READ FILE FOR W/H

		$ext = preg_replace("/^.*[.](\w+)$/", "$1", $dstfile);
		if (!$ext) { $ext = 'jpg'; }
		
		$src_ext = preg_replace("/^.*[.](\w+)$/", "$1", $srcfile);
		if (!$src_ext) { $src_ext = 'jpg'; }

		if ($w > 0 && $w <$oldwidth)
		{
			$h2w_ratio = $oldheight / $oldwidth;
			$h = $w * $h2w_ratio;
		} else if ($h > 0 && $h<$oldheight) {
			$w2h_ratio = $oldwidth / $oldheight;
			$w = $h * $w2h_ratio;
		} else if ($srcfile == $dstfile) { # No size change, no name change. Abort.
			return $dstfile;

		} else { # Already small enough, dont bother. NEVER SCALE LARGER!
			$w = $oldwidth;
			$h = $oldheight;
		}
		error_log("ORIG W/H=$oldwidth,$oldheight; NEW=$w,$h");

		#error_log("W=$w, H=$h");
		#error_log("FILE=$srcfile, SIZE=".filesize($srcfile));

		if (!$dstfile) # Print out!
		{
			# Return as variable (string)
			$image = $this->generateThumbnail($srcfile, null, $w, $h, $rotdeg);
			#echo "IM=$image";
			return $image;

		} else {
			$destfolder = dirname($dstfile);
			if (!is_dir("$destfolder")) { if (!mkdir("$destfolder", 0755, true)) { return array("Could not create folder: $destfolder"); } }


			$overwrite = ($dstfile == $srcfile);

			if($overwrite)
			{
				$dstfile = "$dstfile.tmp";
			}
	
			$rc = $this->generateThumbnail($srcfile, $dstfile, $w, $h, $rotdeg);

			if($overwrite)
			{
				$dstfile_orig = preg_replace("/[.]tmp$/", "", $dstfile);
				rename($dstfile, $dstfile_orig);
			}
	
			if ($rc)
			{
				error_log("Could not generate thumbnail to ". $dstfile);
				return array("Could not generate thumbnail: $rc");
			}
			return $dstfile;
			#return $ok;
		}
	}

	function generateThumbnail_gd($srcfile, $dstfile = null, $w, $h)
	# USING GD, wont barf at big files...
	{

		ini_set("memory_limit","200M");
		$orig = null;
		$imgtype = exif_imagetype($srcfile);
		if ($imgtype == IMAGETYPE_GIF)
		{
			$orig = imagecreatefromgif($srcfile);
		} else if ($imgtype == IMAGETYPE_JPEG) {
			$orig = imagecreatefromjpeg($srcfile);
		} else if ($imgtype == IMAGETYPE_PNG) { 
			$orig = imagecreatefrompng($srcfile);
		} else {
			return "Unable to generate thumbnail. Unrecognized image format.";
		}

		$thumb = imagecreatetruecolor($w, $h);
		#list($src_w, $src_h) = getimagesize($srcfile);
		$src_w = imagesx($orig);
		$src_h = imagesy($orig);

		imagecopyresampled($thumb, $orig, 0, 0, 0, 0, $w, $h, $src_w, $src_h);

		if ($imgtype == IMAGETYPE_GIF)
		{
			imagegif($thumb, $dstfile);
		} else if ($imgtype == IMAGETYPE_JPEG) {
			imagejpeg($thumb, $dstfile);
		} else if ($imgtype == IMAGETYPE_PNG) { 
			imagepng($thumb, $dstfile);
		}

		return;
	}

	function generateThumbnail($srcfile, $dstfile = null, $w = 0, $h = 0, $rotdeg = 0)
	{
		error_log("GENERATING THUMBNAIL $srcfile -> $dstfile , W=$w, H=$h, ROT=$rotdeg");

		if(!empty($rotdeg)) { return $this->generateThumbnail_im($srcfile, $dstfile, $w, $h, $rotdeg); }

		ini_set("memory_limit","200M");

		# Use imagemagick directly, so proper command run!
		$outfile = ($dstfile != $srcfile) ? $dstfile : tempnam("/tmp", "img-");

		/*
		$image = new Imagick($srcfile);

		$image->setImageBackgroundColor("none"); # Don't add white, but tell to stay transparent if possible
		# WHY MESS UP TRANSPARENCY????

		$image = $image->flattenImages(); # Will put in designated bg color...

		$image->thumbnailImage($w,$h);

		error_log("THUMB, W=$w, H=$h");

		$image->writeImage($outfile);
		*/

		$convert = "convert $srcfile -resize {$w}x{$h} $outfile";
		exec($convert);
		error_log("$convert");
		chmod($outfile, 0644); # GRR... uploaded file is 0600; some damned bug in uploader

		error_log("CONVERT+$convert");

		#error_log("READ FROM $srcfile, SAVED TO=$outfile");
		#	error_log("PERMS src=$srcfile=".substr(sprintf("%o", fileperms($srcfile)), -4));
		#	error_log("PERMS out=$outfile=".substr(sprintf("%o", fileperms($outfile)), -4));

		if($outfile != $dstfile)
		{
			if(file_exists($dstfile))
			{
				#error_log("DELETING $dstfile");
				if(!unlink($dstfile))
				{
					#error_log(system("id"));
					error_log("CANNOT REMOVE OLD FILE $dstfile");
				}
				if(file_exists($dstfile))
				{
					error_log("DAMNED FILE STILL EXISTS $dstfile");
				}
			}
			#error_log("MOVING $outfile TO $dstfile");
			#error_log("PERMS dest=$dstfile=".fileperms($dstfile));
			#error_log("PERMS dest=$dstfile=".substr(sprintf("%o", fileperms($dstfile)), -4));
			rename($outfile, $dstfile);

			#error_log("DONE MOVE");
		}
		return;
	}


	function generateThumbnail_im($srcfile, $dstfile = null, $w, $h, $rotdeg = 0)
	{
		error_log("GENUTHBM $srcfile => $dstfile");
		ini_set("memory_limit","200M");
        	app::import('Vendor','phpthumb',array('file'=>'phpThumb'.DS.'phpthumb.class.php'));  
		$thumbnail = new phpthumb;
		$thumbnail->src = $srcfile;
		$thumbnail->w = $w;
		$thumbnail->h = $h;
		$thumbnail->q = 100;

		$cachepath = dirname($dstfile);

		$ext = preg_replace("/(.*)[.](\w+)$/", "$2", $dstfile);
		if (!$ext) { $ext = 'png'; }

		#error_log("EXT=$ext");
		
        	$thumbnail->config_imagemagick_path = '/usr/bin/convert';  
        	$thumbnail->config_prefer_imagemagick = true;  
        	#$thumbnail->config_output_format = 'jpg';  
		$thumbnail->config_output_format = $ext;

        	$thumbnail->config_error_die_on_error = false;  
        	$thumbnail->config_document_root = '';  
        	$thumbnail->config_temp_directory = APP . 'tmp';  
        	$thumbnail->config_cache_directory = dirname($dstfile);
        	$thumbnail->config_cache_disable_warning = true;  

        	$thumbnail->cache_filename = $dstfile;

		if (!is_file($thumbnail->src))
		{
			return "Original image does not exist";
		}


		$thumbnail->GenerateThumbnail();
		if (!$thumbnail->cache_filename)
		{
			#echo "CF";
			$thumbnail->useRawIMoutput = true;
			$thumbnail->RenderOutput();
			$data = $thumbnail->outputImageData;
			return $data;
		}

		#error_log("SAVING FROM ".$thumbnail->src.", TO ".$thumbnail->cache_filename);

		error_log("ROT=$rotdeg");
			$thumbnail->phpThumbDebug = true;

		$thumbnail->RenderToFile($thumbnail->cache_filename);

		if($rotdeg)
		{
			#$thumbnail->ra = $rotdeg;
			#$thumbnail->Rotate();

			$srcfile = $thumbnail->cache_filename;

			$imgtype = exif_imagetype($srcfile);

			if ($imgtype == IMAGETYPE_GIF)
			{
				$orig = imagecreatefromgif($srcfile);
			} else if ($imgtype == IMAGETYPE_JPEG) {
				$orig = imagecreatefromjpeg($srcfile);
			} else if ($imgtype == IMAGETYPE_PNG) { 
				$orig = imagecreatefrompng($srcfile);
			} else {
				return "Unable to generate thumbnail. Unrecognized image format.";
			}
			$rotated_img = imagerotate($orig, $rotdeg, 0);

			if ($imgtype == IMAGETYPE_GIF)
			{
				imagegif($rotated_img, $srcfile);
			} else if ($imgtype == IMAGETYPE_JPEG) {
				imagejpeg($rotated_img, $srcfile);
			} else if ($imgtype == IMAGETYPE_PNG) { 
				imagepng($rotated_img, $srcfile);
			} else {
				return "Unable to generate thumbnail. Unrecognized image format.";
			}
		}




		#foreach($thumbnail->debugmessages as $msg)
		#{
		#	error_log($msg);
		#}


		if (preg_match("/too large/", $thumbnail->fatalerror))
		{
			return "Image is too large. Please reduce the size of your image to upload it properly.";
		}

		return;
	}


}

?>
