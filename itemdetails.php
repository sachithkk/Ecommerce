<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");

?>

<?php 

  //getting the current Product ID from GET
  $ProductID = $_GET["Pid"];

  //Redirects to 404 if the Product ID was not obtained
  if (!isset($ProductID)){
    redirectTo("404.php");
  }

  $pinfo = getProductNameCatID($_GET["Pid"]);
  $_SESSION["parentpage"] = getCatName($pinfo["CatID"]);
  $_SESSION["pagetitle"] = $pinfo["Name"];

  //geting all Product details form databse for current Products
  $result = getAllProduct("Product", $ProductID);
  $row = mysqli_fetch_assoc($result);
  //assign values to variable 
  $itemname = $row["Name"];
  $catID = $row["CatID"];
  $price = $row["Price"];
  $stock = $row["Stock"];
  $condition = $row["PCondition"];
  $city = $row["City"];
  $description = $row["Description"];
  $approved = $row["Approved"];
  //redirect to 404 if the Product has not yet been Approved
  if ($approved == 0){
    redirectTo("404.php");
  }
  //get actual condtion codes
  if($condition == "new"){ $condition = "New";}else if($condition == "likenew"){ $condition = "Used - Like New";}else if($condition == "usable"){ $condition = "Used - Usable";}else if($condition == "refurbished"){ $condition = "Refurbished";} else { $condition = "Good for Parts";}

  //get the name of the current Category
  $Category = getCatName($catID);
  //get user info for the current Products.
  $result = getAlluser("Users",$row["UserID"]);
  $row = mysqli_fetch_assoc($result);
  //assign values for the user variables
  $username = $row["Username"];
  $user_name = $row["Name"];
  $contactno = $row["ContactNo"];
  $email = $row["Email"];
  $userid = $row["UserID"];

   //add items in to Cart or Wishlist if user had added
  if(isset($_GET["addto"])){
    $qnty = $_GET["quantity"];
    if($_GET["addto"] == "cart"){
      $_SESSION["cart"]["$ProductID"] = $qnty;
      $redirect = "itemdetails.php?Pid=".$ProductID;
      redirectTo($redirect);
    }
    if($_GET["addto"] == "Wishlist"){
      $query = "SELECT ProductID FROM ";
      $query .= "Wishlist WHERE USERID = ".$user_logged." ";
      $query .= "AND ProductID =".$ProductID;
      $result = mysqli_query($connection, $query);
      $exist = mysqli_fetch_array($result);

      if(sizeof($exist) < 1){
        $query = "INSERT INTO Wishlist ";
        $query .= " (UserID, ProductID, AddedDate) ";
        $query .= "VALUES  (".$user_logged.", ".$ProductID.", curdate());";
        mysqli_query($connection, $query);
        $redirect = "itemdetails.php?Pid=".$ProductID;
        redirectTo($redirect);
      }
    }
  }


  //get the Images of the Product
    $query = "SELECT imageURL, imageID FROM Images WHERE ";
    $query .= "ProductID =".$ProductID.";" ;

    $result = mysqli_query($connection, $query);
    $imagecount = mysqli_num_rows($result);
    $row = mysqli_fetch_all($result);

    if(isset($row[0][0])){
    $Images[0] = $row[0][0];
    }
    if(isset($row[1][0])){
    $Images[1] = $row[1][0];
    }
    if(isset($row[2][0])){
    $Images[2] = $row[2][0];
    }
  //get the headerhtml
  require_once("includes/htmlheader.php");
  ?>
        <div class="container">
          <div class="row">
              <div class="col-md-12" id="itembody">
                <!--Items Slider-->
                <div id="ItemImages" class="carousel slide col-md-6" data-ride="carousel">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                    <?php 
                     for ($i =0; $i < $imagecount; $i++){
                        echo "<li data-target=\"#ItemImages\" data-slide-to=\"".$i."\" class=\"";
                        echo ($i==0)? "active" : " "; echo "\"></li>";
                     }
                    ?>
                  </ol>

                  <!-- Wrapper for slides -->
                  <div class="carousel-inner" role="listbox">
                    <?php
                    $i = 0;
                    foreach ($Images as $image){
                        echo  "<div class=\"item ";
                        echo ($i==0)? "active" : " "; echo "\"> <img src=\"".$image."\"></div>";
                        $i++;
                     }
                    ?>
                  </div>

                  <!-- Left and right controls -->
                  <a class="left carousel-control" href="#ItemImages" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#ItemImages" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
                <div class="col-md-6">
                  <h3 id="itemtitle"><?php echo $itemname ?></h3>
                  <h4 id="itemprice">Rs <?php echo $price ?></h4>
                  <h5 class="col-sm-6"><b>Item Condition:</b> <?php echo $condition ?></h5>
                  <h5 class="col-sm-6"><b>Category:</b> <?php echo $Category ?></h5>
                  <div class="col-md-6 col-sm-6 mt-5">
                    <form name="item_details_page" method="GET" action="itemdetails.php">
                      <input type="hidden" name="Pid" value="<?php echo $ProductID ?>">
                      <input id="itemquantity" type="number" min="1" name="quantity" value="1"/>
                      <button name="addto" id="btn_bag" type="submit" value="cart"><i class="fa fa-shopping-basket fa-2x" aria-hidden="true" ></i></button>
                      <button name="addto" id="btn_addwish" value="Wishlist" type="submit"><i class="fa fa-gift fa-2x" aria-hidden="true" ></i></button>
                    </form>
                  </div>
                  <div class="col-md-6 col-sm-6 mt-5">
                        <div id="fb_like" class="fb-share-button" data-href="<?php $_SERVER['PHP_SELF'] ?>" data-layout="button_count" data-size="large" data-mobile-iframe="false"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fthisisthelink.com%2Fedit.php%3Fpid%3D10&amp;src=sdkpreparse">Share</a></div>
                        <a id="tweet" class="twitter-share-button" href="https://twitter.com/intent/tweet" data-url="<?php $_SERVER['PHP_SELF'] ?>" data-size="large"> Tweet</a>
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-md-12" id="sellerinfo">
                    <h4 style="border-bottom:1px solid #CCCCCC">Seller Info</h4>
                    <h5><?php echo $user_name ?></h5>
                    <h5><?php echo $email ?></h5>
                    <h5><?php echo $contactno ?></h5>
                    <address>
                      <button class="visible-sm visible-xs" id="callnow" href="tel:<?php echo $contactno ?>"><i class="fa  fa-phone fa-lg" aria-hidden="true" ></i> Call Now</button>
                      <button class="visible-sm visible-xs" id="msgbtn" href="mailto:<?php echo $email ?>"><i class="fa  fa-envelope fa-lg" aria-hidden="true" ></i> Send Message</button>
                    </address>
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <?php echo $description ?> 
              </div>
          </div>
        </div><!--container-->

<?php require_once("includes/footer.php"); ?>