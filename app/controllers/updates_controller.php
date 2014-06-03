<?php
class UpdatesController extends AppController {
	var $helpers = array('Html','Javascript','Ajax');
	var $components = array('Upload','Archive');
	var $uses = array();

	function admin_index()
	{
		$this->redirect(array('action'=>'add'));
	}

	function admin_add()
	{

		if(!empty($this->data))
		{
			$fileobj = $this->data['Update']['file'];
			$destdir = APP."/webroot/updates/";
			$destfile = $fileobj['name'];

			if(!is_dir($destdir))
			{
				mkdir($destdir);
			}

			$srcfile = $fileobj['tmp_name'];

			if(is_file($srcfile))
			{
				#move_uploaded_file($srcfile, "$destdir/$destfile");
				echo "UPLOAD FILE EXISTS $srcfile TO $destdir / $destfile";
				#exit(0);
			} else {
				echo "UPLOAD FILE MISSING $srcfile";

			}

			$this->Upload->allowed = array('bz2','gz','zip','tgz');
			$this->Upload->upload($fileobj, $destdir, $destfile);
			$flash .= "FILE=".print_r($fileobj,true);
			if(!empty($this->Upload->errors))
			{
				$flash .= join("<br/>\n", $this->Upload->errors);
			}
			$flash .= "<br/>\nSaving file {$fileobj['name']} to $destdir/$destfile";

			# Now unpack files.
			if($this->Archive->extract("$destdir/$destfile", APP."/../"))
			{
				$flash .= "<br/>\nUpload and extract successful.";
			} else {
				$flash .="<br/>\nExtract failed - $destdir/$destfile TO ".APP."/../";
			}
			$this->Session->setFlash($flash);
		}
	}

}

?>