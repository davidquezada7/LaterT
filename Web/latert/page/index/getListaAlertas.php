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


$sql = "SELECT 
	a.placa as plate, propietario, marca, color, modelo, motivo, b.fecha as date, address, lat, lng
	FROM  listanegra as a 
		INNER JOIN avistados as b 
			ON (a.placa=b.placa)
		INNER JOIN alespis as al
			ON (al.name=b.alespi)";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        echo "<tr><td>".$row["plate"]."</td><td>" . $row["propietario"]. "</td><td>" . $row["marca"]."</td><td>".$row["color"]."</td><td>".$row["modelo"]."</td><td>".$row["motivo"]."</td><td>".$row["date"]."</td><td>".$row["lat"]."</td><td>".$row["lng"]."</td><td>".$row["address"]."</td>";

    }
} 

$sql = "SELECT b.placa as numPlaca, propietario, marca, color, modelo, motivo, b.fecha as fechita, latitud, longitud FROM listanegra as a INNER JOIN avistados as b ON (a.placa=b.placa) WHERE alespi = 'Aplicacion'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        echo "<tr><td>".$row["numPlaca"]."</td><td>" . $row["propietario"]. "</td><td>" . $row["marca"]."</td><td>".$row["color"]."</td><td>".$row["modelo"]."</td><td>".$row["motivo"]."</td><td>".$row["fechita"]."</td><td>".$row["latitud"]."</td><td>".$row["longitud"]."</td><td>"."Desconocida"."</td>";

    }
} 

$conn->close();

?>