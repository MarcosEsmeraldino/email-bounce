<?php

include_once 'controller/LeituraController.php';

// process controll
$time_start = microtime_float();

$quant = $_POST['quant'];
$email = $_POST['email'];
$senha = $_POST['senha'];


// controller
$controller = new LeituraController();


// list from gmail
$controller->fetchEmailsFromImap($email, $senha, $quant);
//$controller->fetchEmailsFromDB();

// process controll
$time_end = microtime_float();
$time = $time_end - $time_start;

echo "<br>Seconds to process: " . $time . "<br />";

function microtime_float() {
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}
