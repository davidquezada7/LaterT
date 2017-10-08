<?php

include("postfacebook.php");

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


if(isset($_FILES['image'])){
    if (getimagesize($_FILES['image']['tmp_name'])==FALSE) {
                    echo "please select an image";
    }else{
        


        $image= addslashes($_FILES['image']['tmp_name']);
        $name= addslashes($_FILES['image']['name']);
        $image = file_get_contents($image);

        $content= $image;
        $fp = fopen("fotos/".$_POST['placatxt'].".jpg", "w");
        fwrite($fp, $content);
        fclose($fp);

        $image = base64_encode($image);
        //INSERT
        $sql = "INSERT INTO listanegra (placa,propietario,marca,color,modelo,motivo,estado,nombreimagen,imagen) 
                VALUES
                ( '".$_POST["placatxt"]."','".$_POST["propietariotxt"]."','".$_POST["marcatxt"]."', '".$_POST["colortxt"]."','".$_POST["modelotxt"]."','".$_POST["motivotxt"]."','activo','".$name."', '".$image."')";
        echo $sql;
        $result = $conn->query($sql);

        if(isset($_POST['boxfb'])){
            postToFb($_POST["placatxt"],$_POST["comentariostxt"]);
        }else{
            echo "rayos";
        }
    }

}else{
    //INSERT
    $sql = "INSERT INTO listanegra (placa,propietario,marca,color,modelo,motivo,estado) 
    		VALUES
    		('".$_POST["placatxt"]."','".$_POST["propietariotxt"]."','".$_POST["marcatxt"]."', '".$_POST["colortxt"]."','".$_POST["modelotxt"]."','".$_POST["motivotxt"]."','activo')";

    echo $sql;

    $result = $conn->query($sql);
}


$sql = "SELECT * FROM listanegra ORDER BY(id)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    // output data of each row

    while($row = $result->fetch_assoc()) {

        echo "<tr><td>".$row["placa"]."</td><td>" . $row["propietario"]. "</td><td>" . $row["marca"]."</td><td>".$row["color"]."</td><td>".$row["modelo"]."</td><td>".$row["motivo"]."</td><td>".$row["fecha"]."</td><td>".$row["estado"]."</td>"

		."<td><i id=".$row["id"]."  class='fa fa-times-circle listanegralist' aria-hidden='true'></i></td>";

    }

} else {

    echo "0 results";
}





$conn->close();

?>