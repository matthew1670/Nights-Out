<?php 
session_start();
$conn  = new PDO ("mysql:host=localhost;dbname=mwood;", "mwood", "einiekeu");
if ($_SESSION["admin"] = 0){
		header("Location: ../index.php");
}
$reviewID = $_GET["id"];
$query = "DELETE FROM nightsout_reviews WHERE ID = :reviewID";
$sth = $conn->prepare($query);
$sth->execute(array(
				':reviewID' => $reviewID
			 ));
			 echo "TEST DELETE";
?>