<?php
	$servername = "localhost";
	$username = "davidquezada";
	$password = "davidquezada";
	$dbname = "latert";


	//if(isset($POST["Token"])){
		$token = $_POST["fcm_token"];
		$conn = new mysqli($servername, $username, $password, $dbname);
		$query = "INSERT INTO users (Token) Values ('".$token."')" ;
		
		if ($conn->query($query) === TRUE) {
		    echo "El registro fue agregado correctamente";
		} else {
		    echo "Error: " . $query . "<br>" . $conn->error;
		}

		$conn->close();
	//}
?>