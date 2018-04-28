<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
  require_once("includes/loggedin.php");
  $_SESSION["parentpage"] = "My Items";
  $_SESSION["pagetitle"] =  "Add New Item";
?>
  
<?php /*FORM VALIDATION*/
    $formError = "";
    $itemnameError = "";
    $descriptionError = "";
    $priceError = "";
    $stockError = "";
    $conditionError = "";
    $cityError = "";
    $itemname = "";
    $description = "";
    $price = "";
    $stock = "";
    $condition = "";
    $city = "";
    $image1 = "";
    $image2 = "";
    $image3 = "";

  if(isset($_POST["submit"])){
    $itemname = $_POST["itemname"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $condition = $_POST["condition"];
    $city = $_POST["city"];
    $categ = $_POST["categ"];

    if(checkEmpty("itemname")){ $itemnameError = "inputError"; $formError .= "<div class=\"alert alert-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Field Empty!</strong> Please fill int the Name Field.</div>"; }
    if(checkEmpty("description")){ $descriptionError = "inputError"; $formError .= "<div class=\"alert alert-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Field Empty!</strong> Please fill int the Description Field.</div>";}
    if(checkEmpty("price")){ $priceError = "inputError";$formError .= "<div class=\"alert alert-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Field Empty!</strong> Please fill int the Price Field.</div>";} else if($_POST["price"]<1){ $priceError = "inputError"; $formError .= "<div class=\"alert alert-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Invalid Input!</strong> The Price must be above 1.</div>"; }
    if(checkEmpty("stock")){ $stockError = "inputError";$formError .= "<div class=\"alert alert-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Field Empty!</strong> Please fill int the Stock Field.</div>";}else if($_POST["stock"]<1){ $stockError = "inputError"; $formError .= "<div class=\"alert alert-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Invalid Input!</strong> The Stock must be above 1.</div>"; }
    if(checkEmpty("city")){ $cityError = "inputError";$formError .= "<div class=\"alert alert-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Field Empty!</strong> Please fill int the City Field.</div>";}
    $conOptions = array("new", "likenew", "usable", "refurbished", "parts");
    if(!in_array($_POST["condition"], $conOptions)){ $conditionError = "inputError"; $formError .= "<div class=\"alert alert-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Invalid Input!</strong> The Conditon input is not Valid.</div>"; }
    if((empty($_FILES["image1"]["name"])) && (empty($_FILES["image2"]["name"])) && (empty($_FILES["image3"]["name"])) ){ 
      $formError .= "<div class=\"alert alert-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>No Image Set!</strong> Please set atleast one image for the Product.</div>"; }
  } else {
    $_POST["condition"] = "new"; 
    $_POST["categ"] = "";
  }

  if ((isset($_POST["submit"])) && ($formError == "")){

    if(!empty($_FILES["image1"]["name"])){
      $image1URL = uploadFile("image1");
    }
    if(!empty($_FILES["image2"]["name"])){
      $image2URL = uploadFile("image2");
    }
    if(!empty($_FILES["image3"]["name"])){
      $image3URL = uploadFile("image3");
    }
  }

   if ((isset($_POST["submit"])) && ($formError == "")){

    $itemname =  mysqli_real_escape_string($connection, $itemname);
    $description = mysqli_real_escape_string($connection, $description);
    $price = mysqli_real_escape_string($connection, $price);
    $stock = mysqli_real_escape_string($connection, $stock);
    $condition =  mysqli_real_escape_string($connection, $condition);
    $city = mysqli_real_escape_string($connection, $city);
    $categ = mysqli_real_escape_string($connection, $categ);
    $image1 = mysqli_real_escape_string($connection, $image1);
    $image2 = mysqli_real_escape_string($connection, $image2);
    $image3 = mysqli_real_escape_string($connection, $image3);

    $query = "INSERT INTO Product ";
    $query .= "(UserID, CatID, Name, Description, Price, Stock, PCondition, City, PostedDate, Approved) ";
    $query .= "VALUES (".$_SESSION["user_logged"].", '".$categ."', '".$itemname."', '".$description."', ".$price.", ".$stock.", '".$condition."', '".$city."', curdate(), FALSE); ";

    mysqli_query($connection, $query);

    $query = "SELECT ProductID FROM Product WHERE ";
    $query .= "UserID = ".$user_logged." AND CatID = '".$categ."' AND Name = '".$itemname."' AND Description = '".$description."' AND Price = ".$price." AND Stock = ".$stock." AND PCondition = '".$condition."' AND City = '".$city."'";

    $result = mysqli_query($connection, $query);

    $row = mysqli_fetch_assoc($result);

    $query = "INSERT INTO Images ";
    $query .= "(ProductID, ImageURL) VALUES  ";
    if(!empty($_FILES["image1"]["name"])){
       $query .= "(".$row["ProductID"].", '".$image1URL."') ";
    }
    if(!empty($_FILES["image2"]["name"])){
        $query .= ",(".$row["ProductID"].", '".$image2URL."') ";
    }
    if(!empty($_FILES["image3"]["name"])){
        $query .= ",(".$row["ProductID"].", '".$image3URL."'); ";
    }

    mysqli_query($connection, $query);

    $_SESSION["msg"] = "<div class=\" alert alert-success\">
                        <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                        <strong>Success!</strong> Your Item has been Added and is waiting for Approval.
                      </div>";
    redirectTo("viewitems.php");
  }

  $Category = getAll("Category");
  require_once("includes/htmlheader.php");
?>
        <div class="container">
          <div class="row">
              <?php require_once("includes/adminnav.php") ?>

                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="accountbody">
                        <h2><i class="fa fa-cube fa-2x" aria-hidden="true"></i> Add New Item</h2>
                        <?php echo $formError ?>
                        <form name="additem" method="POST" action="additem.php" enctype="multipart/form-data">
                          <div class="form-group">
                            <label>Name</label> 
                            <input name="itemname" type="text" value="<?php echo $itemname; ?>" class="form-control" <?php echo $itemnameError?>>
                            <br/>
                            <label>Category</label>
                            <select name="categ" class="form-control <?php echo $categError ?>">
                              <?php while($row = mysqli_fetch_assoc($Category)){
                                  echo "<option value=\"".$row["CatID"]."\" "; 
                                  selected("categ", $row["CatID"]); 
                                  echo " >".$row["Name"]."</option>";
                              }
                               ?>   
                            </select>
                                  <br/>
                            <label>Decription</label>
                            <textarea  class="desc" rows="15" name="description" class="form-control <?php echo $descriptionError?>"><?php echo $description ?></textarea>
                            <br/>
                            <div class="col-md-4">
                              <label>Price</label>
                              <input type="number" name="price" value="<?php echo $price ?>" min="1" class="form-control <?php echo $priceError?>">
                              <br/>
                            </div>
                            <div class="col-md-4">
                              <label>Current Stock</label>
                              <input type="number" name="stock" value="<?php echo $stock ?>" min="1" class="form-control <?php echo $stockError?>">
                              <br/>
                              </div>
                              <div class="col-md-4">
                                <label>Conditon</label>
                                <select name="condition" class="form-control <?php echo $conditionError ?>">
                                  <option value="new" <?php selected("condition", "new")?> >New</option>
                                  <option value="likenew" <?php selected("condition", "likenew")?> >Used - Like New</option>
                                  <option value="usable" <?php selected("condition", "usable")?> >Used - Usable</option>
                                  <option value="refurbished" <?php selected("condition", "refurbished")?> >Refurbished</option>
                                  <option value="parts" <?php selected("condition", "parts")?> >Good for Parts</option>
                                 </select>
                                  <br/>
                              </div>
                              <div class="col-md-12">
                                <label>City</label>
                                <input type="text" name="city" value="<?php echo $city ?>" class="form-control <?php echo $cityError?>">
                                <br/>
                              </div>
                              <div class="col-md-4">
                                  <label>Image 1</label>
                                  <input type="file" name="image1" class="form-control">
                                  <br/>
                              </div>
                              <div class="col-md-4">
                                  <label>Image 2</label>
                                  <input type="file" name="image2" class="form-control">
                                  <br/>
                              </div>
                              <div class="col-md-4">
                                  <label>Image 3</label>
                                  <input type="file" name="image3" class="form-control">
                                  <br/>
                              </div>
                              <button name="submit" type="submit" value="submit" class="btn btn-primary">Apend Item for Approval</button>
                            <br/>
                          </div>
                        </form>
                    </div><!--Account Body-->
                  </div>
              
          </div>
        </div><!--container-->

<?php require_once("includes/footer.php"); ?>