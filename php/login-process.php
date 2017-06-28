<?php
error_reporting(E_ALL); 
Session_start();
$password = $_POST["Password"];
$user = $_POST["Username"];

$conn  = new PDO ("mysql:host=localhost;dbname=mwood;", "mwood", "einiekeu");
$query = "SELECT * FROM `nightsout_users` Where Username = :username";
$stmt = $conn->prepare($query);
$stmt->execute(array(
		":username" =>  $user
	));
$row = $stmt->fetch();
if (password_verify($password,$row["Password"]))
{
    $_SESSION["granted"] = $row["Username"];
	if ($row["isadmin"] = 1){
	    $_SESSION["admin"] = 1;
	}
	echo "Login Correct";
}
else{
/* $Query = "INSERT INTO nightsout_users (Username, Password)
								VALUES (:Username,:Password)";
echo $row['Password'];
$stmt2 = $conn->prepare($Query);
$stmt2->execute(array(
		':Username' => $user,
		':Password' => password_hash($password, PASSWORD_DEFAULT)
));
echo "added"; */
}
?>