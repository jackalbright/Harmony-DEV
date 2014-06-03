<?

# We have really custom 
class UploadBehavior extends ModelBehavior
{
	var $errors = array();
	var $default_settings = array(
		'dir'=>'uploads',
		'basedir'=>null,
		'field'=>'file',
		'mime_types'=>array(),
		'key'=>'file',
			# List of file type restrictions, others will be invalid.
	);

	var $settings = array(); #Since only one object, must store by model key.

	# XXX TODO valid mime types/extensions...

	function setup(&$model, $config=array())
	{
		#$this->model = $model;

		$this->settings[$model->alias] = array_merge($this->default_settings, $config);
		
		# field, dir, etc.
		# dir: uploads, images, files, etc based on type
	}

	function beforeSave(&$model)
	{

		# Need to put this stuff here so it gets the site_id in time...
		# ? what if no site available?
		# /app/webroot/uploads/23/download_files/
		# /app/webroot/uploads/12/photos/

		# If we are dealing with multiple models, etc. 
		# All the file needs to be named is Related.file, ie Logo.file, Photo.file - the linker will handle the key, ie logo_id, photo_id, etc.

		$keys = $this->settings[$model->alias]['key'];
		if(!is_array($keys)) { $keys = array($keys); }

		foreach($keys as $key)
		{
			$rc = $this->upload($model, $key); # We have to call clearBlankUpload manually because we probably cannot reset other models' data after saveAll() is invoked.
			if(!$rc) { return $rc; } # Stop at first error.
	 	}
		return $rc;
		# Call upload...

		# Must return FALSE if we don't want the record saved (ie no file provided)...

	}

	function clearBlankUpload($model, &$data) # Called on a related model BEFORE saveAll, that should strip itself out of $this->data before saveAll() is called.
	# Integrated into our modified version of saveAll()
	{
		$field = 'file'; # ASSUME.
		$file_meta = !empty($model->data[$model->alias][$field]) ?  $model->data[$model->alias][$field] : null;
		if(empty($file_meta['file']) && $file_meta['error'] == UPLOAD_ERR_NO_FILE) 
		{ 
			unset($data[$model->alias]);
		};
		
	}

	function beforeDelete(&$model)
	{
        	$model->read(null, $model->id);
                if(isset($model->data)) {
			$path = $model->data[$model->name]['path'];
			$filename = $model->data[$model->name]['filename'];
			if(!empty($filename) && !empty($path))
			{
                        	$this->deleteFiles($filename, $path);
			}
                }
                return true;

	}

	function deleteFiles($filename, $dirname)
	{
		$webroot = APP."/webroot/";
		# Expects webroot prepended to filename. adds if not.
		if(!preg_match("@^$webroot@", $dirname))
		{
			$dirname = $webroot.$dirname;
		}

		if(file_exists("$dirname/$filename"))
		{
			@unlink("$dirname/$filename"); # Base file.
			# Silently ignore if can't remove file since not there, etc...
		}

		# Thumbnails. in arbitrary named dirs 200x200, 600x600, etc.
		$dir = opendir($dirname);
		while($file = readdir($dir))
		{
			if(is_dir("$dirname/$file"))
			{
				if(file_exists("$dirname/$file/$filename"))
				{
					@unlink("$dirname/$file/$filename");
				}
			}
		}
	}

	function file_required(&$model, $require = true)
	{
		$this->settings[$model->alias]['required'] = $require;
	}

	function fileProvided($model, $data = null, $field = null)
	{
		if(empty($data)) { $data = $model->data; }
		if(empty($field)) { $field = $this->settings[$model->alias]['field']; }
		$file_meta = !empty($data[$model->alias][$field]) ?  $data[$model->alias][$field] : null;

		if(empty($file_meta)) { return false; }
		return isset($file_meta['error']) && $file_meta['error'] != UPLOAD_ERR_NO_FILE;
	}

	###################################
	function upload(&$model = null, $field = 'file', $prefix = null)
	# EVEN IF WE FIND SOMETHING FANCY, WE SHOULD SAVE THIS
	# $path is likely the controller/model.
	{
		# Must return FALSE if we don't want the record saved (ie no file provided)...
		$modelpath = Inflector::tableize($model->name);
		$this->settings[$model->alias]['basedir'] = "{$this->settings[$model->alias]['dir']}/$modelpath";

		#if(empty($model)) { $model = $this->model; }
		# Should we utilize model level saving instead?
		#error_log("UPLOAD($field)=".print_r($model->data,true));

		if(empty($field)) { $field = $this->settings[$model->alias]['field']; }

		$required = !empty($this->settings[$model->alias]['required']) ? $this->settings[$model->alias]['required'] : null;

		if(empty($model->data[$model->alias][$field]) && !empty($model->id)) # Already saved and just saving an individual field.
		{
			error_log("SKIPPING EXXISTING FILE, NO NEED TO CHECK UPLOAD");
			return;
		}

		$file_meta = !empty($model->data[$model->alias][$field]) ?  $model->data[$model->alias][$field] : null;

		$filename = strtolower($file_meta['name']);
		preg_match("/.*[.](.*)$/", $filename, $matches);
		$ext = $matches[1];

		if(!isset($file_meta['error'])) {
			if(!empty($required) && (!is_array($required) || in_array($field, $required)))
			{
				error_log("NO UPLOAD {$model->alias} ($field), SILENT"); 
				return true; 
			} else {
				error_log("NO UPLOAD ($field), ALERT"); 
				$this->validationErrors[] = "No file was provided";
				return false;
			}
		} # No file specified/needed. just updating other stuff...



		#error_log("FILE_META={$model->alias} {$field} = ".print_r($file_meta,true));
		# This here conflicts with serializeable.....
		# thus, some field names are reservered to not be serialized!
		# or disalbe serializeable from use

		if(empty($file_meta['tmp_name'])) { 
			error_log("NO FILE FOUND=".print_r($file_meta,true));
			
			# No file specified. could just be editing associated text for file, etc.

			if(!empty($model->data[$model->alias]['id'])) # Existing record.
			{
				error_log("SKIPPING, EXISTING REORD");
				# XXX TODO REPLACING EXISTING IMAGE...
				# OK to skip file.
				return true;
			} else if ($file_meta['error'] == UPLOAD_ERR_NO_FILE) { 
				error_log("NO FILE PROVIDED, RESUMING NORMAL CODE................");
				# Seems like they didnt want to upload anything....

				# OK if auxiliary record, BAD if main.
				# Whether file absense will be ignored or required
				if(!empty($required) && (!is_array($required) || in_array($field, $required)))
				{
					error_log("REQUIRE FAIL $field");
					$model->validationErrors[$field] = "No file provided";
					return false;
				} else {
					error_log("OK, FILE NOT NEEDED");
					return true;
				}

			} else {
				error_log("REAL ERROR {$file_meta['error']} ");
				$error_str = "Could not save file. ";
				switch ($file_meta['error'])
				{
					case UPLOAD_ERR_INI_SIZE:
						$max = ini_get("upload_max_filesize");
						$error_str .= "File is too big (> $max).";
						break;
					#case UPLOAD_ERR_NO_FILE:
					#	$error_str .= "No file was specified.";
					#	break;
					case UPLOAD_ERR_CANT_WRITE:
						$error_str .= "Cannot write to disk.";
						break;
					case UPLOAD_ERR_OK:
						break; # good.
					default:
						$error_str .= "Unknown error.";
						break;
				}
				error_log("ERRSTR=$error_str");
				# Adding, not ok to skip file.
				$model->validationErrors[$field] = $error_str;
				return false;
			}
		}

		# Check mime type if restricted.
		#error_log("MT=".print_r($this->mime_types,true));

		if(!empty($this->settings[$model->alias]['mime_types']))
		{
			if(!in_array($file_meta['type'], $this->settings[$model->alias]['mime_types']))
			{
				$model->validationErrors[$field] = "Invalid file format, not allowed.";#(type of file is not allowed).";
				return false;
			}
		}

		if(!empty($this->settings[$model->alias]['formats']))
		{
			if(!in_array(strtolower($ext), $this->settings[$model->alias]['formats']))
			{
				$model->validationErrors[$field] = "File format is not supported. Please choose one of the following formats: ".join(", ", $this->settings[$model->alias]['formats']);
				return false;
			}
		}

		$file_name = $file_meta['name'];
		$file_name_parts = explode(".", $file_name);
		$file_ext = $file_name_parts[count($file_name_parts)-1];

		# instead of hostname, so files dont have to move

		if(empty($prefix))
		{
			$prefix = time().rand();
		}
		$outfile = "{$this->settings[$model->alias]['basedir']}/$prefix.$file_ext";

		$outdir = dirname(APP."/webroot/$outfile");
		if(!is_dir($outdir))
		{
			if(!mkdir($outdir, 0777, true)) # Make dir if needed.
			{
				$model->validationErrors[$field] = "Could not create directory $outdir";
				return false;
			}
		}


		$absoutfile = APP."/webroot/$outfile";
		#error_log("MOVING FILE FROM={$file_meta['tmp_name']} TO $absoutfile");
		#if(!move_uploaded_file($file_meta['tmp_name'], $absoutfile))
		if(!@rename($file_meta['tmp_name'], $absoutfile)) # Since we may use XHR uploads
		{

			error_log("CANT RENAME FILE FROM={$file_meta['tmp_name']} TO $absoutfile");
			$model->validationErrors[$field] =
				"Unable to move file from temporary location."; # File not found (bad code) or disk permissions.
			# Need way to get over properly.
			return false;
		}
		chmod($absoutfile, 0644); # Fix permissions, since default is 0600 per uploads.


		# Now save path and ext
		$pathkey = $model->hasField("{$field}_path") ? "{$field}_path" : "path";
		$model->data[$model->alias][$pathkey] = dirname($outfile);
		$filenamekey = $model->hasField("{$field}_filename") ? "{$field}_filename" : "filename";
		$model->data[$model->alias][$filenamekey] = basename($outfile);

		if($model->hasField("{$field}_name"))
		{
			$model->data[$model->alias]["{$field}_name"] = $file_meta["name"];
		} else if($model->hasField('name'))
		{
			$model->data[$model->alias]['name'] = $file_meta['name'];
		}
		if($model->hasField("{$field}_ext"))
		{
			$model->data[$model->alias]["{$field}_ext"] = $file_ext;
		} else if($model->hasField('ext'))
		{
			$model->data[$model->alias]['ext'] = $file_ext;
		}
		if($model->hasField("{$field}_size"))
		{
			$model->data[$model->alias]["{$field}_size"] = $file_meta["size"];
		} else if($model->hasField('size'))
		{
			$model->data[$model->alias]['size'] = $file_meta['size'];
		}
		if($model->hasField("{$field}_type"))
		{
			$model->data[$model->alias]["{$field}_type"] = $file_meta['type'];
		} else if($model->hasField('type'))
		{
			$model->data[$model->alias]['type'] = $file_meta['type'];
		}

		#error_log("UPLOAD RETURNING TRUE");

		return true;
	}

}
