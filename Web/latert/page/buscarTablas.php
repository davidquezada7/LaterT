﻿<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <!-- <meta charset="utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0" />-->
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<title>LaterT</title>
	<style>
	  /* Always set the map height explicitly to define the size of the div
	   * element that contains the map. */
	  #map {
		height: 100%;
	  }
	  /* Optional: Makes the sample page fill the window. */
	  html, body {
		height: 100%;
		margin: 0;
		padding: 0;
	  }
	</style>
	
    <title>Latert Camaras Fijas</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" />
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	
	<!--<script type="text/javascript" 
           src="http://maps.google.com/maps/api/js?sensor=false"></script>-->


<script>
		
		var placa="";
		
		var customLabel = {
			raspberry: {
			label: 'A'
			}
		};

        function initMap() {
			var map = new google.maps.Map(document.getElementById('map'), {
			  center: new google.maps.LatLng(14.599781, -90.510182),
			  zoom: 15
			});
			
			var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
			downloadUrl('xml/getAvistadosXml.php?'+"placa="+placa, function(data) {
				var xml = data.responseXML;
				var markers = xml.documentElement.getElementsByTagName('marker');
				Array.prototype.forEach.call(markers, function(markerElem) {
				  var id = markerElem.getAttribute('id');
				  var fecha = markerElem.getAttribute('date');
				  var name = markerElem.getAttribute('name');
				  var address = markerElem.getAttribute('address');
				  var type = markerElem.getAttribute('type');
				  var point = new google.maps.LatLng(
					  parseFloat(markerElem.getAttribute('lat')),
					  parseFloat(markerElem.getAttribute('lng')));

				  var infowincontent = document.createElement('div');
				  var strong = document.createElement('strong');
				  strong.textContent = name
				  infowincontent.appendChild(strong);
				  infowincontent.appendChild(document.createElement('br'));

				  var text = document.createElement('text');
				  text.textContent = address + " fecha: [" + fecha+" ]"
				  infowincontent.appendChild(text);
				  var icon = customLabel[type]|| {};
				  var marker = new google.maps.Marker({
					map: map,
					position: point,
					label: icon.label+ id
				  });
				  marker.addListener('click', function() {
					infoWindow.setContent(infowincontent);
					infoWindow.open(map, marker);
				  });
				});
          });
        }



      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}

	$(document).ready(function(){
		
		 $('#dataTables-example').dataTable();

		$(".comboPlaca").click(function() {
			//alert("hola mundo"+this.id);
			placa=this.id;
			initMap();
		});
		
	
		$(".ui-widget").hide();
	
		$.get( "alespis/getListaAlespis.php", function( data ) {
			$("#listanegradata").html(data);
			$(".listanegralist").click(function() {
			$.get( "alespis/borrarListaAlespis.php?id="+this.id , function( data ) {
					$("#listanegradata").html(data);
				});
			});
		}); 
		
		$("#insertarbtn").click(function() {

		$("#dialog").dialog({
		  width: 900
		});
	
		$(".ui-dialog").show();
		});
	
	
		$("#insertarListaNegra").click(function() {
			$.get( "alespis/insertarListaAlespis.php?"+$("#formlistanegra").serialize() , function( data ) {
				$("#listanegradata").html(data);
				$(".listanegralist").click(function() {
					$.get( "alespis/borrarListaAlespis.php?id="+this.id , function( data ) {
						$("#listanegradata").html(data);
				
					});
				});
				$(".ui-dialog").hide();
			});

		});

	});

  

</script>
   
</head>


<body>
	<div id="dialog" title="Ingresa una nueva c&aacute;mara" hidden="hidden">
		<form id="formlistanegra">


		<label>Nombre</label>
		<input type="text" id="nombretxt" name="nombretxt" placeholder="Nombre"/><br />
		<label>Direccion </label>
		<input type="text" id="direcciontxt" name="direcciontxt" placeholder="Direccion"/><br />
		<label>Latitud</label>
		<input type="text" id="latitudtxt" name="latitudtxt" placeholder="00.000000"/><br />
		<label>Longitud</label>
		<input type="text" id="longitudtxt" name="longitudtxt" placeholder="00.000000"/><br />
		

		<a id="insertarListaNegra" class="btn btn-danger square-btn-adjust">Insertar</a> 
		</form>
	</div>

    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html"></a> 
            </div>
			<div style="color: white; padding: 15px 50px 5px 50px; float: right; font-size: 16px;">  
				<a href="../login.php" class="btn btn-danger square-btn-adjust">Logout</a> 
			</div>
        </nav>   
		<!-- /. NAV TOP  -->
		<nav class="navbar-default navbar-side" role="navigation">
			<div class="sidebar-collapse">
				<ul class="nav" id="main-menu">
					<li class="text-center">
						<img src="assets/img/find_user.png" class="user-image img-responsive"/>
					</li>
					
					<!-- DASHBOARD-->	
					<li>
						<a href="index.html"><i class="fa fa-table fa-3x"></i> Dashboard </a>
					</li>
					<!-- LISTA NEGRA-->
					<li>
						<a href="listanegra.html"><i class="fa fa-bars fa-3x"></i> Lista Negra</a>
					</li>
					<!-- ALESPIS-->	
					<li>
						<a href="alespis.html"><i class="fa fa-desktop fa-3x"></i> Alespis</a>
					</li>
					<!-- BUSQUEDA DE PLACAS-->	
					<li>
						<a class="active-menu" href="#"><i class="fa fa-sitemap fa-3x"></i> Busqueda de Placas<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="buscarMapa.php">Buscar en mapa</a>
							</li>
							<li>
								<a class="active-menu" href="buscarTablas.php">Buscar en tablas</a>
							</li>
						</ul>
					</li> 
				</ul>
			</div>
		</nav>
        <!-- /. NAV SIDE  -->
		<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h1>Busqueda de Placas Detectadas</h1>   
                        <h5>En search puedes ingresra un filtro para obtener resultados</h5>
                       
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
               
				<div class="row">
					<div class="col-md-12">
						<!-- Advanced Tables -->
						<div class="panel panel-default">
							<div class="panel-heading">
								 Todos las placas detectadas por Alespis
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th>Placa</th>
												<th>Alespi</th>
												<th>Fecha</th>
												<th>Direcci&oacute;n</th>
												<th>Latitud</th>
												<th>Longitud</th>
											</tr>
										</thead>
										<tbody>
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
												$sql ="SELECT placa,alespi,fecha,address,lat,lng FROM avistados INNER JOIN alespis ON ( name = alespi ) ORDER BY fecha DESC";
												$result = $conn->query($sql);
												if ($result->num_rows > 0) {
												// output data of each row
													
													while($row = $result->fetch_assoc()) {
														echo "<tr> <td>".$row['placa']." </td> <td>".$row['alespi']." </td> <td>".$row['fecha']." </td> <td>".$row['address']." </td> <td>".$row['lat']." </td> <td>".$row['lng']." </td> </tr>";
														

													}
													
												} else {
														echo "0 results";
												}
												
												$conn->close();
											?>	
										</tbody>
									</table>
								</div>
								
							</div>
						</div>
						<!--End Advanced Tables -->
					</div>
				</div>
              
			</div>
               
		</div>
	</div>
         
	<!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
	<!-- CUSTOM SCRIPTS -->
	<script src="assets/js/custom.js"></script>  
    
    
	<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAsIfIatgwUtPfQJoM4JEUN1nlph_9vEcE&callback=initMap">
    </script>
	
</body>
</html>

