<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
  require_once("includes/loggedin.php");
  $_SESSION["parentpage"] = "My Puchase History";
  $_SESSION["pagetitle"] =  "View My History";
  require_once("includes/htmlheader.php");
?>
    	<div class="container">
          <div class="row">
              <?php require_once("includes/adminnav.php") ?>

                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="accountbody">
                        <h2 class="col-xs-9"><i class="fa fa-history fa-2x" aria-hidden="true"></i> My Purchase History</h2>
                        <div class="clearfix"></div>
                        <?php 
                            $query = "SELECT * FROM Payment WHERE UserID = ".$user_logged;
                            $result = mysqli_query($connection, $query);
                            while ($pymnt = mysqli_fetch_assoc($result)){ 
                        ?>
                        <h6 class="col-md-4"><b>Invoice ID:</b></br>INV-<?php echo $pymnt["PaymentID"] ?></h6>
                        <h6 class="col-md-4"><b>Invoice Date and Time:</b></br> <?php echo $pymnt["PDATE"] ?></h6>
                        <a class="btn btn-primary addbtn" href="printbill.php?PaymentID=<?php echo $pymnt["PaymentID"] ?>"><i class="fa fa-print fa-lg" aria-hidden="true"></i></a>
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
                                $query = "SELECT * FROM Paymentdetail WHERE PaymentID =".$pymnt["PaymentID"];
                                $detailresult = mysqli_query($connection, $query);
                                while ($details = mysqli_fetch_assoc($detailresult)){ 
                            ?>
                            <tr>
                                <td><a class="colorblk" href="itemdetails.php?Pid=<?php echo $details["ProductID"] ?>"><?php echo $details["PName"] ?></a></td>
                                <td><?php echo $details["Amount"] ?></td>
                                <td><?php echo $details["Quantity"] ?>pcs</td>
                                <td><?php 
                                    $amount = ($details["Amount"]*$details["Quantity"]);
                                    $total = $total + $amount;
                                    echo $amount; ?>
                                </td>
                            </tr>                  
                            <?php } ?>
                            <tr><td colspan="4" class="billtotal"><h4>Total: Rs <?php echo $total ?></h4></td></tr>
                        </table>
                        <?php } ?>
                    </div><!--Account Body-->
                  </div>
          </div>
        </div><!--container-->
<?php require_once("includes/footer.php"); ?>