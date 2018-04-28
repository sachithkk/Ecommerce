<?php 
  require_once("includes/header.php");
  require_once("includes/connect.php");
  require_once("includes/functions.php");
  $_SESSION["parentpage"] = null;
  $_SESSION["pagetitle"] =  "Contact Us";
  require_once("includes/htmlheader.php");
  require_once("includes/PHPMailerAutoload.php")
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
		<div class="col-md-6 col-sm-12">
			<h2>Please Feel free to Contact Us!</h2>
			<h6>It would be our pleaseure to have your enquries</h6>
			<br/>
			<p>Our customer service staff will attend to your questions. Please fill in the contact form and click the 'Send' Button to send us your enqueries. Please mention you correct email address and select the relevant department. Also please give attention to mention the details of you issue. This is to make sure that we understand your questions better and them address to them even better.</p>
			<br/>
			<p>We will anwser your enquries with in 48 hours from the time of recieving them. This will exclude for holidays. Please do not send the same enquries more than once and be patient while we reply to you as soon as possible.</p>
		</div>
		<div class="col-md-6 col-sm-12 mt-10">
			<?php echo $formError ?>
			<form method="POST" action ="contactus.php">
				<div class="form-group">
					<label>Your Name</label>
					<input class="form-control" type="text" name="name" value="<?php echo $name ?>"/><br/>
					<label>Your Email Address</label>
					<input class="form-control" type="email" name="email" value="<?php echo $name ?>"/><br/>
					<label>Select the Relevent Department</label>
					<select class="form-control" name="department">
						<option value="none" <?php selected("department", "none") ?>>Select Department</option>
						<option value="Customer" <?php selected("department", "Customer") ?>>Customer Service</option>
						<option value="Sales" <?php selected("department", "Sales") ?>>Sales Department</option>
						<option value="Technical" <?php selected("department", "Technical") ?>>Technical Department</option>
					</select><br/>
					<label>Descripe your details</label>
					<textarea class="form-control" name="description" rows="5" cols="5"><?php echo $description ?></textarea><br/>
					<button class="btn btn-primary" type="submit" name="submit" value="submit">Send</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php require_once("includes/footer.php");?>

