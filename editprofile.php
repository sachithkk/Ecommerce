<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
  require_once("includes/loggedin.php");
  $_SESSION["parentpage"] = "My Account Settings";
  $_SESSION["pagetitle"] =  "Modify Profile";
?>

<?php
  
  $result = getAlluser("Users", $user_logged);
  $row = mysqli_fetch_assoc($result);

  $name = $row["Name"];
  $gender = $row["Gender"];
  $contact = $row["ContactNo"];
  $email = $row["Email"];
  $country = $row["Country"];
  $pp = $row["ProfileImage"];
  $formError = "";

  if (isset($_POST["submit"])){
    $name = $_POST["name"];
    $gender = $_POST["gender"];
    $contact = $_POST["contact"];
    $email = $_POST["email"];
    $country = $_POST["country"];
    if(!empty($_FILES["pp"]["name"])){
      $pp = $_FILES["pp"]["name"];
    }

    if ($name == ""){
      $formError = "<div class=\"alert alert-danger\">
              <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
              <strong>Empty Field!</strong> The Name feild is Empty. Please fill the field.
            </div>";
    }    
    if ($contact == ""){
      $formError .= "<div class=\"alert alert-danger\">
              <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
              <strong>Empty Field!</strong> The Name feild is Empty. Please fill the field.
            </div>";
    }
    if ($email == ""){
      $formError .= "<div class=\"alert alert-danger\">
              <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
              <strong>Empty Field!</strong> The Name feild is Empty. Please fill the field.
            </div>";
    }
    if ($country == ""){
      $formError .= "<div class=\"alert alert-danger\">
              <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
              <strong>Empty Field!</strong> The Name feild is Empty. Please fill the field.
            </div>";
    }
    $optgender = array("Male", "Female");
    if (!in_array($gender, $optgender)){
      $formError .= "<div class=\"alert alert-danger\">
              <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
              <strong>Invalid Value!</strong> The value for gender is Invalid.
            </div>";
    }
    if ($formError == ""){
      
      //upload the new profile pic
      if(!empty($_FILES["pp"]["name"])){
      $ppURL = uploadFile("pp");
    } else { $ppURL = $pp; }

      //clear all SQL injections
      $name =  mysqli_real_escape_string($connection, $name);
      $contact = mysqli_real_escape_string($connection, $contact);
      $email = mysqli_real_escape_string($connection, $email);
      $country = mysqli_real_escape_string($connection, $country);
      $gender = mysqli_real_escape_string($connection, $gender);

      $query = "UPDATE Users ";
      $query .= "SET Name='".$name."', Gender='".$gender."', ContactNo='".$contact."', Email='".$email."', Country='".$country."', ProfileImage= '".$ppURL."' WHERE UserID=".$user_logged.";";

     $result = mysqli_query($connection, $query);
     if ($result) {
      //send success msg to login page
      $_SESSION["msg"] = "<div class=\" alert alert-success\">
                        <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                        <strong>Success!</strong> Your Profile has been successfully Updated!
                      </div>";

      //reload all new values
      $result = getAlluser("Users", $user_logged);
      $row = mysqli_fetch_assoc($result);

      $name = $row["Name"];
      $gender = $row["Gender"];
      $contact = $row["ContactNo"];
      $email = $row["Email"];
      $country = $row["Country"];
      $pp = $row["ProfileImage"];
     }
    }
  }
  //check to see if msg was left
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
                        <h2><i class="fa fa-cog fa-2x" aria-hidden="true"></i> Edit My Profile</h2>
                        <?php if (isset($msg)){echo $msg;} ?><br/>
                        <?php echo $formError ?>
                        <form method="POST" action="editprofile.php" class="form-group" enctype="multipart/form-data">
                          <div class="col-md-2 profileimage">
                            <label>Profile Picture</label>
                            <img src="<?php echo $pp ?>"/>
                            <input type="file" name="pp"/>
                            <br/>
                          </div>
                          <div class="clearfix"></div>
                          <div class="col-md-12">
                          <label>Name</label>
                          <input type="text" name="name" class="form-control" value="<?php echo $name ?>"/>
                          <br/>
                          </div>
                          <div class="col-md-4">
                            <label>Gender</label><br/>
                            <label class="radio-inline"><input type="radio" name="gender"  value="Male"
                                <?php echo ($gender == "Male")? "checked" : "" ?>
                                >Male</label>
                            <label class="radio-inline"><input type="radio" name="gender" value="Female" 
                                <?php echo ($gender == "Female")? "checked" : "" ?>
                                >Female</label>
                            <br/>
                          </div>
                          <div class="col-md-8">
                            <label>Contact Number</label><br/>
                            <input type="number" name="contact" value="<?php echo $contact ?>" class="form-control"  />
                            <br/>
                          </div>
                          <label>Email</label>
                          <input type="email" name="email" class="form-control" value="<?php echo $email?>" />
                          <br/>
                          <label>Country</label>
                          <input type="text" name="country" class="form-control" value="<?php echo $country ?>"/>
                          <br/>
                          <button class="btn btn-primary addbtn" type="submit" name="submit" value="submit">Update My Profile</button>
                        </form>
                    </div><!--Account Body-->
                  </div>
              
          </div>
        </div><!--container-->
<?php require_once("includes/footer.php"); ?>