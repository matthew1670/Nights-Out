<?php 
// AddVenue.php

session_start();

//SETTING ALL VARIABLES
$id = $_POST['id'];
$review = $_POST['review'];
$user = $_SESSION['granted'];

$conn  = new PDO ("mysql:host=localhost;dbname=mwood;", "mwood", "einiekeu");
$query = "INSERT INTO nightsout_reviews (venueID, username, review,date)
								VALUES (:venueID,:username,:review, NOW())";
$sth = $conn->prepare($query);
$vars = array(
				':venueID' => $id,
				':username' => $user,
				':review' => $review
			 );

if ($sth->execute($vars)){
 echo "Your Review Has Been Submited";
}
else{
	print_r($conn->errorinfo());
}
?>