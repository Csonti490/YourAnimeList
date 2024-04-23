<?php 
	
	$conn = new mysqli("localhost", "team02", "FHD3SzW3yKiQrwW", "team02");
	
	if($conn->connect_error){
		die("Connection failed! ".$conn->connect_error);
	}

?>