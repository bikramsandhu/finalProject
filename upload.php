<?php
	define("UPLOAD_DIR", "afs/cad.njit.edu/u/b/s/bss46/public_html/finalProject/UPLOADS/");
	if (!empty($_FILES["myFile"])){
		$myFile = $_FILES["myFile"];
		if($myFile["error"] !== UPLOAD_ERR_OK){
			echo'<center><p style="color:red">An error occured.</p><center>';
			exit;
		}
    // ensure only valid characters are used
		$name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);
		$i = 0;
		$parts = pathinfo($name);
		while (file_exists(UPLOAD_DIR . $name)) {
			$i++;
			$name = $parts["filename"] . "-" . $i ."." . $parts["extension"];
		}
		$success = move_uploaded_file($myFile["tmp_name"], UPLOAD_DIR . $name);
		if (!success){
			echo '<center><p style="color:red">Unable to save file.</p><center>';
			exit;
	}
	chmod(UPLOAD_DIR . $name, 0644);
  header('Location: memberpage.php')
	}
?>
