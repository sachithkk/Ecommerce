<?php 
  	require_once("includes/header.php");
  	
	if (isset($_SESSION["user_logged"])){
		$_SESSION["user_logged"] = null;
		$user_logged = null;
		redirectTo("index.php");
	} else {
		redirectTo("index.php");
	}

?>