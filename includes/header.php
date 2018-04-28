<?php
//start session
session_start();

//function to redirectpage
function redirectTo($page){
  header("Location: $page");
  exit;
}
#$_SESSION["user_logged"] = null;

//getting logged in user ID detailsss
if (isset($_SESSION["user_logged"])){
		$user_logged = $_SESSION["user_logged"];
	}

//get value for cart
if(isset($_SESSION["cart"])){
	$itemno = sizeof($_SESSION["cart"]);
} else {
	$_SESSION["cart"] = array();
	$itemno = 0;
}
?>
