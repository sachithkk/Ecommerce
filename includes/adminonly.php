<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
?>

<?php 

  //redirect to 404 if the logged in user is not an admin
  $result = getAlluser("Users", $user_logged);
  $row = mysqli_fetch_assoc($result);
  if ($row["UserType"] != "Admin"){
    redirectTo("404.php");
  }

 ?>