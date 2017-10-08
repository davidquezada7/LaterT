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
			placa,address,lat,lng,fecha,alespi
		FROM 
			avistados AS a
		INNER JOIN 
			alespis AS al ON ( al.name = a.alespi )";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        echo "<tr class=\"gradeA\"><td>".$row["placa"]."</td><td>" . $row["address"]. "</td><td>" . $row["lat"]."</td><td>".$row["lng"]."</td><td>".$row["fecha"]."</td><td>".$row["alespi"]."</td></tr>";

    }
} else {
    echo "0 results";
}

$conn->close();

?>