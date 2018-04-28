<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
  require_once("includes/loggedin.php");
  $_SESSION["parentpage"] = "My Account Settings";
  $_SESSION["pagetitle"] =  "Change Password";
?>
  
<?php
  
  $formError = "";

  if (isset($_POST["submit"])){
    $password = $_POST["password"];
    $newpassword = $_POST["newpassword"];
    $renewpassword = $_POST["renewpassword"];

    if ($password == ""){
      $formError .= "<div class=\"alert alert-danger\">
              <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
              <strong>Empty Field!</strong> The Password feild is Empty. Please fill the field.
            </div>";
    }

    if ($newpassword == ""){
      $formError .= "<div class=\"alert alert-danger\">
              <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
              <strong>Empty Field!</strong> The Password feild is Empty. Please fill the field.
            </div>";
    }

    if($newpassword != $renewpassword ){
      $formError .= "<div class=\"alert alert-danger\">
              <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
              <strong>Passwords do not Match!</strong> The new password and re-enter new password do not match.
            </div>";
    }

    if ($formError == ""){

      $result = getAlluser("Users", $user_logged);
      $row = mysqli_fetch_assoc($result);

      $valid = password_verify($password,$row["userPassword"]);
      if($valid){
        $passhash = password_hash($newpassword, PASSWORD_DEFAULT);

        $query = "UPDATE Users SET ";
        $query .= "userPassword = '".$passhash."' WHERE ";
        $query.= "UserID = ".$user_logged.";";

        $result = mysqli_query($connection, $query);
        if ($result) {
          //log user out and send to login page
          $_SESSION["user_logged"] = null;
          $_SESSION["msg"] = "<div class=\" alert alert-success\">
                          <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                          <strong>Success!</strong> You have changed your password. Please login with New Password!
                        </div>";
          redirectTo("login.php");
        }
      }else { $_SESSION["msg"] = "<div class=\" alert alert-danger\">
                          <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                          <strong>Invalid Password!</strong> The current Password was invalid!
                        </div>"; }
    }
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
                        <h2><i class="fa fa-cog fa-2x" aria-hidden="true"></i> Change Password</h2>
                        <?php if (isset($msg)){echo $msg;} ?><br/>
                        <?php echo $formError ?>
                        <form method="POST" action="changepassword.php" class="form-group">
                          <div class="col-md-12">
                          <label>Enter Current Password</label>
                          <input type="password" name="password" class="form-control" value=""/>
                          <br/>
                          </div>
                          <div class="col-md-12">
                          <label>Enter New Password</label>
                          <input type="password" name="newpassword" class="form-control" value=""/>
                          <br/>
                          </div>
                          <div class="col-md-12">
                          <label>Re-Enter New Password</label>
                          <input type="password" name="renewpassword" class="form-control" value=""/>
                          <br/>
                          </div>
                          <button class="btn btn-primary addbtn" type="submit" name="submit" value="submit">Change My Password</button>
                        </form>
                    </div><!--Account Body-->
                  </div>
              
          </div>
        </div><!--container-->
<?php require_once("includes/footer.php"); ?>