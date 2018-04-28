<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
  $_SESSION["parentpage"] = null;
  $_SESSION["pagetitle"] =  "Login";
?>

<?php
  //if logged in then log out
  if (isset($_SESSION["user_logged"])){
    $_SESSION["user_logged"] = null;
    $user_logged = null;
  }

  $username = "";
  $password = "";
  $formError = "";

  if (isset($_POST["submit"])){ 
    $username = $_POST["username"];
    $password = $_POST["password"];
  
    if ($username == ""){
      $formError .= "<div class=\"alert alert-danger\">
              <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
              <strong>Empty Field!</strong> The Username feild is Empty. Please fill the field.
            </div>";
    }

    if ($password == ""){
      $formError .= "<div class=\"alert alert-danger\">
              <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
              <strong>Empty Field!</strong> The Password feild is Empty.
            </div>";
    }

    if ($formError == ""){
      
      $username = mysqli_real_escape_string($connection,$username);
      $query = "SELECT UserID, Username, userPassword FROM Users WHERE ";
      $query .= "Username = '".$username."'";
      $result = mysqli_query($connection, $query);
      $rows = mysqli_fetch_assoc($result);
      if(count($rows) > 1){
          $pass = password_verify($password, $rows["userPassword"]);
          if($pass){
            //login successful
            $_SESSION["user_logged"] = $rows["UserID"];
            redirectTo("index.php");
          }
		  
		  else {
            //Invalid Password
            $formError .= "<div class=\"alert alert-danger\">
              <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
              <strong>Invalid Login!</strong> Username Or Password is incorrect.
            </div>";
          }
		  
      } 
	  
	  else {
            // Invalid Username
            $formError .= "<div class=\"alert alert-danger\">
              <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
              <strong>Invalid Login username!</strong> The Username Or Password is incorrect.
            </div>";
          }  
    }
    //reseting the password value
    $password = "";
    $repassword = "";
  }

  //check and get the msg passed from previous page
  if (isset($_SESSION["msg"])){
    $msg = $_SESSION["msg"];
    $_SESSION["msg"] = null;
  }
  require_once("includes/htmlheader.php");
?>
    <div class="container" style="background-color:transparent;">
        <div class="col-md-3 visible-md visible-lg"></div>
        <div class="col-md-6 floatform">
          <h2>Login to your Account </h2>
          <br/>
          <?php if (isset($msg)){echo $msg;} ?><br/>
          <?php echo $formError ?>
      <form method="POST" action="login.php" class="form-group">
        <label>Userame</label>
        <input type="text" name="username" class="form-control" value="<?php echo $username ?>"/>
        <br/>
        <label>Password</label>
        <input type="password" name="password" class="form-control" value=""/>
        <br/>
        <button class="btn btn-primary addbtn" type="submit" name="submit" value="submit">Login</button>
        <a class="btn btn-primary addbtn" href="userregistration.php">Register</a>
      </form>
    </div>
    <div class="col-md-3 visible-md visible-lg"></div>
  </div><!--container-->

<?php require_once("includes/footer.php"); ?>