<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
  require_once("includes/loggedin.php");
  $_SESSION["parentpage"] = "Check Out";
  $_SESSION["pagetitle"] =  "Bill";
?>
<?php
	
	if(isset($_GET["PaymentStatus"])){
	  if(($_GET["PaymentStatus"] == 'ok') && (count($_SESSION["cart"]) > 0)){
		$date = date("Y-m-d H-i-s");
		$query = "INSERT INTO Payment (UserID, PDATE) VALUES ";
		$query .= "( ".$user_logged.",'".$date."' )";

		$result = mysqli_query($connection, $query);
			if($result){
				$query = "SELECT PaymentID FROM Payment WHERE ";
				$query .= "UserID=".$user_logged." AND PDATE = '".$date."'";
				$result = mysqli_query($connection, $query);
				$Payment = mysqli_fetch_assoc($result);
				$PaymentID = $Payment["PaymentID"];
				foreach ($_SESSION["cart"] as $key => $value) {
					$result = getAllProduct("Product", $key);
					$Product = mysqli_fetch_assoc($result);
					$query = "INSERT INTO Paymentdetail ";
					$query .= "VALUES (".$PaymentID.", ".$Product["ProductID"].", '".$Product["Name"]."', ".$value.", ".$Product["Price"].")";
					mysqli_query($connection, $query);
				}
			}
		$_SESSION["cart"] = array();
		redirectTo("bill.php?PaymentID=$PaymentID");
	 }
	}
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

  require_once("includes/htmlheader.php");
?>
    	<div class="container">
    		<div class="col-xs-12" style="height: 50px;">
    		</div>
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
    		<div class="col-sm-12 col-md-5">
    			<h3>Thank you for Shopping at KoolBabies.lk!</h3>
    			<h4>We are glad to help you do your shopping! Please shop with us again</h4>
    			<h6>Your transaction of a total Rs000 was recieved. Your Payment history has been updated accordingly. Please purchased items will be delivered to your doorstep with in a few days depending on the your shipping address. If you have not received your items within 4 days from the date of order please do not heistate to contact our customer service free toll number +94258963147. And if you have any issue about the items quality and quantity at the time of arrival then please contact us with in 2 hours from the time reciving the goods.</h6>
    			<h6>If you fail to comply by the rules mentioned above we will not be able to refund or exchage your items. We deeply apologize for any inconviences. And Thankyou once again for shopping with us. We hope you had a good experience. </h6>
                <br/><br/>
                <a class="btn btn-primary addbtn" href="printbill.php?PaymentID=<?php echo $PaymentID ?>"><i class="fa fa-print fa-lg" aria-hidden="true"></i> Print Invoice</a>
                <a class="btn btn-primary addbtn" href="history.php"><i class="fa fa-history fa-lg" aria-hidden="true"></i> View Purchase History</a>
    		</div>
    		<div class="col-xs-12" style="height: 50px;">
    		</div>
    	</div>

<?php require_once("includes/footer.php");?>