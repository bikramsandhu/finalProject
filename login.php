<?php

require_once('includes/config.php');

//checks if already logged in, if so then go to homepage
if( $user->is_logged_in() ){ header('Location: index.php'); }

//processes the login info from form
if(isset($_POST['submit'])){

	$username = $_POST['username'];
	$password = $_POST['password'];

	if($user->login($username,$password)){
		$_SESSION['username'] = $username;
		header('Location: memberpage.php');
		exit;

	} else {
		$error[] = 'Wrong username/password or inactivated account';
	}

}

//page title
$title = 'Login';

require('layout/header.php');
?>
//added logo
<img src="http://archives.njit.edu/vhlib/images/njit_logo.gif" alt="NJIT logo">
<div class="container">

	<div class="row">
			<form role="form" method="post" action="" autocomplete="off">
				<h1 style="color:red"><center>Please Login</center></h2>
				<p><center><a href='./'>Go back home</a></p>

				<?php

				//prints out the errors onto the page, if any
				if(isset($error)){
					foreach($error as $error){
						echo '<center><p style="color:#4FFF33" class="bg-danger">'.$error.'</p></center>';
					}
				}

				//checks the action, and prints the output to the page, uses strategy
				if(isset($_GET['action'])){

					switch ($_GET['action']) {
						case 'active':
							echo '<h2 style="color:#4FFF33" class="bg-success">Your account is now active you may now log in.</h2>';
							break;
						case 'reset':
							echo '<h2 style="color:4FFF33" class="bg-success">Please check your inbox for a reset link.</h2>';
							break;
						case 'resetAccount':
							echo '<h2 style="color:4FFF33" class="bg-success">Password changed, you may now login.</h2>';
							break;
					}

				}


				?>
				//created fields for login
				<div class="form-group">
					<center><input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1"></center>
				</div>
				<br><br>

				<div class="form-group">
					<center><input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="3"></center>
				</div>
				<br><br>

				<div class="row">
						 <a href='reset.php'>Forgot your Password?</a>
					</div>
					<br><br>
				</div>

				<div class="row">
					<center><input type="submit" name="submit" value="Login" class="btn btn-primary btn-block btn-lg" tabindex="5"></center></div>
				</div>
			</form>
		</div>
	</div>



</div>


<?php

require('layout/footer.php');
?>
