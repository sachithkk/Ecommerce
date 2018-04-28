<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
  $_SESSION["parentpage"] = null;
  $_SESSION["pagetitle"] =  null;
  require_once("includes/htmlheader.php");
?>

     <div class="container" style="background-color: transparent; ">
          <div class="row" >
            <div class="col-sm-12 col-md-8 mt-10 nopadding">
              <div id="homeSlider" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                  <li data-target="#homeSlider" data-slide-to="0" class="active"></li>
                  <li data-target="#homeSlider" data-slide-to="1"></li>
                  <li data-target="#homeSlider" data-slide-to="2"></li>
                  <li data-target="#homeSlider" data-slide-to="3"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                  <div class="item active">
                    <img src="images/homepagebanner1.jpg" alt="img1">
					
                  </div>

                  <div class="item">
                    <img src="images/homepagebanner1.jpg" alt="img2">
                  </div>

                  <div class="item">
                    <img src="images/homepagebanner1.jpg" alt="img3">
                  </div>

                  <div class="item">
                    <img src="images/homepagebanner1.jpg" alt="img4">
                  </div>
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#homeSlider" role="button" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#homeSlider" role="button" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
            <div class="col-sm-4 col-md-4 mt-10 sideimg visible-md visible-lg">
              <img src="images/itemimage.jpg">
            </div>
            <div class="col-xs-12 nopadding">
              <div class="searchbox">
                <form method="GET" action="listing.php">
                  <input type="text" name="search" placeholder="Search for Your Favourite Items" />
                  <select name="Category[]">
                      <option value="All">All Categories</option>
                    <?php 
                      $result = getAll("Category");
                      while($row = mysqli_fetch_assoc($result)){
                        echo "<option value=\"".$row["CatID"]."\">".$row["Name"]."</option>";
                      }
                    ?>
                  </select>
                  <button type="submit" id="btn_search"><i class="fa fa-search fa-2x"></i></button>
                </form>
              </div><!-- searchbox -->
            </div>
            <div class="col-xs-12 nopadding">
            <div class="heading">
                <h4>Recently Added Items</h4>
              </div>
              <div id="homeSlider2" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
                  <div class="item active">
                    <?php 
                      $query = "SELECT ProductID, Name, Price FROM Product WHERE Approved = 1 ORDER BY PostedDate DESC LIMIT 4";
                      $result = mysqli_query($connection, $query);
                      while($row = mysqli_fetch_assoc($result)){
                        $image = getImage($row["ProductID"],1);
                    ?>
                    <div class="col-xs-6 col-md-3">
                      <a href="itemdetails.php?Pid=<?php echo $row["ProductID"]?>" style="text-decoration:none; color:#333;">
                      <img class="col-md-12 nopadding" src="<?php echo $image[0][0]; ?>" height="100px" width="100%"/>
                      <div class="col-md-12 info">
                        <h4><?php echo $row["Name"] ?></h4>
                        <h4 class="price"><?php echo $row["Price"] ?></h4>                  
                      </div>
                      </a>
                    </div> <!-- thumb -->
                    <?php } ?>
                  </div><!-- item -->

                  <div class="item">
                    <?php 
                      $query = "SELECT ProductID, Name, Price FROM Product  WHERE Approved = 1 ORDER BY PostedDate DESC LIMIT 4 OFFSET 4";
                      $result = mysqli_query($connection, $query);
                      while($row = mysqli_fetch_assoc($result)){
                        $image = getImage($row["ProductID"],1);
                    ?>
                    <div class="col-xs-6 col-md-3">
                      <a href="itemdetails.php?Pid=<?php echo $row["ProductID"]?>" style="text-decoration:none; color:#333;">
                      <img class="col-md-12 nopadding" src="<?php echo $image[0][0]; ?>" height="100px" width="100%"/>
                      <div class="col-md-12 info">
                        <h4><?php echo $row["Name"] ?></h4>
                        <h4 class="price"><?php echo $row["Price"] ?></h4>                  
                      </div>
                      </a>
                    </div> <!-- thumb -->
                    <?php } ?>
                  </div><!-- item -->
              </div>
            </div>

            
            <div class="col-xs-12 nopadding homemod">
              <div class="heading">
                <h4>Random Items</h4>
              </div>
              <?php 
                      $query = "SELECT ProductID FROM Product  WHERE Approved = 1  ORDER BY RAND() DESC LIMIT 12 ";
                      $result = mysqli_query($connection, $query);
                      while($row = mysqli_fetch_assoc($result)){
                        $image = getImage($row["ProductID"],1);
              ?>
              <div class="col-xs-4 col-sm-4 col-md-2 nopadding">
                <a href="itemdetails.php?Pid=<?php echo $row["ProductID"]?>">
                <img src="<?php echo $image[0][0] ?>" height= "200px" width="100%" style="padding:5px;">
                </a>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        </div><!--container-->
<?php require_once("includes/footer.php"); ?>