<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
  require_once("includes/loggedin.php");
  $_SESSION["parentpage"] = "My Items";
  $_SESSION["pagetitle"] =  "View Items";
  require_once("includes/htmlheader.php");
?>

<?php 

  //if the delete btn was pressed
  if (isset($_POST["delete"])){
    delete($_POST["delete"], "ProductID", "Product");
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
                        <h2 class="col-xs-9"><i class="fa fa-cube fa-2x" aria-hidden="true"></i> My Item</h2>
                        <a class="btn btn-primary addbtn" href="additem.php"><i class="fa  fa-plus fa-lg" aria-hidden="true"></i> Add New Item</a>
                        <div class="clearfix"></div>
                        <?php 
                          if (isset($msg)){
                              echo $msg;
                          } ?>
                        <div class="clearfix"></div>
                          <?php  //get all the items for the current user
                            $result = getAlluser("Product", $user_logged);
                          ?>
                        <table class="table table-hover">
                          <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
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
                                        echo ($row["Approved"] == 1)? "<span class=\"label label-success\">Approved</span>" : "<span class=\"label label-warning\">Need Approval</span>"; echo "</td>
                                      <td>";
                                      echo ($row["Approved"] == 1)? "<a class=\"btn btn-info btn-xs\" href=\"itemdetails.php?Pid=".$row["ProductID"]."\"><i class=\"fa  fa-eye fa-lg\" aria-hidden=\"true\"></i> View</a> " : " ";
                                      echo "<a class=\"btn btn-warning btn-xs\" href=\"".$modify."\"><i class=\"fa fa-times fa-lg\" aria-hidden=\"true\"></i>
 Modify</a>                              <form method=\"POST\" action=\"viewitems.php\">
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