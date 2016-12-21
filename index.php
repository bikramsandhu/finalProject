<?php require('includes/config.php');

if( $user->is_logged_in() ){ header('Location: memberpage.php'); }

if(isset($_POST['submit'])){

	if(strlen($_POST['username']) < 3){
		$error[] = 'Username is too short.';
	} else {
		$stmt = $db->prepare('SELECT username FROM members WHERE username = :username');
		$stmt->execute(array(':username' => $_POST['username']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['username'])){
			$error[] = 'Username provided is already in use.';
		}

	}

	if(strlen($_POST['password']) < 3){
		$error[] = 'Password is too short.';
	}

	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirm password is too short.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Passwords do not match.';
	}

	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} else {
		$stmt = $db->prepare('SELECT email FROM members WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['email'])){
			$error[] = 'Email is already in use.';
		}

	}


	if(!isset($error)){

		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		$activation = md5(uniqid(rand(),true));

		try {

			$stmt = $db->prepare('INSERT INTO members (username,password,email,active) VALUES (:username, :password, :email, :active)');
			$stmt->execute(array(
				':username' => $_POST['username'],
				':password' => $hashedpassword,
				':email' => $_POST['email'],
				':active' => $activation
			));
			$id = $db->lastInsertId('memberID');

			$to = $_POST['email'];
			$subject = "Confirm your registration to Bikram Sandhu's website!";
			$body = "<p>We have received your registration credentials. Please refer to the below steps to activate your registration profile!</p>
			<p>Please click on this link to proceed with activation: <a href='".DIR."activate.php?x=$id&y=$activation'>".DIR."activate.php?x=$id&y=$activation</a></p>
			<p>Thanks, Bikramjeet S Sandhu</p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			header('Location: index.php?action=joined');
			exit;

		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}
$title = 'Welcome to Bikram Sandhus Login Page';

require('layout/header.php');
?>

<img src="http://archives.njit.edu/vhlib/images/njit_logo.gif" alt="NJIT logo">
<center><h1 style="color:red"><strong> Welcome to Bikram Sandhu's Website </strong></h1></center>
<div class="container">

	<div class="row">


			<form role="form" method="post" action="" autocomplete="off">
				<center><h2 style="color:red">Please sign up to our website today!</h2></center>
				<center><p style="color:white">Do you already have an account? Click here to <input type="button" value="Login"
				onclick="window.location.href='http://web.njit.edu/~bss46/finalProject/login.php'"/></p></center>



				<?php
				if(isset($error)){
					foreach($error as $error){
						echo '<center><p style="color:#4FFF33" class="bg-danger">'.$error.'</p></center>';
					}
				}

				if(isset($_GET['action']) && $_GET['action'] == 'joined'){
					echo '<center><h3 style="color:#4FFF33"> Registration almost complete... please check your email to activate your account</h3></center>';
				}
				?>

				<div class="form-group">
					<center><input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="3"></center>
					<br><br>
				</div>
				<div class="form-group">
					<center><input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" value="<?php if(isset($error)){ echo $_POST['email']; } ?>" tabindex="4"></center>
					<br><br>
				</div>

				<div class="row">
						<div class="form-group">
							<center><input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="5"></center>
							<br><br>
						</div>
					</div>
						<div class="form-group">
							<center><input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirm Password" tabindex="6"></center>
							<br><br>
						</div>
					</div>
				</div>

				<div class="row">
					<center><input type="submit" name="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="7"></center>
					<br><br>
				</div>
			</form>
		</div>
	</div>

</div>

<?php
require('layout/footer.php');
?>
