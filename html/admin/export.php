<?php
session_start();	
$_SESSION['Cart-num']=0;
//define constants
define('URL', 'https://stickersformentalhealth.com/');	
define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', 'afsdj;kl');
define('DB_NAME', 'stickers');
$conStr = sprintf("mysql:host=%s;dbname=%s", HOST, DB_NAME);
try { $conn = new PDO($conStr, USERNAME, PASSWORD); }
catch (PDOException $e) { echo $e->getMessage(); }
//check whether user is logged in
if(!isset($_SESSION['user'])){
    //user is not logged in
    $_SESSION['no-user'] = "<div class='error'>Please login to access Admin Controls</div>";
    header("location:".URL."admin/login.php");
}	
function addRelation($name, $xml, $conn){
    $relation = $xml->addChild("$name");
    $statement = $conn->query("SELECT * FROM $name");
    $error = $conn->errorCode();
    //remove 's' from name if ends with 's'
    if(substr($name, 0, -1) == 's') {
        $tuple_name = substr($name, 0, -1); 
    }
    else $tuple_name = $name;
    while($row = $statement->fetch(PDO::FETCH_ASSOC)){
        $tuple = $relation->addChild("$tuple_name");
        foreach ($row as $key => $value) {
        $tuple->addChild($key, $value);
        }
    }
}
function formatXml($simpleXMLElement)
{
    $xmlDocument = new DOMDocument('1.0');
    $xmlDocument->preserveWhiteSpace = false;
    $xmlDocument->formatOutput = true;
    $xmlDocument->loadXML($simpleXMLElement->asXML());
    return $xmlDocument->saveXML();
}
$xml = new SimpleXMLElement('<stickers/>');
addRelation('Admins', $xml, $conn);
addRelation('Products', $xml, $conn);
addRelation('Categories', $xml, $conn);
addRelation('Orders', $xml, $conn);
addRelation('Order_Item', $xml, $conn);
$filename="stickers-database.xml";
header("Content-disposition: attachment;filename=$filename");
echo formatXML($xml);
