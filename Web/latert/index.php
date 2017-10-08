<?php
	include 'send.php';
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: PUT, GET, POST");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

	$servername = "localhost";
	$username = "davidquezada";
	$password = "davidquezada";
	$dbname = "latert";
	echo "<html><head><link rel='stylesheet' type='text/css' href='index.css'></head>";
	//echo "<br>Paremetro p1 ingresado: ".$_POST['p1'];
	//echo "<br>Paremetro p2 ingresado: ".$_POST['p2'];
	echo "<br>Numero de Placa ingresada: ".$_GET['p3'];
	echo "<br>Nombre de dispositivo ingresado: ".$_GET['p4'];

	$numPlaca = $_GET['p3'];
	$numAlespi = $_GET['p4'];
	$latitud = $_GET['p5'];
	$longitud = $_GET['p6'];

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} else{

		
		if($numPlaca != '' and $numAlespi !=''){

			if ($latitud != '' and $longitud !='') {
				//INSERTAR PLACA ENVIADA POR APLICACION
				$sql = "INSERT INTO avistados (placa, alespi,latitud,longitud) VALUES ('".$numPlaca."', '".$numAlespi."', ".$latitud.", ".$longitud.")";

				if ($conn->query($sql) === TRUE) {
				    //echo "El registro fue agregado correctamente";
				} else {
				    echo "Error: " . $sql . "<br>" . $conn->error;
				}
			}else{
				//INSERTAR PLACA ENVIADA POR ALESPI
				$sql = "INSERT INTO avistados (placa, alespi) VALUES ('".$numPlaca."', '".$numAlespi."')";

				if ($conn->query($sql) === TRUE) {
				    //echo "El registro fue agregado correctamente";
				} else {
				    echo "Error: " . $sql . "<br>" . $conn->error;
				}
			}
			
			//CONSULTA NOTIFICAR
			$sql = "SELECT Count(*) FROM listanegra WHERE placa = '".$numPlaca."'";
			$result = $conn->query($sql);
			$row = $result->fetch_row();
			$value = $row[0];
			//printf("este es el valor>:".$value);

			//NOTIFICAR SI
			if($value>0){
				sendBroadCast($numPlaca);
			}
		}
			
		
		

		//MOSTRAR TODOS LOS AVISTAMIENTOS
		$sql = "SELECT placa, alespi FROM avistados";
		$result = $conn->query($sql);
		echo "<table><tr><td>Placa</td><td>Dispositivo</td></tr>";
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		        echo "<tr><th> " . $row["placa"]. " - </th><th> " . $row["alespi"]."</th></tr>";
		    }
		} else {
		    echo "0 results";
		}
		echo "</table>";

		echo "</html>";

		}

	$conn->close();
?>