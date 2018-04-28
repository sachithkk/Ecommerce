<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
  $_SESSION["parentpage"] = null;
  $_SESSION["pagetitle"] =  "About Us";
  require_once("includes/htmlheader.php");
  require_once("includes/PHPMailerAutoload.php");
?>
<?php
	$formError = "";
	$name = "";
	$email = "";
	$description = "";
	$department = "none";

	if(isset($_POST["name"])){
		$name = $_POST["name"];
	}
	if(isset($_desPOST["email"])){
		$email = $_POST["email"];
	}
	if(isset($_POST["department"])){
		$department = $_POST["department"];
	}
	if(isset($_POST["description"])){
		$description = $_POST["description"];
	}

	if (isset($_POST["submit"])){
	if(checkEmpty("name")){$formError .= "<div class=\"alert alert-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Field Empty!</strong> Please fill int the Name Field.</div>"; }

	if(checkEmpty("email")){$formError .= "<div class=\"alert alert-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Field Empty!</strong> Please fill int the Email Field.</div>"; }

	if($department == "none"){$formError .= "<div class=\"alert alert-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Incomplete!</strong> Please select the relevent department.</div>"; }

	if(checkEmpty("description")){$formError .= "<div class=\"alert alert-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Incomplete!</strong> Please select the relevent department.</div>"; }
	}

?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>About KoolBabies.lk</h2>
			<br/>
			<p>KoolBabies.lk is a website developed by students at Srilankan Institute for Information Technology as a part of the Course work for Internet and Technological Application (ITA) in the 1st Year 2nd Semister. However the keen interest and dedication of the team members and especially the head developer, Jailam had made the website beyond the course requirements. As the result the website is fully functional and fully capable to be used by Cooperation and Companies for ecomerce purpose. The website has been made entirely from sratch by the team under the supervision of the head developer Jailam. No part of the website has used templates.</p>
			<br/>
			<p>The website is made responsive to all screen sizes, with the help of Bootstrap. It is also uses Google Fonts, Fontawesome Online fonts for icons and TinyMCE framework for text editiing. The website has uses PHP 5.6 or later and uses high secure algorithms to capture and store data. The website features a flat and easy to use interface.</p>
		</div>
		<div class="col-md-12 mt-10 members">
			<h2>The Team behind the Website</h2>
			<br/>
			<div class="col-md-3">
				<img src="Images/img_avatar.png" width="80%"/>
				<h3>Mohamed Jailam</h3>
				<h4>Head Developer</h4>
			</div>
			<div class="col-md-3">
				<img src="Images/img_avatar.png" width="80%"/>
				<h3>Sachith Tharaka(KKS)</h3>
				<h4>Head Developer</h4>
			</div>
			<div class="col-md-3">
				<img src="Images/img_avatar.png" width="80%"/>
				<h3>Umidu Dilshan</h3>
				<h4>Head Developer</h4>
			</div>
			<div class="col-md-3">
				<img src="Images/img_avatar.png" width="80%"/>
				<h3>Sankha Wijesinhge</h3>
				<h4>Head Developer</h4>
			</div>
		</div>
		<div class="col-md-12 fricons">
			<h2>Frameworks used in Develoment</h2>
			<br/>
			<div class="col-md-3">
				<img src="Images/bootstrap_logo.png" width="90%"/>
			</div>
			<div class="col-md-3">
				<img src="Images/logo_google_fonts.png" width="90%"/>
			</div>
			<div class="col-md-3">
				<img src="Images/tinymce.gif" width="50%"/>
			</div>
			<div class="col-md-3">
				<img src="Images/mailer.png" width="90%"/>
			</div>
		</div>
	</div>
</div>

<?php require_once("includes/footer.php");?>

