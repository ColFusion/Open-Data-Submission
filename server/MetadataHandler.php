<?php

require_once('DbHandler.php');

class MetadataHandler {
	public function saveMetadata($title, $description, $author, $email, $time = "", $geo = "", $source = "") {
		$dbHandler = new DbHandler();

		$id = $dbHandler->saveMetadata($title, $description, $author, $email, $time, $geo, $source);
		return $id;
	}

	public function getAll() {
		$dbHandler = new DbHandler();

		$allSubmissions = $dbHandler->getAll();
		return $allSubmissions;
	}
}

?>