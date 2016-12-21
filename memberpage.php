<?php require('includes/config.php');
//checks if logged in, if not then go to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

$title = 'User Profile';

require('layout/header.php');
?>
<img src="http://archives.njit.edu/vhlib/images/njit_logo.gif" alt="NJIT logo">
<div class="container">
<! What we see on the member page>
	<div class="row">
				<center><h1 style="color:red"> User Profile - Welcome user <?php echo $_SESSION['username']; ?></h1></center><br>
				<center><input type="button" value="Log Out" onclick="window.location.href='logout.php'"/></center>
		</div>
	</div>


</div>

<?php
require('layout/footer.php');
?>
