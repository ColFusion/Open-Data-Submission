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

if (isset($_GET["payload"]) && trim($_GET["payload"]) === 'metadata') {
	$metadata_handler = new MetadataHandler();
	$metadata_handler->saveMetadata($_POST["title"], $_POST["description"], $_POST["author"], $_POST["email"], $_POST["time"], $_POST["geo"], $_POST["source"]);
}
else {
	$upload_handler = new UploadHandler();
}
?>