<?php
    $result = getAlluser("Users", $user_logged);
    $row = mysqli_fetch_assoc($result);
?>

<div class="col-md-3 col-sm-3 col-xs-12 nopadding">
                  <div class="sidemenu">
                    <img src="<?php echo $row["ProfileImage"] ?>"/>
                    <h5>Welcome Back</h5>
                    <h4><?php echo $row["Name"] ?></h4>
                    <hr/>
                    <button type="button" class="navbar-toggle sidemenu-toggle" data-toggle="collapse" data-target="#Side-Menu">
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span> 
                    </button>
                    <div class="navbar-collapse collapse nopadding" id="Side-Menu">
                      <div class="panel-group" id="accordion">

                        <!--Menu Item-->
                        <div class="panel panel-default sidemenu-item">
                          <div class="panel-heading sidemenu-itemheading">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapse0">
                            <h4 class="panel-title btn <?php addActiveHeader("My Shopping Bag") ?>">
                              <i class="fa fa-shopping-basket fa-2x" aria-hidden="true"></i> My Shopping Bag
                            </h4></a>
                          </div>
                          <div id="collapse0" class="adminnav panel-collapse collapse <?php addIn("View My Bag") ?>">
                            <div class="panel-body">
                              <div class="btn panel-title subitem <?php addActive("View My Bag") ?>">
                              <a href="mybag.php">View My Bag </a></div><br/>
                              <div class="btn panel-title subitem">
                              <a href="resetcart.php">Reset Bag</a></div><br/>
                              <div class="btn panel-title subitem"><a href="bill.php?PaymentStatus=ok">Reset Bag</a>Check Out</div>
                            </div>
                          </div>
                        </div><!--Menu Item-->

                        <!--Menu Item-->
                        <div class="panel panel-default sidemenu-item">
                          <div class="panel-heading sidemenu-itemheading">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                            <h4 class="panel-title btn <?php addActiveHeader("My Wishlist") ?>">
                              <i class="fa fa-gift fa-2x" aria-hidden="true"></i> My Wishlist
                            </h4></a>
                          </div>
                          <div id="collapse1" class="adminnav panel-collapse collapse <?php addIn("View My Wishlist") ?>">
                            <div class="panel-body">
                              <div class="btn panel-title subitem <?php addActive("View My Wishlist") ?>">
                              <a href="Wishlist.php">View My Wishlist</a></div><br/>
                              <div class="btn panel-title subitem">
                              <a href="resetWishlist.php">Reset Wishlist</a></div><br/>
                            </div>
                          </div>
                        </div><!--Menu Item-->

                        <!--Menu Item-->
                        <div class="panel panel-default sidemenu-item">
                          <div class="panel-heading sidemenu-itemheading">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                            <h4 class="panel-title btn <?php addActiveHeader("My Purchase History") ?>">
                              <i class="fa fa-history fa-2x" aria-hidden="true"></i> My Purchase History
                            </h4></a>
                          </div>
                          <div id="collapse2" class="adminnav panel-collapse collapse <?php addIn("My Purchase History") ?>">
                            <div class="panel-body">
                              <div class="btn panel-title subitem <?php addActive("History") ?>">
                              <a href="history.php">View My History </a></div><br/>
                              <div class="btn panel-title subitem"><a href="resethistory.php">Reset History</a></div><br/>
                            </div>
                          </div>
                        </div><!--Menu Item-->

                        <!--Menu Item-->
                        <div class="panel panel-default sidemenu-item">
                          <div class="panel-heading sidemenu-itemheading">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                            <h4 class="panel-title btn <?php addActiveHeader("Add New Item", "Modify Item","View Items") ?>">
                              <i class="fa fa-cube fa-2x" aria-hidden="true"></i> My Items
                            </h4></a>
                          </div>
                          <div id="collapse3" class="adminnav panel-collapse collapse <?php addIn("Add New Item", "Modify Item","View Items") ?>">
                            <div class="panel-body">
                              <div class="btn panel-title subitem <?php addActive("View Items") ?>">
                              <a href="viewitems.php">View All Items</a></div><br/>
                              <div class="btn panel-title subitem <?php addActive("Add New Item") ?>">
                              <a href="additem.php">Add New Item</a></div><br/>
                            </div>
                          </div>
                        </div><!--Menu Item-->

                        <!--Menu Item-->
                        <div class="panel panel-default sidemenu-item">
                          <div class="panel-heading sidemenu-itemheading">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
                            <h4 class="panel-title btn <?php addActiveHeader("Modify Profile", "Change Password") ?>">
                              <i class="fa fa-cog fa-2x" aria-hidden="true"></i> My Accout Settings
                            </h4></a>
                          </div>
                          <div id="collapse5" class="adminnav panel-collapse collapse <?php addIn("Modify Profile", "Change Password") ?>">
                            <div class="panel-body">
                              <div class="btn panel-title subitem <?php addActive("Modify Profile") ?>">
                              <a href="editprofile.php">Modify Profile</a></div><br/>
                              <div class="btn panel-title subitem <?php addActive("Change Password") ?>">
                              <a href="changepassword.php">Change Password</a></div><br/>
                            </div>
                          </div>
                        </div><!--Menu Item-->

                        <?php if($row["UserType"] == "Admin") { ?>
                        <!--Menu Item-->
                        <div class="panel panel-default sidemenu-item">
                          <div class="panel-heading sidemenu-itemheading">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">
                            <a href="approve.php">
                            <h4 class="panel-title btn <?php addActiveHeader("Approve Items") ?>">
                              <i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i> Approve Listing
                            </h4></a></a>
                          </div>
                        </div><!--Menu Item-->

                        <!--Menu Item-->
                        <div class="panel panel-default sidemenu-item">
                          <div class="panel-heading sidemenu-itemheading">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapse7">
                            <a href="manageUsers.php">
                            <h4 class="panel-title btn <?php addActiveHeader("Manage Users") ?>">
                              <i class="fa fa-Users fa-2x" aria-hidden="true"></i> Manage Users
                            </h4></a></a>
                          </div>
                        </div><!--Menu Item-->

                        <!--Menu Item-->
                        <div class="panel panel-default sidemenu-item">
                          <div class="panel-heading sidemenu-itemheading">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapse8">
                            
                            <h4 class="panel-title btn  <?php addActiveHeader("Manage Admins", "Add New Admin") ?>">
                              <i class="fa fa-user-secret fa-2x" aria-hidden="true"></i> Manage Admins
                            </h4></a>
                          </div>
                          <div id="collapse8" class="adminnav panel-collapse collapse <?php addIn("Add New Admin") ?>">
                            <div class="panel-body">
                            <div class="btn panel-title subitem <?php addActive("Add New Admin") ?>"><a href="addnewadmin.php">Add New</a></div><br/>
                            </div>
                          </div>
                        </div><!--Menu Item-->
                        <?php } ?>

                        <!--Menu Item-->
                        <div class="panel panel-default sidemenu-item">
                          <div class="panel-heading sidemenu-itemheading">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapse10">
                            <a href="logout.php"><h4 class="panel-title btn" >
                              <i class="fa fa-sign-out fa-2x" aria-hidden="true"></i> Log Out
                            </h4></a></a>
                          </div>
                        </div><!--Menu Item-->

                      </div>
                    </div>
                  </div><!--side menu-->
                </div>