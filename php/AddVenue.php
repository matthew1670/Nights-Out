<?php 
// AddVenue.php

session_start();

//SETTING ALL VARIABLES
$name = $_POST['VenueName'];
$desc = $_POST['VenueDesc'];
$type = $_POST['VenueType'];
$user = $_SESSION["granted"];
$conn  = new PDO ("mysql:host=localhost;dbname=mwood;", "mwood", "einiekeu");

$Query = "INSERT INTO nightsout_venues (name, type, description,username)
								VALUES (:name,:type,:description,:username)";
$sth = $conn->prepare($Query);
$sth->execute(array(
				':name' => $name,
				':type' => $type,
				':description' => $desc,
				':username' => $user
			 ));
?>