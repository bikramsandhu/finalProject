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

<div class="container">

	<div class="row">

<?php
$stmt = "SELECT * FROM members WHERE username = '".$_SESSION['username']."'";
foreach ($db->query($stmt) as $row) {
  echo '<div style="display:table;width:400px;height:60px;">';
  echo '<div style="padding-center:10px;display:table-cell;height:30px;color:red">Username:' . $row['username'];
  echo '<br><br>Email Address: ' . $row['email'] . '</div>';
  echo '</div>';
}
?>


		</div>
	</div>
</div>
<br>
<div class="container">
  <div class="row">
      <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="myFile">
        <br><br><br>
        <center><input type="submit" value="Change User Profile Pic">
      </form>
    </div>
  </div>
</div>
