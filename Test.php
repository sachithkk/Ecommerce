<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
  //$_SESSION["parentpage"] = null;
  //$_SESSION["pagetitle"] =  "Register";
?>

<?php

  //if logged in then log out
  if (isset($_SESSION["user_logged"])){
    $_SESSION["user_logged"] = null;
  }

  $name = "";
  $username = "";
  $password = "";
  $repassword = "";
  $gender = "Male";
  $contact = "";
  $email = "";
  $country = "";
  $formError = "";

  if (isset($_POST["submit"])){
    $name = $_POST["name"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $repassword = $_POST["repassword"];
    $gender = $_POST["gender"];
    $contact = $_POST["contact"];
    $email = $_POST["email"];
    $country = $_POST["country"];

    if ($name == ""){
      $formError = "<div class=\"alert alert-danger\">
              <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
              <strong>Empty Field!</strong> The Name feild is Empty. Please fill the field.
            </div>";
    }
    if ($username == ""){
      $formError .= "<div class=\"alert alert-danger\">
              <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
              <strong>Empty Field!</strong> The Username feild is Empty. Please fill the field.
            </div>";
    }else if(!checkUnique($username, "Username", "Users")){
      $formError .= "<div class=\"alert alert-danger\">
              <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
              <strong>Username Already Taken!</strong> Please use another username.
            </div>";
    }
    if ($password == ""){
      $formError .= "<div class=\"alert alert-danger\">
              <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
              <strong>Empty Field!</strong> The Password feild is Empty. Please fill the field.
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
    if($password != $repassword ){
      $formError .= "<div class=\"alert alert-danger\">
              <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
              <strong>Passwords do not Match!</strong> The password and repassword do not match.
            </div>";
    }

    if ($formError == ""){
      
      $name =  mysqli_real_escape_string($connection, $name);
      $username = mysqli_real_escape_string($connection, $username);
      $contact = mysqli_real_escape_string($connection, $contact);
      $email = mysqli_real_escape_string($connection, $email);
      $country = mysqli_real_escape_string($connection, $country);
      $gender =  mysqli_real_escape_string($connection, $gender);

      $passhash = password_hash($password, PASSWORD_DEFAULT);

      //set default Profile Picture
      //if ($gender == "Male"){ $pp = "Images/img_avatar.png"; } else {  $pp = "Images/img_avatar2.png"; }

      $query = "INSERT INTO Users ";
      $query .= "(Name, Username, userPassword, Gender, ContactNo, Email, Country, UserType,) ";
      $query .= "VALUES ('".$name."', '".$username."', '".$passhash."', '".$gender."', '".$contact."', '".$email."', '".$country."', 'user' );"; 
      
     $result = mysqli_query($connection, $query);
     if ($result) {
      //send success msg to login page
      $_SESSION["msg"] = "<div class=\" alert alert-success\">
                        <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                        <strong>Success!</strong> You have been successfuly registered. Please login!
                      </div>";
      redirectTo("login.php");
     }
    }
    //reseting the password value
    $password = "";
    $repassword = "";
  }
  
  require_once("includes/htmlheader.php");
?>





    <div class="container" style="background-color:transparent;">
        <div class="col-md-2 visible-md visible-lg"></div>
        <div class="col-md-8 floatform">
          <h2>Signup and Join </h2>
          <br/><br/>
          <?php echo $formError ?>
      <form method="POST" action="userregistration.php" class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="<?php echo $name ?>"/>
        <br/>
		
        <div class="col-md-4">
          <label>Username</label>
          <input type="text" name="username" class="form-control" value="<?php echo $username ?>">
          <br/>
        </div>
        <div class="col-md-4">
          <label>Password</label>
          <input type="password" name="password" class="form-control" value="<?php echo $password ?>">
          <br/>
        </div>
        <div class="col-md-4">
          <label>Re-Password</label>
          <input type="password" name="repassword" class="form-control" value="<?php echo $repassword ?>">
          <br/>
        </div>
		
        <div class="col-md-4">
          <label>Gender</label><br/>
          <label class="radio-inline"><input type="radio" name="gender"  value="Male"<?php echo ($gender == "Male")? "checked" : "" ?> >Male</label>
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
        <button class="btn btn-primary addbtn" type="submit" name="submit" value="submit">Register</button>
      </form>
    </div>
    <div class="col-md-2 visible-md visible-lg"></div>
  </div><!--container-->

<?php require_once("includes/footer.php"); ?>