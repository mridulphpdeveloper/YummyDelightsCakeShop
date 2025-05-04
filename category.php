<?php
session_start();
error_reporting(0);
include('includes/config.php');
$cid=intval($_GET['cid']);

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
            header('location:my-cart.php');
        }else{
            $message="Product ID is invalid";
        }
    }
}

// Wishlist functionality
if(isset($_GET['pid']) && $_GET['action']=="wishlist" ){
    if(strlen($_SESSION['login'])==0){   
        header('location:login.php');
    }else{
        mysqli_query($con,"insert into wishlist(userId,productId) values('".$_SESSION['id']."','".$_GET['pid']."')");
        echo "<script>alert('Product added to wishlist');</script>";
        header('location:my-wishlist.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="Cake Shop">
    <meta name="author" content="Yummy Delights">
    <meta name="keywords" content="Cake Shop, Online Shopping">
    <meta name="robots" content="all">

    <title>Product Category | Yummy Delights</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    
    <!-- Customizable CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/green.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css">
    <link rel="stylesheet" href="assets/css/lightbox.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/rateit.css">
    <link rel="stylesheet" href="assets/css/bootstrap-select.min.css">

    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Fonts --> 
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

</head>
<body class="cnt-home">

<header class="header-style-1">
    <?php include('includes/top-header.php'); ?>
    <?php include('includes/main-header.php'); ?>
    <?php include('includes/menu-bar.php'); ?>
</header>

<!-- Banner Section -->
<div class="body-content outer-top-xs">
    <div class="container">
        <div class="row outer-bottom-sm">
            <!-- Side Menu -->
            <div class="col-md-3 sidebar">
                <div class="side-menu animate-dropdown outer-bottom-xs">
                    <div class="head"><i class="icon fa fa-align-justify fa-fw"></i>Cake Size</div>
                    <nav class="yamm megamenu-horizontal" role="navigation">
                        <ul class="nav">
                            <?php 
                            $sql=mysqli_query($con,"select id,subcategory from subcategory where categoryid='$cid'");
                            while($row=mysqli_fetch_array($sql)){ ?>
                                <li class="dropdown menu-item">
                                    <a href="sub-category.php?scid=<?php echo $row['id'];?>" class="dropdown-toggle">
                                        <i class="icon fa fa-spoon fa-fw"></i> <?php echo $row['subcategory'];?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <div class="category-carousel hidden-xs">
                    <div class="item">
                        <div class="image">
                            <img src="assets/images/banners/banner1.jpg" alt="" class="img-responsive">
                        </div>
                        <div class="caption vertical-top text-left">
                            <div class="big-text"><br /></div>
                            <?php 
                            $sql=mysqli_query($con,"select categoryName from category where id='$cid'");
                            while($row=mysqli_fetch_array($sql)){ ?>
                                <div class="excerpt hidden-sm hidden-md">
                                    <?php echo htmlentities($row['categoryName']);?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <!-- Product Listing -->
                <div class="search-result-container" style="margin-top:70px;">
                    <div class="tab-pane active" id="grid-container">
                        <div class="category-product inner-top-vs">
                            <div class="row">
                                <?php
                                $ret=mysqli_query($con,"select * from products where category='$cid'");
                                $num=mysqli_num_rows($ret);
                                if($num>0){
                                    while ($row=mysqli_fetch_array($ret)){ ?>
                                        <div class="col-sm-6 col-md-4 wow fadeInUp">
                                            <div class="products">
                                                <div class="product">		
                                                    <div class="product-image">
                                                        <div class="image">
                                                            <a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>">
                                                                <img src="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" alt="" class="img-responsive" style="max-height: 200px; object-fit: cover;">
                                                            </a>
                                                        </div>			                      		   
                                                    </div>

                                                    <div class="product-info text-left" style="margin-top:20px;">
                                                        <h3 class="name">
                                                            <a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>">
                                                                <?php echo htmlentities($row['productName']);?>
                                                            </a>
                                                        </h3>
                                                        <div class="product-price">
                                                            <span class="price">BDT <?php echo htmlentities($row['productPrice']);?></span>
                                                            <span class="price-before-discount">BDT <?php echo htmlentities($row['productPriceBeforeDiscount']);?></span>
                                                        </div>
                                                    </div>

                                                    <!-- Cart and Wishlist Buttons -->
                                                    <div class="cart clearfix animate-effect">
                                                        <div class="action">
                                                            <ul class="list-unstyled">
                                                                <li class="add-cart-button btn-group">
                                                                    
                                                                    <a href="product-details.php?pid=<?php echo $row['id']; ?>" class="lnk btn btn-primary"style="background-color:#FF5733; border-color:#FF5733;">Product View</a>
                                                                    <br>
                                                                    <a href="index.php?page=product&action=add&id=<?php echo $row['id']; ?>" class="lnk btn btn-primary">Add to Cart</a>
                                                                    
                                                                </li>
                                                                <li class="lnk wishlist">
        <a class="btn btn-primary" style="background-color: #FFC300; border-color: #FFC300; font-size: 0.85rem; padding: 6px;" data-toggle="tooltip" data-placement="right" title="Add to Wishlist" href="product-details.php?pid=<?php echo htmlentities($row['id'])?>&&action=wishlist">
    <i class="fa fa-heart"></i>
  </a>
     
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                } else { ?>
                                    <div class="col-sm-6 col-md-4 wow fadeInUp"> 
                                        <h3>No Cake Found</h3>
                                    </div>
                                <?php } ?>	
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include('includes/BDT.-slider.php'); ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<!-- Scripts -->
<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/scripts.js"></script>

</body>
</html>
