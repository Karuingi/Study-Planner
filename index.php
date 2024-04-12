<?php
session_start();
error_reporting(0);
include('includes/config.php');


?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<!-- Defines the viewport properties for the document, affecting how the page is displayed on different devices. -->
		<meta name="description" content="">
		<meta name="author" content="">
	    <meta name="robots" content="all">

	    <title>Study Planner Home Page</title>
	    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
	    
	    <!-- Customizable CSS -->
	    
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="assets/images/favicon.ico">
		<!-- Define css style -->
		<style>
        body.cnt-home {
            background-color: antiquewhite;
        }
    </style>

	</head>
    <body class="cnt-home">
	
		
	
<header class="header-style-1">
<?php include('includes/top-header.php');?>
<?php include('includes/main-header.php');?>
<?php include('includes/menu-bar.php');?>
</header>

<div class="body-content outer-top-xs" id="top-banner-and-menu">
	<div class="container">
		<div class="furniture-container homepage-container">
		<div class="row">
		
			<div class="col-xs-12 col-sm-12 col-md-3 sidebar">
	<?php include('includes/side-menu.php');?>
			</div><!-- /.sidemenu-holder -->	
			

			
		</div>

							</div>
		</section>
</div>
</div>
<footer>
<?php include('includes/footer.php');?>
</footer>
	
</body>
</html>