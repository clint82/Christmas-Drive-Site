<?php

require_once 'includes/constants.php';

class Mysql {

	private $conn;
	
	function __construct() {
		$this->conn = new Mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME) or 
						die('There was a problem connecting to the database.');
	}


	function verify_username_and_pass($username, $pwd) {
	
		$query = "SELECT *
				FROM users
				WHERE username = ? AND password = ?
				LIMIT 1";
				
		if($stmt = $this->conn->prepare($query) ) {
			$stmt->bind_param('ss', $username, $pwd);
			$stmt->execute();
			
			if($stmt->fetch()) {
				$stmt->close();
				return true;
			}
		}
				
	}

}