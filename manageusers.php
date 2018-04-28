<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
  require_once("includes/loggedin.php");
  require_once("includes/adminonly.php");
  $_SESSION["parentpage"] = null;
  $_SESSION["pagetitle"] =  "Manage Users";
  require_once("includes/htmlheader.php");
?>

<?php 

  //if the delete btn was pressed
  if (isset($_POST["delete"])){
    if($_POST["delete"] != $user_logged){
      delete($_POST["delete"], "UserID", "Users");
      $_SESSION["msg"] = "<div class=\" alert alert-success\">
                        <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                        <strong>Success!</strong> User Deleted!
                      </div>";
    } else {
      $_SESSION["msg"] = "<div class=\" alert alert-danger\">
                        <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                        <strong>Invalid Action!</strong> You cannot delete your own account! 
                      </div>";
    }
  }

  //check and get the msg passed from previous page
  if (isset($_SESSION["msg"])){
    $msg = $_SESSION["msg"];
    $_SESSION["msg"] = null;
  }

?>

        <div class="container">
          <div class="row">
              <?php require_once("includes/adminnav.php") ?>

                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="accountbody">
                        <h2 class="col-xs-9"><i class="fa fa-cube fa-2x" aria-hidden="true"></i> Manage Users</h2>
                        <div class="clearfix"></div>
                        <?php 
                          if (isset($msg)){
                              echo $msg;
                          } ?>
                        <div class="clearfix"></div>
                          <?php  //get all the Users info  
                            $result = getAll("Users");
                          ?>
                        <table class="table table-hover">
                          <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Contact No</th>
                            <th>Country</th>
                            <th>Action</th>
                          </tr>
                          <?php 
                            while($row = mysqli_fetch_assoc($result)){
                              echo "<tr>
                                      <td><img height=\"60px\" width=\"60px\"  style=\"border-radius:100%;\"src=\"".$row["ProfileImage"]."\"/> 
                                      <td>".$row["Name"]."</td>
                                      <td>".$row["Email"]."</td>
                                      <td>".$row["Username"]."</td>
                                      <td>".$row["ContactNo"]."</td>
                                      <td>".$row["Country"]."</td>
                                      <td class=\"status\">";
                                      echo "<form method=\"POST\" action=\"manageUsers.php\"><button class=\"btn btn-danger btn-xs\" type=\"submit\" name=\"delete\" value=\"".$row["UserID"]."\" onclick=\" return confirm('Are you sure you want to delete the Item?');\" ><i class=\"fa fa-times fa-lg\" aria-hidden=\"true\"></i>Delete</button></form>
                                      </td>
                                    </tr>" ;
                            }
                          ?>
                        </table>
                    </div><!--Account Body-->
                  </div>
          </div>
        </div><!--container-->
<?php require_once("includes/footer.php"); ?>