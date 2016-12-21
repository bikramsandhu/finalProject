<?php require('includes/config.php');

//if logged in redirect to members page
if( $user->is_logged_in() ){ header('Location: memberpage.php'); }

//if form has been submitted process it
if(isset($_POST['submit'])){

	//email validation
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a VALID email address';
	} else {
		//uses fetch which is factory
		$stmt = $db->prepare('SELECT email FROM members WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(empty($row['email'])){
			$error[] = 'This email is not recognized by the system.';
		}

	}

	//if no errors have been created carry on
	if(!isset($error)){

		//create the activation code
		$token = md5(uniqid(rand(),true));

		try {

			$stmt = $db->prepare("UPDATE members SET resetToken = :token, resetComplete='No' WHERE email = :email");
			$stmt->execute(array(
				':email' => $row['email'],
				':token' => $token
			));

			//send email
			$to = $row['email'];
			$subject = "Password Reset";
			$body = "<p>Request to change password...</p>
			<p>To reset your password,please click here: <a href='".DIR."resetPassword.php?key=$token'>".DIR."resetPassword.php?key=$token</a></p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			//redirect to index page
			header('Location: login.php?action=reset');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//define page title
$title = 'Reset Account';

//include header template
require('layout/header.php');
?>
<img src="http://archives.njit.edu/vhlib/images/njit_logo.gif" alt="NJIT logo">
<div class="container">

	<div class="row">
			<form role="form" method="post" action="" autocomplete="off">
				<h1 style="color:red"><center><strong>Reset Password</strong></center></h1>
				<p><center><a href='login.php'>Back to login page</a></center></p>


				<?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<center><p style="color:#4FFF33" class="bg-danger">'.$error.'</p></center>';
					}
				}

				if(isset($_GET['action'])){

					//check the action
					switch ($_GET['action']) {
						case 'active':
							echo "<h2 class='bg-success'>Your account is now active you may now log in.</h2>";
							break;
						case 'reset':
							echo "<h2 class='bg-success'>Please check your inbox for a reset link.</h2>";
							break;
					}
				}
				?>
				<br>
				<div class="form-group">
					<center><input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email" value="" tabindex="1"></center>
				</div>

				<div class="row">
					<br><br>
					<center><div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Send Reset Link to Email" class="btn btn-primary btn-block btn-lg" tabindex="2"></div></center>
				</div>
			</form>
		</div>
	</div>


</div>
