<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
  $_SESSION["parentpage"] = null;
  $_SESSION["pagetitle"] =  "Search Results";
?>
<?php 
  //starting the query 
  $listquery = "SELECT P.Name AS PName, P.ProductID, P.Price, P.PCondition, P.PostedDate, P.City, U.Name AS UName, C.Name AS CName FROM Product P, Users U, Category C  WHERE P.UserID = U.UserID AND P.CatID = C.CatID AND ";

  //if price range was set
  if(isset($_GET["price"])){
    urldecode($_GET["price"]);
    $realprice  =  mysqli_real_escape_string($connection, $_GET["price"]);
    $comma = strpos($realprice, ",");
    $min = substr($realprice, 0, $comma);
    $max = substr($realprice, $comma+1);
    $listquery .=  "(P.Price BETWEEN ".$min." AND ".$max." ) AND ";
  }
  
  //getting values for Category
  if(isset($_GET["Category"])){
    $listquery .= "( ";
    $num = count($_GET["Category"]);
    for ($i= 0; $i <= $num-2; $i++){
      $categories = mysqli_real_escape_string($connection, $_GET["Category"][$i]);
      $listquery .= "P.CatID = '".$categories."'";
      $listquery .= " OR ";
    }
    $categories = mysqli_real_escape_string($connection, $_GET["Category"][$num-1]);
    $listquery .= "P.CatID = '".$categories."'";
    $listquery .= " ) AND ";
  }

  //if search was set
  if (isset($_GET["search"])){
    $realsearch = mysqli_real_escape_string($connection, $_GET["search"]);
    $listquery .= "( P.Name Like '%".$realsearch."%' OR ";
    $listquery .= "P.Description Like '%".$realsearch."%' ) AND ";
  }

  //if condition was set
  if(isset($_GET["condition"])){
        $listquery .= "( ";
    $num = count($_GET["condition"]);
    for ($i= 0; $i <= $num-2; $i++){
      $realcond = mysqli_real_escape_string($connection, $_GET["condition"][$i]);
      $listquery .= "P.PCondition = '".$realcond."'";
      $listquery .= " OR ";
    }
    $realcond = mysqli_real_escape_string($connection, $_GET["condition"][$num-1]);
    $listquery .= "P.PCondition = '".$realcond."'";
    $listquery .= " ) AND ";
  }

  //to include as after the last AND SQL 
    $listquery .= "P.Approved = 1 ";

  //get sort by value
  if(isset($_GET["sortby"])){
    $realsort = mysqli_real_escape_string($connection, $_GET["sortby"]);
    $listquery .= " ORDER BY ".$realsort." ";
    if(isset($_GET["orderby"])){
      $realorder = mysqli_real_escape_string($connection, $_GET["orderby"]);
      $listquery .= $realorder." ;";
    }
  }

  //run the query 
  $listresult = mysqli_query($connection, $listquery);
  $maxprice = 0;
  $minprice = 0;
  while ( $row = mysqli_fetch_assoc($listresult)){
    //get maxprice
    if($maxprice < $row["Price"]){ $maxprice = $row["Price"];}
    //get minprice
    if($minprice > $row["Price"]){ $minprice = $row["Price"];}
  }
  
  //redirect to 404 if SQL statement was unsuccessful
  if(!$listresult){ redirectTo("404.php");}
require_once("includes/htmlheader.php");
?>

        <div class="container" style="background-color: transparent;  ">
          <div class="row" >
              <div class="col-sm-12 col-md-3 nopadding" style="background-color: white; margin-top:10px;">
                <div class="filter_form">
                  <form name="filter" method="GET" action="listing.php" class="form-group">
                      <h3>Filter Your Results</h3>

                      <button type="button" class="heading-panel" data-toggle="collapse" data-target="#search" >Search</button>
                      <div id="search" class="collapse in">
                        <label>Search</label>
                        <input class="form-control" type="text" name="search" value="<?php if(isset($_GET["search"])){ echo $_GET["search"];} ?>"/>                
                      </div>  

                      <button type="button" class="heading-panel" data-toggle="collapse" data-target="#price" >Price</button>
                      <div id="price" class="collapse in">
                        <b>Rs.<?php echo $minprice; ?></b> <input
                            class="form-control"
                            type="text"
                            name="price"
                            data-slider-id="slider-price"
                            id = "price-slider"
                            data-provide="slider"
                            data-slider-min="<?php echo $minprice; ?>"
                            data-slider-max="<?php echo $maxprice; ?>"
                            data-slider-step="5"
                            data-slider-value="[<?php echo $minprice.",".$maxprice ?>]"
                            data-slider-tooltip="always"
                            data-slider-tooltip-split = "true"
                        ><b>Rs.<?php echo $maxprice; ?></b>                   
                      </div>  
                      
                      <button type="button" class="heading-panel" data-toggle="collapse" data-target="#categories" >Categories</button>
                       <div id="categories" class="collapse in">
                          <?php
                            $catresult = getAll("Category");
                            while ($catrow = mysqli_fetch_assoc($catresult)){
                              echo "<div class=\"checkbox\">
                                      <label>
                                        <input type=\"checkbox\" name=\"Category[]\" 
                                        value=\"".$catrow["CatID"]."\" ".
                                        checked("Category",$catrow["CatID"]).">".$catrow["Name"].
                                     "<label>
                                     <a href=\"listing.php?Category[]=".$catrow["CatID"]."\">
                                        <span>(".countnumApproved("CatID",$catrow["CatID"]).")
                                        </span>
                                     </a>
                                    </div>";
                            }
                          ?>
                      </div>

                      <button type="button" class="heading-panel" data-toggle="collapse" data-target="#condition" >Condition</button>
                       <div id="condition" class="collapse in">
                          <div class="checkbox"><label><input type="checkbox" value="new" name="condition[]" <?php echo checked("condition","new"); ?> >Brand New</label>
                            <a href="listing.php?condition[]=new">
                              <span>(<?php echo countnum("Product","PCondition","new"); ?>)</span>
                            </a>
                          </div>
                          <div class="checkbox"><label><input type="checkbox" value="usable" name="condition[]" <?php echo checked("condition","usable"); ?>>Used - Usable</label>
                          <a href="listing.php?condition[]=usable">
                              <span>(<?php echo countnum("Product","PCondition","usable"); ?>)</span>
                            </a>
                          </div>
                          <div class="checkbox"><label><input type="checkbox" value="refurbished" name="condition[]" <?php echo checked("condition","refurbished"); ?>>Refurbished</label>
                            <a href="listing.php?condition[]=refurbished">
                              <span>(<?php echo countnum("Product","PCondition","refurbished"); ?>)</span>
                            </a>
                          </div>
                          <div class="checkbox"><label><input type="checkbox" value="parts" name="condition[]" <?php echo checked("condition","parts"); ?>>Good for Parts</label>
                            <a href="listing.php?condition[]=parts">
                              <span>(<?php echo countnum("Product","PCondition","parts"); ?>)</span>
                            </a>
                          </div>
                      </div>

                      <button type="button" class="heading-panel" data-toggle="collapse" data-target="#sort" >Sort By</button>
                       <div id="sort" class="collapse in">
                          <label>Sort By:</label>
                          <select class="form-control" name="sortby">
                            <option value="price" <?php echo selectedGET("sortby","price") ?>>Price</option>
                            <option value="UName" <?php echo selectedGET("sortby","seller") ?>>Seller</option>
                            <option value="PostedDate" <?php echo selectedGET("sortby","PostedDate") ?>>Added Date</option>
                          </select>
                          <br/>
                          <label>Order in:</label>
                          <select class="form-control" name="orderby">
                            <option value="ASC" <?php echo selectedGET("orderby","ASC") ?>>Ascending</option>
                            <option value="DESC" <?php echo selectedGET("orderby","DESC") ?>>Descending</option>
                          </select>
                      </div>

                      <button class="form-control btn-primary" id="filter" type="submit" name="submit" value="submit">Filter</button>
                  </form>
                </div><!--filterform-->
              </div>
              <div class="col-sm-12 col-md-9 nopadding">
              <?php 
              $listresult = mysqli_query($connection, $listquery);
              while ( $row = mysqli_fetch_assoc($listresult)){
                $image = getImage($row["ProductID"], 2);
                ?>
              <!--Item-->
                <div class="col-xs-12 listing">
                <a href="itemdetails.php?Pid=<?php echo $row["ProductID"]?>">
                  <div class="col-xs-4 nopadding">
                    <?php if(count($image) > 1){ ?>
                    <div class="overlay"><img src="<?php echo $image[1][0]; ?>" height="200px" width="100%"></div> <?php } ?>
                    <img src="<?php echo $image[0][0]; ?>" height="200px" width="100%">
                  </div>
                  <div class="col-xs-8">
                    <h3><?php echo $row["PName"]; ?></h3>
                    <h4 id="itemprice">Rs <?php echo $row["Price"]; ?></h4>
                    <h6 class="col-xs-3"><b>Category:</b><br/> <?php echo $row["CName"]; ?></h6>
                    <h6 class="col-xs-3"><b>Condition:</b><br/> <?php echo $row["PCondition"]; ?></h6>
                    <h6 class="col-xs-3"><b>Seller:</b><br/> <?php echo $row["UName"]; ?></h6>
                    <h6 class="col-xs-3"><b>Posted Date:</b><br/> <?php echo $row["PostedDate"]; ?></h6>
                  </div>
                  </a>
                </div>
                <?php } ?>
              </div>
          </div>
        </div><!--container-->
<?php require_once("includes/footer.php"); ?>