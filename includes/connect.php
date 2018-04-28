<?php
	$host = "localhost";
	$username ="root";
	$password = "123";
	$database = "ecommerce";

	$connection = mysqli_connect($host, $username, $password, $database);

	if (!$connection){
		die("Connection to Database Error! Please contact the website administrator");
	}
?>