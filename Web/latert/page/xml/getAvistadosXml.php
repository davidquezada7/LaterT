<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: PUT, GET, POST");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	
	$dom = new DOMDocument("1.0");
	$node = $dom->createElement("markers");
	$parnode = $dom->appendChild($node);

	$servername = "localhost";
	$username = "davidquezada";
	$password = "davidquezada";
	$dbname = "latert";

	// Opens a connection to a MySQL server
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		    die("Error al conectarse a la base de datos: " . $conn->connect_error);
	}

	// Select all the rows in the markers table

	$sql = "SELECT name,address,lat,lng,type, GROUP_CONCAT(fecha SEPARATOR ' ]   [ ') as fechita FROM avistados INNER JOIN alespis ON ( name = alespi ) WHERE placa = '".$_GET['placa']."'  
		GROUP BY name,address,lat,lng,type
		ORDER BY (fecha) DESC;";
	
	$result = $conn->query($sql);
	$cont = 1;
	if ($result->num_rows > 0) {
	    header("Content-type: text/xml");
	    while($row = $result->fetch_assoc()) {
	        $node = $dom->createElement("marker");
			$newnode = $parnode->appendChild($node);
			$newnode->setAttribute("id",$cont);
			$newnode->setAttribute("name",$row['name']);
			$newnode->setAttribute("address", $row['address']);
			$newnode->setAttribute("lat", $row['lat']);
			$newnode->setAttribute("lng", $row['lng']);
			$newnode->setAttribute("type", $row['type']);
			$newnode->setAttribute("date",$row['fechita']);
			$cont = $cont + 1;
	    }
	    echo $dom->saveXML();
	}

?>