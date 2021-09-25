<?php
	//start session
	//deleted this stuff for GitHub
	session_start();	
        $_SESSION['Cart-num']=0;
	//define constants
	define('URL', '');	
	define('HOST', '');
	define('USERNAME', '');
	define('PASSWORD', '');
	define('DB_NAME', '');
	$conStr = sprintf("mysql:host=%s;dbname=%s", HOST, DB_NAME);
	try { $conn = new PDO($conStr, USERNAME, PASSWORD); }
	catch (PDOException $e) { echo $e->getMessage(); }
?>	
