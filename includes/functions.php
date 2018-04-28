<?php 

function getAll($table){
	global $connection;
	$query = "SELECT * FROM ".$table;
	$result = mysqli_query($connection, $query);
	return $result;
}

function getAlluser($table, $user){
	global $connection;
	$query = "SELECT * FROM ".$table;
	$query .= " WHERE UserID = ".$user;
	$result = mysqli_query($connection, $query);
	return $result;
}

function getAllProduct($table, $Product){
	global $connection;
	$query = "SELECT * FROM ".$table;
	$query .= " WHERE ProductID = ".$Product;
	$result = mysqli_query($connection, $query);
	return $result;
}

function getProductNameCatID($Productid){
	global $connection;
	$query = "SELECT Name, CatID FROM Product ";
	$query .= " WHERE ProductID = ".$Productid;
	$result = mysqli_query($connection, $query);
	$name = mysqli_fetch_assoc($result);
	return $name;
}

function selected($selection, $option){
	if(isset($_POST["$selection"])){
	if ($_POST["$selection"] == $option){
		echo "selected";
	}}
} 

function selectedGET($selection, $option){
	if (isset($_GET["$selection"])){
		if ($_GET["$selection"] == $option){
			echo "selected";
		}
	}
} 

function checked($name, $value){
	if(isset($_GET["$name"])){
		$no = count($_GET["$name"]);
		for ($j=0; $j < $no; $j++){
			if($_GET["$name"][$j] == $value){
				return "checked";
			}
		}
		return "";
	}
}

function checkEmpty($field){
	if(($_POST["$field"] == "") || ($_POST["$field"] == null)){
		return true;
	} else {
		return false;
	}
}

function uploadFile($field){
	global $formError;
	$target_dir = "Images/uploads/";
	$cname = $target_dir.$_FILES["$field"]["name"];
	$exten = pathinfo($cname ,PATHINFO_EXTENSION);
	$random = mt_rand(100,999999);
	$target_file = $target_dir . $random .".".$exten;
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getImagesize($_FILES["$field"]["tmp_name"]);
	    if($check !== false) {
	        $uploadOk = 1;
	    } else {
	    	$formError .= "<div class=\"alert alert-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Invalid Image!</strong> Please upload a Valid Image.</div>";
	        $uploadOk = 0;
	        return -1;
	    }
	}
	// Check if file already exists
	if (file_exists($target_file)) {
		$formError .= "<div class=\"alert alert-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Upload Failed!</strong> Please try again to Upload.</div>";
	    $uploadOk = 0;
	    return -1;
	}
	// Check file size
	if ($_FILES["$field"]["size"] > 1000000) {
		$formError .= "<div class=\"alert alert-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Image Size is too Large!</strong> Only Images below 1MB can be uploaded.</div>";
	    $uploadOk = 0;
	    return -1;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "jpeg" ) {
		$formError .= "<div class=\"alert alert-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Invalid Image Format!</strong> Only .jpg, .jpeg files are supported.</div>";
	    $uploadOk = 0;
	    return -1;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["$field"]["tmp_name"], $target_file)) {
	    	return $target_file;
	    } else {
	        $formError .= "<div class=\"alert alert-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Upload Failed!</strong> Please try again, If this error continue contact administrator.</div>";
	        return -1;
	    }
	}

}

function getCatName($catid){
	global $connection;
	$query = "SELECT Name FROM Category ";
	$query .= "WHERE CatID =".$catid;
	$result = mysqli_query($connection, $query);
	$id = mysqli_fetch_assoc($result);
	return $id["Name"];
}

function delete($id, $value, $table){
	global $connection;
	$query = "DELETE FROM ".$table;
	$query .= " WHERE ".$value."= ".$id;
	mysqli_query($connection, $query);
}

function checkUnique($value, $column, $table){
	global $connection;
	$query = "SELECT ".$column." FROM ".$table." WHERE ";
	$query .= $column."= '".$value."'";
	$result = mysqli_query($connection, $query);
	$rows = mysqli_fetch_row($result);
	if(count($rows) > 0){
		return false;
	}else {
		return true;
	}
}

function addIn($pagename, $page2name = "blank", $page3name = "blank"){
	if($_SESSION["pagetitle"] ==  $pagename){
		echo "in";
	}
	if($_SESSION["pagetitle"] ==  $page2name){
		echo "in";
	}
	if($_SESSION["pagetitle"] ==  $page3name){
		echo "in";
	}
}

function addActiveHeader ($pagename, $page2name = "blank", $page3name = "blank"){
	if($_SESSION["pagetitle"] ==  $pagename){
		echo "active";
	}
	if($_SESSION["pagetitle"] ==  $page2name){
		echo "active";
	}
	if($_SESSION["pagetitle"] ==  $page3name){
		echo "active";
	}
}

function addActive($pagename){
	if($_SESSION["pagetitle"] ==  $pagename){
		echo "active";
	}
}

function last($column, $table){
	global $connection;
	$query = "SELECT ".$column." FROM ".$table;
	$query .= " ORDER BY ".$column." DESC LIMIT 1";
	$result = mysqli_query($connection, $query);
	$rows = mysqli_fetch_array($result);
	return $rows[0];
}
	
function countnum($table, $column, $value){
	global $connection;
	$query = "SELECT count(*) FROM ".$table." WHERE ";
	$query .= $column." = '".$value."'";
	$result = mysqli_query($connection, $query);
	$rows = mysqli_fetch_array($result);
	return $rows[0];
}

function countnumApproved($column, $value){
	global $connection;
	$query = "SELECT count(*) FROM Product WHERE Approved = 1 AND ";
	$query .= $column." = '".$value."'";
	$result = mysqli_query($connection, $query);
	$rows = mysqli_fetch_array($result);
	return $rows[0];
}

function getImage($pid, $limit){
	global $connection;
	$imgquery = "SELECT ImageURL From Images WHERE ProductID =".$pid." LIMIT ".$limit;
	$imgresult = mysqli_query($connection, $imgquery);
	$imgrows = mysqli_fetch_all($imgresult);
	return $imgrows;
}

?>