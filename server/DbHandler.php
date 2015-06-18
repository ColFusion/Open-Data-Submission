<?php

require_once('DbCreds.php');

class DbHandler {
	private function getConnection() {
		$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE_NAME);

		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		return $conn;
	}

	public function saveMetadata($title, $description, $author, $email, $time = "", $geo = "", $source = "") {
		$sql = "INSERT INTO metadata (title, description, author, email, time, geo, source) VALUES (?, ?, ?, ?, ?, ?, ?)";

		$conn = $this->getConnection();

		try {
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("sssssss", $title, $description, $author, $email, $time, $geo, $source);

			$stmt->execute();

			$id = $conn->insert_id;			
		}
		catch(Exception $e) {			
			$conn->close();
			die("Something happened while saving metadata." . $e->getMessage());
		}
		
		$conn->close();

		return $id;
	}
}

?>