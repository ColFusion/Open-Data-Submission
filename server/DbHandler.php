<?php

class DbHandler {
	const servername = "localhost";
	const username = "";
	const password = "";
	const database_name = "";

	private function getConnection() {
		$conn = new mysqli(self::servername, self::username, self::password, self::database_name);

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