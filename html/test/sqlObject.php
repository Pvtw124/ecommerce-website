<?php

class MySql {

	const host = 'localhost';
	const database = 'electronics';
	const user = 'root';
	const password = 'afsdj;kl';

	private $pdo = null;

	public function construct() {
		//open connection to MySQL
		$conStr = sprintf("mysql:host=%s;dbname=%s", self::host, self::database);
		try {
			$this->pdo = new PDO($conStr, self::user, self::password);
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
		echo "<p>Connection to MySQL established...</p>";
	}

	public function destruct() {
		//close connection to MySQL
	$this->pdo = null;
	echo "<p>Disconnected from MySQL...</p>";
	}
}


 

 






