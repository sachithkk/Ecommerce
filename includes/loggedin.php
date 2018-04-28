<?php 

	if (!isset($_SESSION["user_logged"])){
		redirectTo("login.php");
	}

?>