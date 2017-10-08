<?php
	function sendNotification($tokens,$numPlaca){

		$message = 'La placa no. '.$numPlaca.' ha sido vista';
		$title = 'Alerta';
		$path = 'https://fcm.googleapis.com/fcm/send';
		$serverKey = 'AIzaSyDk-GHQkdURQhPZKFiV48udOgQl4Tt0mXg';

		$headers = array(
				'Authorization:key='.$serverKey,
				'Content-Type:application/json'
			);

		$fields = array('to'=>$tokens,
					'notification'=>array('title'=>$title,'body'=>$message));
		$payload = json_encode($fields);
			
		printf($payload);
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $path);
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
	    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	       

	    $resultado = curl_exec($ch);    
	    curl_close($ch);
	}

	
	/*
	
	*/
	function sendBroadCast($numPlaca){
		$servername = "localhost";
		$username = "davidquezada";
		$password = "davidquezada";
		$dbname = "latert";
		
		$conn = new mysqli($servername, $username, $password, $dbname);
		$sql = " Select Token From users";
		$result = $conn->query($sql);
		
		
		$tokens = array();
		while ($row = $result->fetch_row()) {
			$tokens = $row[0];
			sendNotification($tokens,$numPlaca);
		}
	}
	

	//$row = $result->fetch_row();
	//$tokens = $row[0];
	
    //$conn->close();
   
?>