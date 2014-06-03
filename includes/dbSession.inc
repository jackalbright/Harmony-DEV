<?php
	class session {
	var $db;
	var $a;
	
	function _open($path, $name) {
		if ( strpos($_SERVER['SERVER_NAME'], 'hdtest') !== false ) {
			$this->db = mysql_connect ("localhost", "hdadmin_hdadmin", "sf6554", true ) or die ('I cannot connect to the database because: ' . mysql_error());
			mysql_select_db( "hdadmin_hdTestMain", $this->db );
		} else if ( $_SERVER['SERVER_NAME'] == 'harmonydesigns.malysoft.com') {
			$database = mysql_connect ("localhost", "harmony_main", "harmony_main1"); //or die ('I cannot connect to the database because: ' . mysql_error());
			mysql_select_db( "harmony_main", $database );
		} else {
			$this->db = mysql_connect 
("cannon.safesecureweb.com", "harmony_main", "idk2Xbbq", true ) or die ('I cannot connect to the database because: ' . mysql_error());
			mysql_select_db( "harmony_main", $this->db );	
		}
		return true;
	} 

	/* Close session */ 
	function _close() { 
		if ( rand(1,100) < 10 ) {
			$this->_gc(0);
		}
		mysql_close($this->db);
		return true;
	} 

	/* Read session data from database */ 
	function _read($ses_id) {
		$done = false;
		while ( ! $done ) {
			$result = mysql_query ("Select `lock`, ISNULL(`lock`) as unlocked from phpSession where id='$ses_id'", $this->db);
			if ( mysql_num_rows($result) > 0 ) {
				$temp = mysql_fetch_object($result);
				if ($temp->unlocked) {
					$done = true;
				} else if ( time() - strtotime($temp->lock) > 60 ) {
					$done = true;
				} else {
					sleep(2);
				}
			} else {
				$done = true;
			}
		}
		
		mysql_query ("LOCK TABLES `phpSession` WRITE", $this->db);		
		$result = mysql_query ("Select * from phpSession where id= '$ses_id'", $this->db);
		if (mysql_num_rows($result) > 0) {
			$temp = mysql_fetch_object ($result);
			$result = mysql_query("Update phpSession set `lock` = NOW() where id = '$ses_id'", $this->db);
			$info = $temp->data;
		} else {
			$info = '';
		}
		mysql_query ("UNLOCK TABLES", $this->db);
		return $info;
	} 

	/* Write new data to database */ 
	function _write($ses_id, $data) {
		$dbData = mysql_real_escape_string($data);
		$result = mysql_query ("SELECT `start` from phpSession where id='$ses_id'", $this->db);
		if ( mysql_num_rows($result) == 0 ) {
			$ipAddress = mysql_real_escape_string($_SERVER['REMOTE_ADDR']);
			$query = "Insert into phpSession values('$ses_id', NOW(), NOW(), '$dbData', NULL, '$ipAddress')";
			$result = mysql_query($query, $this->db);
		} else {
			$query = "Update phpSession set data = '$dbData', lastAccess = NOW(), `lock`=NULL where id = '$ses_id'";
			$result = mysql_query ($query, $this->db);
		}
		return true;
	} 

	/* Destroy session record in database */ 
	function _destroy($ses_id) {
		#$sessionPath = $_SERVER['DOCUMENT_ROOT'] . '/phpSession';
		$sessionPath = dirname(__FILE__)."/../phpSession";
		$query = "Delete from phpSession where id = '$ses_id'";
		$result = mysql_query($query, $this->db);
		$this->recursiveDelete ("$sessionPath/$ses_id");
		print ("deleting session");
		return true;
	} 

	/* Garbage collection, deletes old sessions */ 
	function _gc($life) {
		$limit = date('Y-m-d G:i:s', strtotime("-12 hours") );
		#$sessionPath = $_SERVER['DOCUMENT_ROOT'] . '/phpSession';
		$sessionPath = dirname(__FILE__)."/../phpSession";
		$query = "Select id from phpSession where lastAccess < '$limit'";
		$result = mysql_query ($query, $this->db);
		while ( $temp = mysql_fetch_object ($result) ) {
			$this->recursiveDelete ("$sessionPath/$temp->id");
		}
		$query = "Delete from phpSession where lastAccess < '$limit'";
		$result = mysql_query ($query, $this->db);
		$query = "Optimize table phpSession";
		$result = mysql_query ($query, $this->db);
		return true;
	}
	
	function recursiveDelete ($path) {
		if ( file_exists ($path) ) {
			$directory = opendir($path);
			while ( $entry = readdir ($directory) ) {
				if ( is_file ("$path/$entry") ) {
					unlink ("$path/$entry");
				} else if ( is_dir("$path/$entry") && $entry != '.' && $entry != '..' ) {
					$this->recursiveDelete("$path/$entry");
				}
			}
			closedir ($directory);
			rmdir($path);
		} // end if ( file_exists($path) )
	}
} 
?>
