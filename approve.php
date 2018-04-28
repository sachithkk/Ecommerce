<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
  require_once("includes/loggedin.php");
  require_once("includes/adminonly.php");
  $_SESSION["parentpage"] = null;
  $_SESSION["pagetitle"] =  "Approve Items";
  require_once("includes/htmlheader.php");
?>

<?php 

  //if the delete btn was pressed
  if (isset($_POST["delete"])){
    delete($_POST["delete"], "ProductID", "Product");
  }

  //if item was approved
  if (isset($_POST["approve"])){
    $query = "UPDATE Product SET ";
    $query .= "Approved = 1 WHERE ProductID=".$_POST["approve"];
    $result = mysqli_query($connection, $query);
    if($result){
      $_SESSION["msg"] = "<div class=\" alert alert-success\">
                        <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                        <strong>Success!</strong> The Item was Approved.
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
                        <h2 class="col-xs-9"><i class="fa fa-cube fa-2x" aria-hidden="true"></i> Approve Items</h2>
                        <div class="clearfix"></div>
                        <?php 
                          if (isset($msg)){
                              echo $msg;
                          } ?>
                        <div class="clearfix"></div>
                          <?php  //get all the items for the current user
                            $query = "SELECT * FROM Product WHERE ";
                            $query .= "Approved = 0;";
                            $result = mysqli_query($connection, $query);
                          ?>
                        <table class="table table-hover">
                          <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Approve</th>
                            <th>Action</th>
                          </tr>
                          <?php 
                            while($row = mysqli_fetch_assoc($result)){
                              $catname = getCatName($row["CatID"]);
                              $modify = "edititem.php?Pid=".$row["ProductID"];
                              echo "<tr>
                                      <td>".$row["Name"]."</td>
                                      <td>".$catname."</td>
                                      <td>Rs.".$row["Price"]."</td>
                                      <td>".$row["Stock"]."pcs</td>
                                      <td class=\"status\">";
                                      echo "<form method=\"POST\" action=\"approve.php\"><button class=\"btn btn-info btn-xs\" type=\"submit\" name=\"approve\" value=\"".$row["ProductID"]."\" ><i class=\"fa fa-check fa-lg\" aria-hidden=\"true\"></i>
 Approve</button></form></td>
                                      <td>";
                                      echo"<a class=\"btn btn-info btn-xs\" href=\"itemdetailsforapprove.php?Pid=".$row["ProductID"]."\"><i class=\"fa  fa-eye fa-lg\" aria-hidden=\"true\"></i> View</a> ";
                                      echo "<a class=\"btn btn-warning btn-xs\" href=\"".$modify."\"><i class=\"fa fa-times fa-lg\" aria-hidden=\"true\"></i>
 Modify</a>                              <form method=\"POST\" action=\"approve.php\">
                                         <button class=\"btn btn-danger btn-xs\" type=\"submit\" name=\"delete\" value=\"".$row["ProductID"]."\" onclick=\" return confirm('Are you sure you want to delete the Item?');\" ><i class=\"fa fa-times fa-lg\" aria-hidden=\"true\"></i>
 Delete</button></form>
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