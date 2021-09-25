<?php
$servername = 'localhost';
$username = 'root';
$password = 'afsdj;kl';
$dbname = 'stickers';

$conStr = sprintf("mysql:host=%s;dbname=%s", $servername, $dbname);

try{
	$pdo = new PDO($conStr, $username, $password);
}
catch(PDOException $e){
	echo $e->getMessage();
}

$sql = "SELECT productName FROM products WHERE productName = \"red sticker\" ";



try {
	foreach($pdo->query($sql) as $row) {
		print $row['productName'] . "\t";
	}
}
catch (PDOException $e) {
	echo 'no';
}


?>






