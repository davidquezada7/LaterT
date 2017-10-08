<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: x-requested-with, Content-Type, origin, authorization, accept, client-security-token");

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

$sql = "DELETE FROM alespis WHERE id=".$_GET["id"];
//echo $sql;
$result = $conn->query($sql);

//echo "<script> $('.listanegralist').click(function() {$.get( 'http://latert.net/borrarListaNegra.php?id='+this.id , function( data ) {$('#listanegradata').html(data);});});</script>";

$sql = "SELECT id,name,address,lng,lat,activa FROM `alespis` WHERE 1 ORDER BY(id)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>" . $row["address"]. "</td><td>" . $row["lng"]."</td><td>".$row["lat"]."</td><td>".$row["activa"]."</td>"
		."<td><i id=".$row["id"]." class='fa fa-times-circle listanegralist' aria-hidden='true'></i></td>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>