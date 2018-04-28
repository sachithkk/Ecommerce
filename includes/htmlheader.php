<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KoolBabies.lk | <?php if(isset($_SESSION["pagetitle"])){ echo $_SESSION["pagetitle"];} ?> </title>

    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>
      tinymce.init({ 
        selector:'.desc',
        plugins: "advlist autolink link image imagetools lists media table code",
        imagetools_toolbar: "rotateleft rotateright | flipv fliph | editimage imageoptions",
         table_toolbar: "tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
        image_caption: true });</script>
    <!--Font Awesome-->
    <link rel="stylesheet" href="fonts/font-awesome-4.6.3/css/font-awesome.min.css">

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
  <body>
    <?php require_once("includes/facebookSDK.php"); ?>
      <header>
        <nav class="navbar navbar-default navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span> 
            </button>
              <a class="navbar-brand" href="index.php">KoolBabies.lk</a>
            </div>
            <div class="navbar-collapse collapse col-md-11 col-sm-11" id="myNavbar">
            <ul class="nav navbar-nav">
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Categories
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <?php 
                    $query = "SELECT * FROM Category";
                    $result = mysqli_query($connection, $query);

                    if (isset($result)) {
                      while($row = mysqli_fetch_assoc($result)){
                        echo "<li><a href=\"listing.php?Category[]=".$row['CatID']."\">".$row['Name']."</a></li>";
                      }
                    }
                  ?>
                </ul>
              </li>
              <li class="<?php addActive("About Us") ?>"><a href="aboutus.php">About Us</a></li>
              <li class="<?php addActive("Contact Us") ?>"><a href="contactus.php">Contact Us</a></li> 
            </ul>
            </div>
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown"><a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-shopping-basket fa-2x " aria-hidden="true"></i>
              <?php if($itemno > 0){ echo "<div class=\"number\">".$itemno."</div>";} ?>
              </a>
                  <?php if($itemno > 0){
                  echo "<ul class=\"dropdown-menu\" id=\"cartseek\">";
                     foreach ($_SESSION["cart"] as $key => $value){
                      $result = getAllProduct("Product",$key);
                      $Product = mysqli_fetch_assoc($result);
                      echo "<li>".$value." <b>X</b> ".$Product["Name"]."</li>";
                  } echo "<a href=\"mybag.php\"><button class=\" checkoutbtn btn-primary btn\"> View Bag</button></a></ul>";}?>
              </li>
              <?php if (!isset($_SESSION["user_logged"])){ ?>
              <li><a href="login.php"><i class="fa fa-user fa-2x" aria-hidden="true"></i></a></li>
              <?php } ?>
              <?php if (isset($_SESSION["user_logged"])){ 
                $result = getAlluser("Users", $user_logged);
                $row = mysqli_fetch_assoc($result); ?>
              <li class="dropdown"><img class="dropdown-toggle" type="button" data-toggle="dropdown" id="avatar" src="<?php echo $row["ProfileImage"] ?>">
                <ul class="dropdown-menu">
                  <li><a href="Wishlist.php"><i class="fa fa-gift" aria-hidden="true"></i> My Wishlist</a></li>
                  <li><a href="#"><i class="fa fa-history" aria-hidden="true"></i> My Purchase History</a></li>
                  <li class="divider"></li>
                  <li><a href="additem.php"><i class="fa fa-plus" aria-hidden="true"></i>
 Add New Product</a></li>
                  <li><a href="viewitems.php"><i class="fa fa-cube" aria-hidden="true"></i>
 View My Products</a></li>
                  <li class="divider"></li>
                  <li><a href="editprofile.php"><i class="fa fa-cog" aria-hidden="true"></i>
 My Profile Settings</a></li>

                  <?php if($row["UserType"] == "Admin") { ?>
                  <li class="divider"></li>
                  <li><a href="approve.php">Approve Listings</a></li>
                  <li><a href="manageUsers.php">Manage Users</a></li>
                  <li><a href="addnewadmin.php">Add Admins</a></li>
                  <?php } ?>
                  <li class="divider"></li>
                  <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Log Out</a></li>
                </ul>
              </li>
              <?php } ?>
            </ul>

          </div>
        </nav><!--navigation bar-->
      </header><!--header-->

      

        <div id="breadcrum">
          <div class="container">
            <ul>
              <li><i class="fa fa-home" aria-hidden="true"></i></li>
              <?php
               if(isset($_SESSION["parentpage"])){ 
                  echo "<li>".$_SESSION["parentpage"]."</li>";
               } 
               if(isset($_SESSION["pagetitle"])){ 
                  echo "<li>".$_SESSION["pagetitle"]."</li>";
               } 
              ?>
            </ul>
         </div><!--container-->
        </div><!--breadcrum-->

        <div class="container">
          <div class="row">
            <div class="col-sm-12 col-md-12 nopadding" id="banner1">
              <img src="Images/banner1.png" width="100%" /> 
            </div>
          </div> 
        </div><!--container-->