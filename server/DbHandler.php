<?php

$ini_array = parse_ini_file("../config.ini");

class DbHandler {
	private function getConnection() {
		$conn = new mysqli($ini_array["mysql_servername"],
				           $ini_array["mysql_username"],
				           $ini_array["mysql_password"],
				           $ini_array["mysql_database_name"]);

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

	public function getAll() {
		$sql = "SELECT * from metadata";

		return $this->queryToArray($sql);
	}

	public function getAdminsEmails() {
		$sql = "SELECT * from admin_emails";

		return $this->queryToArray($sql);
	}

	private function queryToArray($sql) {
		$conn = $this->getConnection();

		$rows = array();

		try {
			$result = $conn->query($sql);
			
			while($row = $result->fetch_assoc()) {
			    $rows[] = $row;
			}
		}
		catch(Exception $e) {			
			$conn->close();
			//TODO: should probably throw an exception
			throw new Exception("Something happened while getting metadata." . $e->getMessage());
		}
		
		$conn->close();

		return $rows;
	}
}

?>