<?php
class CompletedImagesController extends AppController {

	var $name = 'CompletedImages';

	function upload()
	{
		# Since post max size is same or less than upload, we have no room for other fields. so we lose all knowledge of everything...

		$this->layout = 'ajax';

		if(!empty($this->data))
		{
			foreach($this->data['CompletedImage'] as $i => $image)
			{
				$data = array('CompletedImage'=>$image);
				if($this->CompletedImage->fileProvided($data)) {
					# Let files override existing pics.

					$this->CompletedImage->create();
					if(!$this->CompletedImage->save($data))
					{
						$this->Session->setFlash("Could not load art. Please make sure art is 2M or less.",'warn');
						return;
					}
					error_log("SAVE SUCCESS");
					# Now store back into data
					$record = $this->CompletedImage->read();
					if(!empty($record['CompletedImage']))
					{
						$this->data['CompletedImage'][$i] = $record['CompletedImage'];
					}
					error_log("SAVING NEW IMG {$record['CompletedImage']['id']} AS #$i");
				} else if(!empty($image['id'])) # Load from db, existing.
				{
					$existing = $this->CompletedImage->read(null, $image['id']);
					$this->data['CompletedImage'][$i] = 
						!empty($existing['CompletedImage']) ?
						$existing['CompletedImage'] : null;
					error_log("SETTING EXISTING IMG {$image['id']} AS #$i");
				}
			}
			# need to allow for both uploads, or done separately with 0.id set on a previous version....
			error_log("DATA=".print_r($this->data,true));
		}
	}

	function thumb($id)
	{
		# XXX TODO
		$image = $this->CompletedImage->read(null, $id);
		$abspath = APP."/webroot/".$image['CompletedImage']['path'].'/'.$image['CompletedImage']['filename'];

		$exec = "convert $abspath -resize 250x png:-";

		header("Content-Type: image/png");
		echo shell_exec($exec);
		exit(0);
	}

	function delete($id)
	{
		$this->CompletedImage->delete($id);
		$this->action = 'upload';
	}

}
