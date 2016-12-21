<?php
require('includes/config.php');

//gets memberid and active keys from url
$memberID = trim($_GET['x']);
$active = trim($_GET['y']);

//checks to make sure the fields arent empty for the user
if(is_numeric($memberID) && !empty($active)){

//update active column to YES where the values match the ones provided in  array
	$stmt = $db->prepare("UPDATE members SET active = 'Yes' WHERE memberID = :memberID AND active = :active");
	$stmt->execute(array(
		':memberID' => $memberID,
		':active' => $active
	));
	//redirect user if row is updated
	
	if($stmt->rowCount() == 1){

		header('Location: login.php?action=active');
		exit;

	} else {
		echo "Your account could not be activated.";
	}

}
?>
