<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$servername = "localhost";
$username = "davidquezada";
$password = "davidquezada";
$dbname = "latert";



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$sql = "SELECT COUNT(*) as conteo FROM usuarios WHERE userid='".$_GET['user']."' AND password='".$_GET['password']."'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
if ($row["conteo"]>0){
	session_start();

		$_SESSION["conn"] = 1;

	echo "1";
	
	
}
else{
	echo "The password is incorrect, try again";
}



$conn->close();
?>