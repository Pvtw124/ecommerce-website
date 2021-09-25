<?php
 
error_reporting(E_ALL);
ini_set('display_errors','1');
 
require_once 'sqlObject.php';

$obj = new mySQL();
 
$obj->construct();

$sql = "SELECT * FROM PC";
$result = $obj->query($sql);

print($result)

?>
