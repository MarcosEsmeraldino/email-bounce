<?php

class MySQLConnection {

	public static function getInstance() {

		$host = '*****';
		$user = '*****';
		$pass = '*****';
		$banco = '*****';

		// Create connection
		$conn = new mysqli($host, $user, $pass, $banco);

		// Check connection
		if ($conn->connect_error)
		    die("Connection failed: " . $conn->connect_error);

		// resolve acentuação
		$conn->set_charset("utf8");

		return $conn;

	}
	
}