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
	
	<div style="background-image: url('cake_background.jpg'); background-size: cover; background-position: center; padding: 50px 0;">
    <div class="container my-5">
        <div style="background-color: rgba(255, 255, 255, 0.9); border-radius: 15px; padding: 30px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <h1 class="text-center" style="color: #6f42c1;">Contact Us</h1>
            <h5 class="text-center" style="color: #ff6f61;">We'd Love to Hear Your Cake Wishes & Suggestions</h5>

            <!-- Display messages -->
<?php if (isset($successMessage)) { ?>
    <div class="alert alert-success">
        <?php echo $successMessage; ?>
    </div>
<?php } ?>

<?php if (isset($errorMessage)) { ?>
    <div class="alert alert-danger">
        <?php echo $errorMessage; ?>
    </div>
<?php } ?>

<!-- Contact form -->
<form action="" method="POST">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control rounded-pill" id="name" name="name" placeholder="Enter your name" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control rounded-pill" id="email" name="email" placeholder="Enter your email" required>
    </div>
    <div class="form-group">
        <label for="contactNumber">Contact Number</label>
        <input type="tel" class="form-control rounded-pill" id="contactNumber" name="contactNumber" required>
    </div>
    <div class="form-group">
        <label for="message">Message</label>
        <textarea class="form-control rounded-pill" id="message" name="message" rows="5" required></textarea>
    </div>
    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary rounded-pill">Submit</button>
    </div>
</form>
            <div class="alert alert-success text-center mt-3" id="alert-box" style="display:none">
                <strong>Your message has been sent successfully!</strong>
            </div>
        </div>
    </div>
</div>

      
<?php include('includes/footer.php');?>

</body>
</html>

