<?php 
$id = $_POST["id"];
$conn  = new PDO ("mysql:host=localhost;dbname=mwood;", "mwood", "einiekeu");
$query = "UPDATE nightsout_venues SET recommendation = recommendation+1 WHERE ID =". $id ;
if ($conn->query($query)){
	$query_2 = "SELECT * FROM nightsout_venues WHERE ID =". $id;
	if ($result=$conn->query($query_2)){
	$row = $result->fetch(PDO::FETCH_ASSOC);
	echo json_encode($row);
	}
}
else{
	echo "It Didnt Work";
}
?>