<?php
$conn  = new PDO ("mysql:host=localhost;dbname=mwood;", "mwood", "einiekeu");
$type = $_POST["VenueType"];
$query = "SELECT * FROM nightsout_venues WHERE type = '" .$type . "' OR name LIKE '" . $type . "%'";
$result = $conn->query($query);
while($row = $result->fetch(PDO::FETCH_ASSOC)){
echo "<div class='col-xs-12 venue' style='border-bottom:1px solid #ccc' data-id='". $row["ID"] .">";
echo " <h3> ". $row['name'];
//CHECK FOR recommendation
		if ($row["recommendation"] == true){
		echo '<span class="glyphicon glyphicon-star pull-right"></span>';
		}
		else {
		echo '<span data-value=' . $row["ID"] . ' class="glyphicon glyphicon-star-empty pull-right"></span>';
		} 
echo "<h3>";
echo "<br/>";
echo $row['description'];
echo "</div>";
}
?>