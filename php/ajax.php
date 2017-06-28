<?php 
$type = $_GET["search"];
$conn  = new PDO ("mysql:host=localhost;dbname=mwood;", "mwood", "einiekeu");
$query = "SELECT * FROM nightsout_venues WHERE type = '" .$type . "' OR name LIKE '" . $type . "%'";
$result = $conn->query($query);
while($row = $result->fetch()){
	echo "<p class='Venues' data-id='". $row["ID"] ."'>". $row["name"]. " - " . $row["type"] ."</p>";
}
?>