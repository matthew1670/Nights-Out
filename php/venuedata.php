<?php 
//STARTING SESSION FOR SESSION VARIABLE
	session_start();
//SETTING VARIABLES
	$ID = $_GET['id'];
//CONNECTING TO DATABASE
	$conn  = new PDO ("mysql:host=localhost;dbname=mwood;", "mwood", "einiekeu");
// QUERYING DATABASE
	$query = "SELECT * FROM nightsout_venues WHERE ID = " .$ID . "";
$result = $conn->query($query);
$data = $row = $result->fetch(PDO::FETCH_ASSOC);

//ENCLODING THE DATA TO JSON
echo json_encode($data);
?>