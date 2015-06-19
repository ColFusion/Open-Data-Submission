<?php

require_once('DbHandler.php');

class MailHandler {

	public function notifyAdmins($id, $title, $description, $author, $email, $time = "", $geo = "", $source = "") {
		$dbHandler = new DbHandler();

		$emails = $dbHandler->getAdminsEmails();

		if (count($emails) == 0) {
			return ;
		}

		$emails_comma_separated = $this->recieversString($emails); 

		$subject = $this->constructEmailSubject($id);
		$body = $this->constructEmailBody($id, $title, $description, $author, $email, $time, $geo, $source);

		$headers = $this->makeHeaders();

		mail($emails_comma_separated, $subject, $body, $headers);
	}

	private function makeHeaders() {
		$headers   = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-type: text/plain; charset=iso-8859-1";
		$headers[] = "From: CHIA/Col*Fusion Open Data Submission <no-reply@colfusion.exp.sis.pitt.edu>";
		$headers[] = "X-Mailer: PHP/".phpversion();

		return implode("\r\n", $headers);
	}

	private function recieversString($emails) {
		$emailsArray = array();

		foreach($emails as $email){
		   $emailsArray[] = $email["email"];
		}

		return implode(",", $emailsArray);
	}

	private function constructEmailSubject($id) {
		return "[CHIA/ColFusion - Open Data Submission] New Submission $id";
	}

	private function constructEmailBody($id, $title, $description, $author, $email, $time = "", $geo = "", $source = "") {
		return "id: $id\ntitle: $title\ndescription: $description\nauthor: $author\nemail: $email\ntime: $time\ngeo: $geo\nsource: $source";
	}
}

?>