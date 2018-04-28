<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
  require_once("includes/loggedin.php");
?>

<?php 
	
	$query = "SELECT * FROM Payment WHERE UserID=".$user_logged;
	$result = mysqli_query($connection, $query);
	while($rows = mysqli_fetch_assoc($result)){
		$query = "DELETE FROM Paymentdetail WHERE PaymentID =".$rows["PaymentID"];
		mysqli_query($connection, $query);
	}
	$query = "DELETE FROM Payment WHERE UserID=".$user_logged;
	mysqli_query($connection, $query);
	redirectTo("history.php");
?>