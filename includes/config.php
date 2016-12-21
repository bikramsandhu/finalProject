<?php
ob_start();
session_start();

//set timezone
date_default_timezone_set('US/Eastern');

//database login info
define('DBHOST','sql2.njit.edu');
define('DBUSER','bss46');
define('DBPASS','newark123');
define('DBNAME','bss46');

//application address
define('DIR','http://web.njit.edu/~bss46/finalProject/');
define('SITEEMAIL','bss46@njit.edu');

try {

	//create PDO connection
	$db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
	//show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}

//include the user class, pass in the database connection
include('classes/user.php');
include('classes/phpmailer/mail.php');
$user = new User($db);
?>
