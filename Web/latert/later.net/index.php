<?php
$servername = "localhost";
$username = "davidquezada";
$password = "davidquezada";
$dbname = "latert";
echo "<html><head><link rel='stylesheet' type='text/css' href='index.css'></head>";
echo "<br>Paremetro p1 ingresado: ".$_POST['p1'];
echo "<br>Paremetro p2 ingresado: ".$_POST['p2'];
echo "<br>Paremetro p3 ingresado: ".$_GET['p3'];
echo "<br>Paremetro p4 ingresado: ".$_GET['p4'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO placa (placa, comentario)
VALUES ('".$_GET['p3']."', '".$_GET['p4']."')";

if ($conn->query($sql) === TRUE) {
    echo "El registro fue agregado correctamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$sql = "SELECT placa, comentario FROM placa";
$result = $conn->query($sql);
echo "<table><tr><td>Placa</td><td>Comentario</td></tr>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><th>Placa: " . $row["placa"]. " - </th><th>Comentario: " . $row["comentario"]."</th></tr>";
    }
} else {
    echo "0 results";
}
echo "</table>";

echo "</html>";

$conn->close();
?>