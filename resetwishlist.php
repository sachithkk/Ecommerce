<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
  require_once("includes/loggedin.php");
?>

<?php 
	
	delete($user_logged,"UserID","Wishlist");
	$_SESSION["msg"] = "<div class=\"clearfix\"></div><div class=\"alert alert-success\">
                        <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                        <strong>Success!</strong> Your Shopping Bag has been reset.
                      </div>";
	redirectTo("Wishlist.php");
?>