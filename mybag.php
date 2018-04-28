<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
  require_once("includes/loggedin.php");
  $_SESSION["parentpage"] = "My Shopping Bag";
  $_SESSION["pagetitle"] =  "View My Bag";
?>

<?php 
  //if an Item was set to be deleted
  if(isset($_GET["delete"])){
    $id = $_GET["delete"];
    unset($_SESSION["cart"]["$id"]);
    $itemno = count($_SESSION["cart"]);
    echo $itemno;
    //give msg that item was removed
    if($itemno > 0){
      $_SESSION["msg"] = "<div class=\" alert alert-success\">
                          <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                          <strong>Item Removed!</strong> Your Shopping Bag has been updated after removing the item.
                        </div>";
    } else { //if no Item is left give different msg
      $_SESSION["msg"] = "<div class=\" alert alert-warning\">
                          <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                          <strong>Empty Shopping Cart!</strong> Unfortunately you have removed all the Items from Shopping Cart.
                        </div>";
    }
    //reloading page to update the bag
    redirectTo("mybag.php");
  }

  //if the quantity was to be changed
  if((isset($_POST["change"])) && (isset($_POST["Pid"]))){
    if ((is_numeric($_POST["change"])) && ($_POST["change"] > 0)){
      $_SESSION["cart"][$_POST["Pid"]] = $_POST["change"];
    } else{
      $_SESSION["msg"] = "<div class=\" alert alert-warning\">
                          <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                          <strong>Invalid Quantity!</strong> The Shopping Cart Could not be Updated.
                        </div>";
    }
  }

  //check and get the msg passed from previous page
  if (isset($_SESSION["msg"])){
    $msg = $_SESSION["msg"];
    $_SESSION["msg"] = null;
  }
  require_once("includes/htmlheader.php");
?>

        <div class="container">
          <div class="row">
              <?php require_once("includes/adminnav.php") ?>

                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="accountbody">
                        <h2 class="col-xs-9"><i class="fa fa-shopping-basket fa-2x" aria-hidden="true"></i> My Shopping Bag</h2>
                        <a class="btn btn-primary addbtn" href="bill.php?PaymentStatus=ok"><i class="fa  fa-credit-card fa-lg" aria-hidden="true"></i> Check Out</a>
                        <div class="clearfix"></div>
                        <?php 
                          if (isset($msg)){
                              echo $msg;
                          } ?>
                        <div class="clearfix"></div>
                        <?php if($itemno == 0){ echo 
                        "<div class=\"col-md-12 noitemmsg\">
                            <i class=\"fa fa-shopping-basket fa-5x\" aria-hidden=\"true\"></i>
                            <br/>
                            <h2>Sorry! You have no items in your Shopping Bag!</h2>
                        </div>"; } else { echo
                        
                        "<table class=\"table table-hover cart\">
                          <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th></th>
                          </tr>";
                          $total = 0;
                          foreach ($_SESSION["cart"] as $key => $value) {
                            $result = getAllProduct("Product", $key);
                            $Product = mysqli_fetch_assoc($result);
                            $delete = "mybag.php?delete=".$key;
                            echo "<tr>
                                    <td><a class=\"colorblk\"href=\"itemdetails.php?Pid=".$Product["ProductID"]."\">".$Product["Name"]."</a></td>
                                    <td>
                                    <form method=\"POST\" action=\"mybag.php\">
                                    <input type=\"number\" name=\"change\"value=\"".$value."\"/>
                                    <input type=\"hidden\" name=\"Pid\" value=\"".$Product["ProductID"]."\"/>
                                    <button class=\"btn btn-info btn-xs\"type=\"submit\"/><i class=\"fa fa-refresh\" aria-hidden=\"true\"></i></button>
                                    </form>
                                    </td>
                                    <td>".$Product["Price"]."</td>
                                    <td>".($Product["Price"]*$value)."</td>
                                    <td><a class=\"btn btn-danger btn-xs\" href=\"".$delete."\"><i class=\"fa fa-times fa-lg\" aria-hidden=\"true\"></i></a></td>";
                                    $total = $total + ($Product["Price"]*$value);
                          }
                          echo "<tr><td colspan= \"4\" class=\"bagtotal\"><h4>Total: Rs.".$total."</h4></td></tr>";
                          echo "</table>";
                        } ?>
                    </div><!--Account Body-->
                  </div>
          </div>
        </div><!--container-->

<?php require_once("includes/footer.php"); ?>