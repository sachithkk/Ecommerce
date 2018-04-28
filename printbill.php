<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
  require_once("includes/loggedin.php");
?>
<?php
	
	if(isset($_GET["PaymentID"])){

		$PaymentID =  mysqli_real_escape_string($connection, $_GET["PaymentID"]);

		$query = "SELECT UserID FROM Payment WHERE ";
		$query .= "PaymentID = ".$PaymentID ;

		$result =  mysqli_query($connection, $query);
		$user = mysqli_fetch_assoc($result);

		if($user_logged != $user["UserID"]){
			redirectTo("404.php");
		} else{
			$query = "SELECT * FROM Paymentdetail WHERE PaymentID = ".$PaymentID;
    		$billresult = mysqli_query($connection, $query);
		}
	}else{redirectTo("404.php");}
?>
		<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kiyeydha.lk </title>

    <!-- Bootstrap Framework -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!--Css-->
    <link rel="stylesheet" type="text/css" href="css/stylesheet.css"/>

    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,800" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
   
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!--Bootstrap Libraries-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.2.0/bootstrap-slider.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.2.0/css/bootstrap-slider.min.css" rel="stylesheet"/>
    <!--Javascript-->
    <script type="text/javascript" src="js/script.js"></script> 
    </head>
    <body onload="window.print();">
    		<div class="col-sm-12 col-md-7">
    		   <div class="col-xs-12" id="bill">
    		   <br/> <br/>
    			<h2>Your Invoice Details</h2>
    			<br/><br/>
    			<?php 
    				$query = "SELECT * FROM Payment WHERE PaymentID=".$PaymentID;
    				$result =  mysqli_query($connection, $query);
					$pymnt = mysqli_fetch_assoc($result);
    			?>
    			<h6 class="col-md-6"><b>Invoice ID:</b></br>INV-<?php echo $pymnt["PaymentID"] ?></h6>
    			<h6 class="col-md-6"><b>Invoice Date and Time:</b></br> <?php echo $pymnt["PDATE"] ?></h6>
    			<br/><br/>
    			<table class="table table-hover">
    				<tr>
    					<th>Item</th>
    					<th>Price</th>
    					<th>Quantity</th>
    					<th>Total</th>
    				</tr>
    				<?php 
    					$total = 0;
    					while($billProduct = mysqli_fetch_assoc($billresult)){
    				?>
    				<tr>
    					<td><?php echo $billProduct["PName"] ?></td>
    					<td><?php echo $billProduct["Amount"] ?></td>
    					<td><?php echo $billProduct["Quantity"] ?>pcs</td>
    					<td><?php 
    						$amount = ($billProduct["Amount"]*$billProduct["Quantity"]);
    						$total = $total + $amount;
    						echo $amount; ?>
    					</td>
    				</tr>    				
    				<?php } ?>

    				<tr><td colspan="4" class="billtotal"><h4>Total: Rs <?php echo $total ?></h4></td></tr>
    			</table>
    		  </div> <!-- bill -->  
    	</div>
    </body>
   </html>