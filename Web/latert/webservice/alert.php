<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: PUT, GET, POST");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	
	$servername = "localhost";
	$username = "davidquezada";
	$password = "davidquezada";
	$dbname = "latert";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

//DE ALESPIS
	$sql = "SELECT 
				a.placa as plate, propietario, marca, color, modelo, motivo, b.fecha as date, address, lat, lng
			FROM  
				listanegra as a 
			INNER JOIN avistados as b 
				ON (a.placa=b.placa)
			INNER JOIN alespis as al
				ON (al.name=b.alespi)";

	$result = $conn->query($sql);

	$datos = array();
	$datosTemp = array();
	$lista = array();
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {

	    	$datos = array("placa" => $row["plate"],"propietario" => $row["propietario"],"marca" => $row["marca"],"color" => $row["color"],"modelo" => $row["modelo"],"motivo" => $row["motivo"],"fecha" => $row["date"],"lat" => $row["lat"],"lng" => $row["lng"],"direccion" => $row["address"]);
			array_push($lista, $datos);    
	    }
	}
	
//DE APLICACION
	$sql = "SELECT b.placa as numPlaca, propietario, marca, color, modelo, motivo, b.fecha as fechita, latitud, longitud FROM listanegra as a INNER JOIN avistados as b ON (a.placa=b.placa) WHERE alespi = 'Aplicacion'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {

	    	$datos = array("placa" => $row["numPlaca"],"propietario" => $row["propietario"],"marca" => $row["marca"],"color" => $row["color"],"modelo" => $row["modelo"],"motivo" => $row["motivo"],"fecha" => $row["fechita"],"lat" => $row["latitud"],"lng" => $row["longitud"],"direccion" => " ");
			array_push($lista, $datos);    
	    }
	}

	$resultadoJson = array('server_response'=>$lista);
	$payload = json_encode($resultadoJson);
	
	echo $payload;
	$conn->close();

?>