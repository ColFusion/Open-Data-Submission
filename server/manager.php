<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

error_reporting(E_ALL | E_STRICT);
require('MetadataHandler.php');
require('UploadHandler.php');

if (isset($_GET["action"]) && trim($_GET["action"]) === 'submissions') {
	$metadata_handler = new MetadataHandler();
	$allSubmissions = $metadata_handler->getAll();

	echo json_encode($allSubmissions);
}
else if (isset($_GET["action"]) && trim($_GET["action"]) === 'filesList'
	&& isset($_GET["id"])) {
	$upload_handler = new UploadHandler();
	$upload_handler->initialize();	
}
else {	
	die('Not supported request.');
}
?>