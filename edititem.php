<?php 

  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
  require_once("includes/loggedin.php");
  $_SESSION["parentpage"] = "My Items";
  $_SESSION["pagetitle"] =  "Modify Item";

?>
  
<?php
    //get the Product ID from GET
    $ProductID = $_GET["Pid"];

    //Redirects to 404 if the Product ID was not obtained
      if (!isset($ProductID)){
        redirectTo("404.php");
      }
    //fetch all Product details from the Database
    $result = getAllProduct("Product", $ProductID);
    $row = mysqli_fetch_assoc($result);

    $formError = "";
    $itemnameError = "";
    $descriptionError = "";
    $priceError = "";
    $stockError = "";
    $conditionError = "";
    $cityError = "";
    $itemname = $row["Name"];
    $description = $row["Description"];
    $price = $row["Price"];
    $stock = $row["Stock"];
    $condition = $row["PCondition"];
    $city = $row["City"];
    $categ = $row["CatID"];

    //get the Images for the Product
    $query = "SELECT imageURL, imageID FROM Images WHERE ";
    $query .= "ProductID =".$ProductID.";" ;

    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_all($result);

    if(isset($row[0][0])){
    $image1 = $row[0][0];
    $image1ID = $row[0][1];
    }
    if(isset($row[1][0])){
    $image2 = $row[1][0];
    $image2ID = $row[1][1];
    }
    if(isset($row[2][0])){
    $image3 = $row[2][0];
    $image3ID = $row[2][1];
    }

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
  } else {
    $_POST["categ"] = $categ;
    $_POST["condition"] = $condition;
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

   if ((isset($_POST["submit"])) && ($formError == "")) {

    $itemname = mysqli_real_escape_string($connection, $itemname);
    $description = mysqli_real_escape_string($connection, $description);
    $price = mysqli_real_escape_string($connection, $price);
    $stock = mysqli_real_escape_string($connection, $stock);
    $condition = mysqli_real_escape_string($connection, $condition);
    $city = mysqli_real_escape_string($connection, $city);
    $categ = mysqli_real_escape_string($connection, $categ);
    if(isset($image1)){
      $image1 = mysqli_real_escape_string($connection, $image1);
    }
    if(isset($image2)){
      $image2 = mysqli_real_escape_string($connection, $image2);
    }
    if(isset($image3)){
      $image3 = mysqli_real_escape_string($connection, $image3);
    }

    $query = "UPDATE Product SET ";
    $query .= "CatID = '".$categ."', Name = '".$itemname."', Description = '".$description."', Price = ".$price.", Stock = ".$stock.", PCondition = '".$condition."', City = '".$city."', Approved = False ";
    $query .= "WHERE ProductID = ".$ProductID;

    mysqli_query($connection, $query);

    if((empty($_FILES["image1"]["name"])) && (empty($_FILES["image2"]["name"])) && (empty($_FILES["image3"]["name"])) ){ 
      //do nothing 
    } else {
        
        if( (!empty($_FILES["image1"]["name"])) && (isset($image1ID)) ){
           $query = "UPDATE Images SET ";
           $query .= "ImageURL = '".$image1URL."' ";
           $query .= "WHERE ImageID = ".$image1ID;
           mysqli_query($connection, $query);
        } else if (!empty($_FILES["image1"]["name"])) {
          $query = "INSERT INTO Images ";
          $query .= "(ProductID, ImageURL) VALUES  ";
          $query .= "(".$ProductID.", '".$image1URL."') ";
          mysqli_query($connection, $query);
        }

        if( (!empty($_FILES["image2"]["name"])) && (isset($image2ID)) ){
           $query = "UPDATE Images SET ";
           $query .= "ImageURL = '".$image2URL."' ";
           $query .= "WHERE ImageID = ".$image2ID;
           mysqli_query($connection, $query);
        } else if (!empty($_FILES["image2"]["name"])) {
          $query = "INSERT INTO Images ";
          $query .= "(ProductID, ImageURL) VALUES  ";
          $query .= "(".$ProductID.", '".$image2URL."') ";
          mysqli_query($connection, $query);
        }
        if( (!empty($_FILES["image3"]["name"])) && (isset($image3ID)) ){
           $query = "UPDATE Images SET ";
           $query .= "ImageURL = '".$image3URL."' ";
           $query .= "WHERE ImageID = ".$image3ID;
           mysqli_query($connection, $query);
        } else if (!empty($_FILES["image3"]["name"])) {
          $query = "INSERT INTO Images ";
          $query .= "(ProductID, ImageURL) VALUES  ";
          $query .= "(".$ProductID.", '".$image3URL."') "; 
          mysqli_query($connection, $query);
        }    
  }
  $_SESSION["msg"] = "<div class=\"clearfix\"></div><div class=\"alert alert-success\">
                        <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                        <strong>Success!</strong> Your Item has been modified and is waiting for Approval.
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
                        <h2><i class="fa fa-cube fa-2x" aria-hidden="true"></i> Modify Item</h2>
                        <?php echo $formError ?>
                        <form name="edititem" method="POST" action="edititem.php?Pid=<?php echo $ProductID ?>" enctype="multipart/form-data">
                          <div class="form-group">
                            <label>Name</label> 
                            <input name="itemname" type="text" value="<?php echo $itemname; ?>" class="form-control <?php echo $itemnameError ?>" >
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
                            <textarea class="desc" rows="15" name="description" class="form-control <?php echo $descriptionError?>"><?php echo $description ?></textarea>
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
                                  <?php if(isset($image1)){
                                    echo "<img class=\"peditimage\" src=\"".$image1."\"/>";
                                  } ?>
                                  <label>Image 1</label>
                                  <input type="file" name="image1" class="form-control">
                                  <br/>
                              </div>
                              <div class="col-md-4">
                                  <?php if(isset($image2)){
                                    echo "<img class=\"peditimage\" src=\"".$image2."\"/>";
                                  } ?>
                                  <label>Image 2</label>
                                  <input type="file" name="image2" class="form-control">
                                  <br/>
                              </div>
                              <div class="col-md-4">
                                  <?php if(isset($image3)){
                                    echo "<img class=\"peditimage\" src=\"".$image3."\"/>";
                                  } ?>
                                  <label>Image 3</label>
                                  <input type="file" name="image3" class="form-control">
                                  <br/>
                              </div>
                              <div class="col-md-12">
                                <button name="submit" type="submit" value="submit" class="btn btn-primary">Apend Update for Approval</button>
                                <br/>
                              </div>
                            
                          </div>
                        </form>
                    </div><!--Account Body-->
                  </div>
          </div>
        </div><!--container-->

<?php require_once("includes/footer.php"); ?>