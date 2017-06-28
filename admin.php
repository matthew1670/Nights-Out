<!DOCTYPE HTML>
<?php 
session_start();
$conn  = new PDO ("mysql:host=localhost;dbname=mwood;", "mwood", "einiekeu");
if ($_SESSION["admin"] = 0){
		header("Location: ../index.php");
}
$query = "SELECT * FROM nightsout_reviews Where approved = 0 ORDER BY date DESC";
$result = $conn->query($query);
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">	<title>Nights Out - Home</title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
	<script>
$( document ).ready(function(){
			$("a.ADD").on("click", function(e){
				console.log("test");
				e.preventDefault();
				var id = $(this).data("id");
				var review = $('div[data-value="'+id+'"]');
				$.ajax({
					url:"php/approve.php",
					method:"GET",
					data:{"id":id}	
				}).done(function(data){
					review.hide("slow");
				})
			});
			$("a.DELETE").on("click", function(e){
				e.preventDefault();
				var id = $(this).data("id");
				var review = $('div[data-value="'+id+'"]');
				$.ajax({
					url:"php/delete.php",
					method:"GET",
					data:{"id":id}
				}).done(function(data){
					review.hide("slow");
					console.log(data);
				})
			});
			
		});
	</script>
</head>
<body class="container">
	<div class="row bg-primary">
	
	<!-- Loged in as -->
		<div class="col xs-12 col-sm-2 col-md-4 col-sm-push-10 text-block">
		<i class="fa fa-user"></i>
			You Are Logged in as <br/> <?php echo $_SESSION["granted"] ?><br/>
			<?php 
			if (isset($_SESSION["granted"])){
				echo "<a href='index.php' class='btn btn-warning'>Go Home</a>";
			}
			?>
		</div>
		<!-- Title Section -->
		<div class="col-xs-12 col-sm-10 col-md-8 text-center col-sm-pull-2">
			<h1>Welcome to NightsOut</h1>
		</div>
	</div>	
<?php 
while($row = $result->fetch(PDO::FETCH_ASSOC)){
	$date = date_create($row["date"]);
	$datefommatted ="Reiew Submitted on " . date_format($date, "l F jS") . " at " . date_format($date, "h:i A");
?>
	<div class='row' id='review-block' data-value="<?php echo $row['ID'] ?>">
		<div class='row' id='review'>
			<div class='col-xs-9'>
				<?php echo $row["review"]?>
			</div>
			<div class='col-xs-3'>
				<p class="admin_options">
					<a href="" class="ADD" data-id="<?php echo $row['ID'] ?>">Approve</a> / <a href="" class="DELETE" data-id="<?php echo $row['ID'] ?>">Delete</a>
				</p>
			</div>
		</div>	
		<div class='row col-xs-12'>
			<p>submitted by <?php echo $row["username"]?>
			<br/><?php echo $datefommatted ?>
		</div>
	 </div>

<?php 
}//End Of While Loop
?>
</body>
</html>

