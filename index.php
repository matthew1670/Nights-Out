<!doctype html>
<?php 
session_start();
if (!isset($_SESSION["granted"])){
	header('Location:login.php');
}
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
// AJAX CALL TO RETURN VENUES BASSED ON USER INPUT
	$("#search").on("keyup", function() {
	// IF INPUT EMPTY THEN CLEAR SEARCH RESULTS
		if ( !$.trim($(this).val()) ){
			$( "#search-results" ).empty();
		}
	// IF SEARCH  NOT EMPTY THEN RUN AJAX CALL TO PHP/AJAX.PHP USING GET METHOD
		else{
			$.ajax({
			  url: "php/ajax.php",
			  method: "GET",
			  data: { 'search': this.value},
		// WHEN AJAX DONE DISPLAY RESULTS
			}).done(function(data){
			  $( "#search-results" ).html(data);
			// WHEN VENUE IS CLICKED
				$('p, .venue').on('click', function(e) {
			// GRAB VENUE ID
					var id = $(this).data("id");
					e.preventDefault();
			// SEND AJAX REQUEST TO PHP/VENUEDATA.PHP
					$.ajax({
						url:"php/venuedata.php",
						method:"GET",
						datatype: "json",
						data:{'id' : id},
			// WHEN DONE DISPLAY MODAL WITH INFORMATION FROM DATABASE		
					}).done(function(data){
						//Parse JSON Information
						var info = $.parseJSON(data);
						$("#Modal-Title").html(info.name);
						$("#Modal-AddedBy").html(info.username);
						$("#Modal-Desc").html(info.description);
						$("#Modal-Recommended-by").html(info.recommendation);
			// WHEN RECOMEND LINK IS CLICKED
						$("#Modal-Recommended").on("click", function(e){
							e.preventDefault();
							$.ajax({
								url:"php/Recommend.php",
								method:"POST",
								datatype: "json",
								data:{'id' : info.ID}
							}).done(function(data){
								var info2 = $.parseJSON(data);
								$("#Modal-Recommended-by").html(info2.recommendation);
							});
						});
						$('#add_review').on("submit", function(e){
							e.preventDefault();
							var review = $("#textarea_review").val();
 							$.ajax({
								url:"php/AddReview.php",
								method:"POST",
								data:{"review":review, "id":info.ID}
								}).done(function(data){
									$('#add_review').html(data);
									
								});
						});
					});
						
			// RETRIVE ALL REVIEWS FOR SET VENUE
						$.ajax({
							url:"php/retriveReviews.php",
							method:"GET",
							datatype: "json",
							data:{'id' : id},
							}).done(function(data){
								data = $.parseJSON(data);
								$.each(data, function(i){
									var d = data[i].date;
									$('#Review-section').append(
									"<div class='row' id='review-block'>"
									+"<div class='row' id='review'>"
									+"<div class='col-xs-12'>"
									+ data[i].review
									+ "</div>"
									+ "</div>"	
									+ "<div class='row col-xs-12'>"
									+ "<span class='pull-left'>"
									+ d
									+ "</span>"	
									+ "<span class='pull-right'>"
									+ data[i].username
									+ "</span>"
									+ "</div>"
									+ "</div>"
									);
								});
							});
						$('#myModal').modal('show');
						$('#myModal').on('hidden.bs.modal', function (e) {
							$("#Review-section").empty();
							$("#Modal-Title").empty();
							$("#Modal-AddedBy").empty();
							$("#Modal-Desc").empty();
							$("#Modal-Recommended-by").html(0);
							$("#textarea_review").val("");
							$('#add_review').show();
						});
					});
				});
			};
		});
		
		//ADDING A NEW VENUE
				$("#AddVenueForm").on("submit",function(e){
					  e.preventDefault();
						  $.ajax({
						  url:"php/AddVenue.php",
						  method: "POST",
						  data:$(this).serialize(),
						  })
						  .done(function(){
							$('#addform').addClass("added col-xs-12");
							$('#addform').html("ADDED SUCSESSFULLY");
						  })
						  .fail(function() {
							alert( "error" );
						  })
					  }); 
});

</script>
	</head>
<body>

<!-- Main Container Element start-->
<div class="container">
	<div class="row bg-primary">
	
	<!-- Loged in as -->
		<div class="col xs-12 col-sm-2 col-md-4 col-sm-push-10 text-block">
		<i class="fa fa-user"></i>
			You Are Logged in as <br/> <?php echo $_SESSION["granted"] ?><br/>
			<?php 
			if (isset($_SESSION["admin"])){
				echo "<a href='admin.php' class='btn btn-warning'>Admin Area</a>";
			}
			?>
		</div>
		
		<!-- Title Section -->
		<div class="col-xs-12 col-sm-10 col-md-8 text-center col-sm-pull-2">
			<h1>Welcome to NightsOut</h1>
			<small>the number one place to view venues in southampton</small>
		</div>
	</div>	
	<div class="row">
		<div class="col-xs-12 col-sm-6">
		<div class="hidden">
		</div>
			<div id="addform">
			<h2>Want To ADD a Venue?</h2>
			<p>enter the details of the venue bellow... <p>
			<!-- ADD VENUE FORM  -->
			<form action="AddVenue.php" method="POST" name="AddVenueForm" id="AddVenueForm">			
			  <div class="form-group">
				<label for="exampleInputEmail1">Venue Name</label>
				<input type="text" class="form-control" id="VenueName" placeholder="Name" Name="VenueName" required>
			  </div>
			  <div class="form-group">
				<label for="exampleInputEmail1">Venue Description</label>
				<textarea class="form-control" rows="3" id="VenueDesc" Name="VenueDesc" Placeholder="Enter Description Here" required></textarea>
			  </div>
			  <div class="form-group">
				<label for="exampleInputEmail1">Venue Type</label>
				<select class="form-control" id="VenueType" name="VenueType" required>
				  <option>Cafe</option>
				  <option>Club</option>
				  <option>Pub</option>
				</select>
			  </div>
			  <button type="submit" class="btn btn-primary" id="Venue-Submit">Add Venue</button>
			</form>
			</div>
			
			<!-- FORM END -->
	</div>
	<div class="col-sm-6">
		<h2>search</h2>
		<p>Search by Type (Please Enter either bar, Club, cafe)</p>
			<div class="input-group input-group-lg">
				  <span class="input-group-addon">
					<i class="fa fa-search"></i>
				  </span>
				  <input type="text" class="form-control" id="search" placeholder="search" autofocus>
		</div>
		<div id="search-results"></div>
		
</div>		
</div>

		
		
 <!-- Modal Content-->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
		<div class="modal-body">
	<!--TITLE AREA -->
			<div class="row">
				<div class="text-center">
					<h1 id="Modal-Title"> Title </h1>
					<small> Added By <span id="Modal-AddedBy"></span></small>
				</div>
			</div>
			<div class="row">
				<div class="text-center">
					<small> Recomended by  <span id="Modal-Recommended-by"></span> Users </small>
					<a href="#" id="Modal-Recommended"><small> Recomended this venue</small></a>
				</div>
			</div>
	<!--ABOUT AREA -->
			<div class="row">
				<div>
					<h2 class="bg-primary">About</h2>
					<p id="Modal-Desc"></p>
				</div>
			</div>
			</br>
			<div class="row">
				<div class="col-xs-12">
				<form class="form-horizontal" id="add_review">

<div class="form-group">
  <div class="col-xs-12">                     
    <textarea class="form-control" id="textarea_review" name="textarea"></textarea>
  </div>
</div>
<div class="form-group">
  <div class="col-xs-12">                     
    <input type="submit"/>
  </div>
</div>
</form>

				</div>
			</div>
	<!--REVIEWS GO HERE -->
			<div class="row review" id="Review-section">
			</div>
		</div>	
    </div>
  </div>
</div>







</div>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</body>
</html>