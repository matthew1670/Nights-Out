<?php
//RETRIVING REVIEWS
$ID = $_GET['id'];
$conn  = new PDO ("mysql:host=localhost;dbname=mwood;", "mwood", "einiekeu");

$query = "SELECT * FROM nightsout_reviews WHERE venueID = $ID AND approved = 1 AND date >= DATE_SUB(NOW(),INTERVAL 3 YEAR) ORDER BY date DESC";
$result = $conn->query($query);
$encode = array();
while($row = $result->fetch(PDO::FETCH_ASSOC)){
	$date = date_create($row["date"]);
	$datefommatted ="Reiew Submitted on " . date_format($date, "l F jS") . " at " . date_format($date, "h:i A");
	
	$new = array(
		'review' => $row['review'],
		'username' => $row['username'],
		'date' => $datefommatted
	);
	
	$encode[] = $new;
}

echo json_encode($encode);
?>