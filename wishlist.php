<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
  require_once("includes/loggedin.php");
  $_SESSION["parentpage"] = "My Wishlist";
  $_SESSION["pagetitle"] =  "View My Wishlist";
?>

<?php 

  //get the items from wish list;
  $result = getAlluser("Wishlist", $user_logged); 
  $items = mysqli_fetch_all($result);
  $wishitemno = count($items);

  //if an Item was set to be deleted
  if(isset($_GET["delete"])){
    $id = $_GET["delete"];
    delete($id,"ID","Wishlist");
    //give msg that item was removed
    if($wishitemno > 0){
      $_SESSION["msg"] = "<div class=\" alert alert-success\">
                          <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                          <strong>Item Removed!</strong> Your Wishlist has been updated after removing the item.
                        </div>";
    } else { //if no Item is left give different msg
      $_SESSION["msg"] = "<div class=\" alert alert-warning\">
                          <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                          <strong>Empty Wishlist!</strong> Unfortunately you have removed all the Items from your Wishlist.
                        </div>";
    }
    //reloading page to update the Wishlist
    redirectTo("Wishlist.php");
  }

  //if an Item was set to add to cart
  if(isset($_GET["addtocart"])){
    $Pid = $_GET["addtocart"];
    $id = $_GET["ID"];
     $_SESSION["cart"]["$Pid"] = 1;
     delete($id,"ID","Wishlist");
     $_SESSION["msg"] = "<div class=\" alert alert-success\">
                          <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                          <strong>Success!</strong> Your Item was changed to the Shopping Bag.
                        </div>";
    //reloading page to update the Wishlist
    redirectTo("Wishlist.php");
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
                        <h2 class="col-xs-9"><i class="fa fa-gift fa-2x" aria-hidden="true"></i> My Wislist</h2>
                        <div class="clearfix"></div>
                        <?php 
                          if (isset($msg)){
                              echo $msg;
                          } ?>
                        <div class="clearfix"></div>
                        <?php if($wishitemno == 0){ echo 
                        "<div class=\"col-md-12 noitemmsg\">
                            <i class=\"fa fa-gift fa-5x\" aria-hidden=\"true\"></i>
                            <br/>
                            <h2>Sorry! You have no items in your Wishlist!</h2>
                        </div>"; } else { echo
                        
                        "<table class=\"table table-hover\">
                          <tr>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Added on</th>
                            <th></th>
                          </tr>";
                            $result = getAlluser("Wishlist", $user_logged); 
                            while($row = mysqli_fetch_assoc($result)){
                              $getProduct = getAllProduct("Product", $row["ProductID"]);
                              $Product = mysqli_fetch_assoc($getProduct);
                              $delete = "Wishlist.php?delete=".$row["ID"];
                              $addtocart = "Wishlist.php?addtocart=".$row["ProductID"]."&ID=".$row["ID"];
                              echo "<tr>
                                    <td><a class=\"colorblk\"href=\"itemdetails.php?Pid=".$Product["ProductID"]."\">".$Product["Name"]."</a></td>
                                    <td>".$Product["Price"]."</td>
                                    <td>".$row["AddedDate"]."</td>
                                    <td><a class=\"btn btn-success btn-xs\" href=\"".$addtocart."\"><i class=\"fa fa-shopping-basket fa-lg\" aria-hidden=\"true\"></i></a>
                                      <a class=\"btn btn-danger btn-xs\" href=\"".$delete."\"><i class=\"fa fa-times fa-lg\" aria-hidden=\"true\"></i></a></td>";
                          }
                          echo "</table>";
                        } ?>
                    </div><!--Account Body-->
                  </div>
          </div>
        </div><!--container-->
<?php require_once("includes/footer.php"); ?>