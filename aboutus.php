<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_GET['action']) && $_GET['action']=="add"){
	$id=intval($_GET['id']);
	if(isset($_SESSION['cart'][$id])){
		$_SESSION['cart'][$id]['quantity']++;
	}else{
		$sql_p="SELECT * FROM products WHERE id={$id}";
		$query_p=mysqli_query($con,$sql_p);
		if(mysqli_num_rows($query_p)!=0){
			$row_p=mysqli_fetch_array($query_p);
			$_SESSION['cart'][$row_p['id']]=array("quantity" => 1, "price" => $row_p['productPrice']);
			header('location:index.php');
		}else{
			$message="Product ID is invalid";
		}
	}
}


?>
<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $contactNumber = mysqli_real_escape_string($con, $_POST['contactNumber']);
    $message = mysqli_real_escape_string($con, $_POST['message']);
    $postingDate = date('Y-m-d H:i:s'); // Capture current date and time

    // Insert data into the database
    $query = "INSERT INTO ydcs_contactusquery (name, EmailId, ContactNumber, Message, PostingDate, status) 
              VALUES ('$name', '$email', '$contactNumber', '$message', '$postingDate', 1)";
    
    if (mysqli_query($con, $query)) {
        $successMessage = "Thank you! Your message has been submitted.";
    } else {
        $errorMessage = "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="keywords" content="">
<meta name="description" content="">
<title>Yummy Delights CakeShop</title>
<!--Bootstrap -->
<link rel="stylesheet" href="assets2/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="assets2/css/style.css" type="text/css">
<link rel="stylesheet" href="assets2/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets2/css/owl.transitions.css" type="text/css">
<link href="assets2/css/slick.css" rel="stylesheet">
<link href="assets2/css/bootstrap-slider.min.css" rel="stylesheet">
<link href="assets2/css/font-awesome.min.css" rel="stylesheet">

<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets2/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets2/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets2/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets2/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="cakeshoplogo.jpg">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
<!-- CSS -->
<link href="style.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
<link href='files/dist/themes/fontawesome-stars.css' rel='stylesheet' type='text/css'>
   <!-- Bootstrap Core CSS -->
	    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

	    <!-- Customizable CSS -->
	    <link rel="stylesheet" href="assets/css/main.css">
	    <link rel="stylesheet" href="assets/css/green.css">
	    <link rel="stylesheet" href="assets/css/owl.carousel.css">
		<link rel="stylesheet" href="assets/css/owl.transitions.css">
		<!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
		<link href="assets/css/lightbox.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/animate.min.css">
		<link rel="stylesheet" href="assets/css/rateit.css">
		<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">

		<!-- Demo Purpose Only. Should be removed in production -->
		<link rel="stylesheet" href="assets/css/config.css">

		<link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
		<link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
		<link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
		<link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
		<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">
		<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>

<!-- Script -->
<script src="jquery-3.0.0.js" type="text/javascript"></script>
<script src="files/dist/jquery.barrating.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
    $('.rating').barrating({
        theme: 'fontawesome-stars',
        onSelect: function(value, text, event) {

            // Get element id by data-id attribute
            var el = this;
            var el_id = el.$elem.data('id');

            // rating was selected by a user
            if (typeof(event) !== 'undefined') {

                var split_id = el_id.split("_");

                var postid = split_id[1];  // postid

                // AJAX Request
                $.ajax({
                    url: 'rating_ajax.php',
                    type: 'post',
                    data: {postid:postid,rating:value},
                    dataType: 'json',
                    success: function(data){
                        // Update average
                        var average = data['averageRating'];
                        $('#avgrating_'+postid).text(average);
                    }
                });
            }
        }
    });
});
 {
            background-image: url('cake_background.jpg');
            background-size: cover; /* Cover the entire page */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent tiling */
        }
</script>
</head>
<body>
<header class="header-style-1">
<?php include('includes/top-header.php');?>
<?php include('includes/main-header.php');?>
<?php include('includes/menu-bar.php');?>
</header>
	<div style="background-image: url('cake_background.jpg'); background-size: cover; background-position: center; padding: 50px 0; background-attachment: fixed;">
    <div class="container my-5" style="background-color: rgba(255, 255, 255, 0.9); border-radius: 15px; padding: 30px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <h1 class="text-center" style="color: #6f42c1; font-family: 'Playfair Display', serif; font-weight: bold;">CakeShop Owner</h1>

       <div class="about-us-content text-center">
           
           <img src="owner.jpg" class="rounded-circle img-fluid my-3" alt="About Us Image" style="width: 450px; height: 450px; object-fit: cover;">
            <br><br>
            
            
            
<h2 class="my-3" style="color: #6f42c1; font-family: 'Playfair Display', serif;">Welcome to Yummy Delights Cake Shop</h2>
<p style="font-size: 1.5rem; color: #555;">Founded in 2024 by Osman Gani Mridul, Yummy Delights Cake Shop is more than just a bakery—it's a haven for cake lovers who seek the perfect blend of taste and artistry. With every cake we bake, our mission is to spread happiness and joy. Each slice reflects our dedication to crafting cakes that are not only visually stunning but also rich in flavor, promising a delightful experience for all our customers.</p>

<h2 class="my-3" style="color: #6f42c1; font-family: 'Playfair Display', serif;">Our Mission</h2>
<p style="font-size: 1.5rem; color: #555;">At Yummy Delights, we believe that every celebration deserves to be special, and we are committed to making your moments memorable. Whether it’s a birthday, wedding, anniversary, or any other milestone, we bring sweetness and style to every occasion. Our mission is to enhance these moments with cakes that are as exceptional as the events themselves—crafted with passion, attention to detail, and a personal touch.</p>

<h2 class="my-3" style="color: #6f42c1; font-family: 'Playfair Display', serif;">Our Promise</h2>
<p style="font-size: 1.5rem; color: #555;">We pride ourselves on using only the finest, freshest ingredients, carefully selected to ensure that each cake tastes as wonderful as it looks. Our skilled bakers and decorators work tirelessly to turn your vision into a reality, whether you're after a classic flavor or a unique, custom-designed creation. From intricate wedding cakes to fun and vibrant birthday cakes, we guarantee that each piece is a masterpiece of flavor and creativity. Our goal is to exceed your expectations, bringing you back for more with every sweet bite.</p>

        </div>

        <div class="text-center my-5">
            <h3 style="color: #6f42c1; font-family: 'Playfair Display', serif;">Our Location</h3>
            <p style="font-size: 1.2rem; color: #555;">Address: Tongi, Gazipur, Bangladesh</p>
            <div class="embed-responsive embed-responsive-16by9" style="width: 100%; max-width: 100%; margin: 0 auto;">
                <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14031.457955312095!2d90.37!3d23.95!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x5b5f5b5d2c5d8f0e!2sTongi%2C+Gazipur%2C+Bangladesh!5e0!3m2!1sen!2sus!4v1558681857985!5m2!1sen!2sus" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>

 <?php include('includes/footer.php');?>
</body>
</html>

