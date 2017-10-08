<?php
	$conn = new mysqli("localhost", "davidquezada", "davidquezada", "latert");
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT * FROM listanegra Where id=".$_GET['id'];
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	    	
	    	echo "<img height='40%' width='40%' src='data:image;base64,".$row['imagen']."'>  ";
	    	
	    }
	} 
	$conn->close();
?>