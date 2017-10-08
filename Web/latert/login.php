<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<style>
form {
    border: 3px solid #f1f1f1;
	margin: auto;
	width: 30%;
}

input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

#boton {
    background-color: #4db8ff;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 90%;
}

.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

.imgcontainer {
    text-align: center;
    margin: auto;
	width:90%;
}

img.avatar {
    width: 40%;
    border-radius: 5%;
}

.container {
    padding: 16px;
	width:90%;
	margin:auto;
}

span.psw {
    float: right;
    padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }
}

#maincontainer{
	margin: auto;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
$(document).ready(function(){

    $(".ui-widget").hide();

	
	
 $("#boton").click(function() {
 
	 $.get( "http://latert.net/verifyuserdb.php?user="+encodeURIComponent($("#uname").val())+"&password="+encodeURIComponent($("#pass").val()), function( data ) {
	
	 if(data==1){
		  window.location.href = "http://latert.net/page/index.html"; 
	  }
	  else{
		  
		   $(".ui-widget").show();
		   $(".ui-widget").html(data);
		   $(".ui-widget").delay( 1500 ).fadeOut( 400 );
	  }
	});
   }); 
});



</script>

</head>
<body>

<h2></h2>
<div id="maincontainer">
<form>
  <div class="imgcontainer">
    <img src="logo.png" alt="Avatar"  height="200px" width="200px">
  </div>

  <div  class="container">
    <label><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" id="uname" required>

    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" id="pass" required>
        
  
	<div id="boton">Login</boton>
	    
  </div>


</form>
<div class="ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
        <p>
            <span class="ui-icon ui-icon-alert" 
                style="float: left; margin-right: .3em;"></span>
            <strong>Alert:</strong> Sample ui-state-error style.
        </p>
    </div>
</div>
</div>
</body>
</html>