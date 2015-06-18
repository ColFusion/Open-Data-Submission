<?php

require_once('DbHandler.php');

class MetadataHandler {
	public function saveMetadata($title, $description, $author, $email, $time = "", $geo = "", $source = "") {
		$dbHandler = new DbHandler();

		$id = $dbHandler->saveMetadata($title, $description, $author, $email, $time, $geo, $source);
		echo json_encode('blublue' . $id);
	}
}

?>