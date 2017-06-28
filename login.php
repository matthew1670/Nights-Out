<?php 
	session_start();
	if(isset($_SESSION["granted"])){
		session_destroy();
	}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">	
	<title>Nights Out - SignIn</title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script>
$( document ).ready(function(){
			$("#signin-form").on("submit", function(e){
				e.preventDefault();
				$.ajax({
					url:"php/login-process.php",
					method: "POST",
					data:$(this).serialize()
				}).done(function(data){
					$(location).attr('href','index.php');				
				})
				
			});
		});
	</script>
  </head>

  <body>

    <div class="container">
    <form class="form-signin" id="signin-form" Method="POST">
        <h2 class="form-signin-heading">Please sign in</h2>
		<p>For Demo use please use admin and admin</p>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="text" id="Username" class="form-control" placeholder="Username" name="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="Password" class="form-control" placeholder="Password" name="Password" required>
        <input class="btn btn-lg btn-primary" id="signin" type="submit" value="Sign In">
    </form>
    </div> <!-- /container -->
</html>


