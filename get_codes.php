<?php

	error_reporting(E_ALL);
	header('Content-type: text/html; charset=utf-8');
	set_time_limit(3600000);

	require_once('lib/CodeGenerator.php');
	require_once('lib/file/CSVHandler.php');

	$generator = new CodeGenerator($_POST['pattern'], $_POST['quantity']);
	$generator->generateCodes();
	$generator->outputCodes('csv');

?>
