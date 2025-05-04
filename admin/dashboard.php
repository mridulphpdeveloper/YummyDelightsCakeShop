<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
} else {
    ?>
    <!doctype html>
    <html lang="en" class="no-js">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="theme-color" content="#3e454c">

        <title>Yummy Delights CakeShop | Admin Dashboard</title>

        <!-- Font awesome -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <!-- Sandstone Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- Bootstrap Datatables -->
        <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
        <!-- Bootstrap social button library -->
        <link rel="stylesheet" href="css/bootstrap-social.css">
        <!-- Bootstrap select -->
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <!-- Bootstrap file input -->
        <link rel="stylesheet" href="css/fileinput.min.css">
        <!-- Awesome Bootstrap checkbox -->
        <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
        <!-- Admin Style -->
        <link rel="stylesheet" href="css/style.css">

        <style>
            .panel-container {
                margin-bottom: 20px;
            }
            .panel-container .panel {
                margin-bottom: 0;
            }
        </style>
    </head>

    <body>
        <?php include('includes/header.php'); ?>

        <div class="ts-main-content">
            <?php include('includes/leftbar.php'); ?>
            <div class="content-wrapper">
                <div class="container-fluid">

                    <h2 class="page-title">Admin Dashboard</h2>

                    <div class="row">
                        <!-- First Row -->
                        <div class="col-md-4 panel-container">
                            <div class="panel panel-default">
                                <div class="panel-body bk-primary text-light">
                                    <div class="stat-panel text-center">
                                        <?php
                                        $sql = "SELECT id FROM users";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $regusers = $query->rowCount();
                                        ?>
                                        <div class="stat-panel-number h1"><?php echo htmlentities($regusers); ?></div>
                                        <div class="stat-panel-title text-uppercase">Reg Users</div>
                                    </div>
                                </div>
                                <a href="reg-users.php" class="block-anchor panel-footer text-center">
                                    Full Detail &nbsp;<i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4 panel-container">
                            <div class="panel panel-default">
                                <div class="panel-body bk-success text-light">
                                    <div class="stat-panel text-center">
                                        <?php
                                        $sql1 = "SELECT id FROM products";
                                        $query1 = $dbh->prepare($sql1);
                                        $query1->execute();
                                        $orders = $query1->rowCount();
                                        ?>
                                        <div class="stat-panel-number h1"><?php echo htmlentities($orders); ?></div>
                                        <div class="stat-panel-title text-uppercase">Listed Cakes</div>
                                    </div>
                                </div>
                                <a href="manage-cake.php" class="block-anchor panel-footer text-center">
                                    Full Detail &nbsp;<i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4 panel-container">
                            <div class="panel panel-default">
                                <div class="panel-body bk-info text-light">
                                    <div class="stat-panel text-center">
                                        <?php
                                        $sql2 = "SELECT id FROM orders";
                                        $query2 = $dbh->prepare($sql2);
                                        $query2->execute();
                                        $Orderings = $query2->rowCount();
                                        ?>
                                        <div class="stat-panel-number h1"><?php echo htmlentities($Orderings); ?></div>
                                        <div class="stat-panel-title text-uppercase">Orders</div>
                                    </div>
                                </div>
                                <a href="manage-Orderings.php" class="block-anchor panel-footer text-center">
                                    Full Detail &nbsp;<i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Second Row -->
                        <div class="col-md-4 panel-container">
                            <div class="panel panel-default">
                                <div class="panel-body bk-primary text-light">
                                    <div class="stat-panel text-center">
                                        <?php
                                        $sql3 = "SELECT id FROM category";
                                        $query3 = $dbh->prepare($sql3);
                                        $query3->execute();
                                        $brands = $query3->rowCount();
                                        ?>
                                        <div class="stat-panel-number h1"><?php echo htmlentities($brands); ?></div>
                                        <div class="stat-panel-title text-uppercase">Listed Category</div>
                                    </div>
                                </div>
                                <a href="manage-brands.php" class="block-anchor panel-footer text-center">
                                    Full Detail &nbsp;<i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4 panel-container">
                            <div class="panel panel-default">
                                <div class="panel-body bk-success text-light">
                                    <div class="stat-panel text-center">
                                        <?php
                                        $sql6 = "SELECT id FROM ydcs_contactusquery";
                                        $query6 = $dbh->prepare($sql6);
                                        $query6->execute();
                                        $queryCount = $query6->rowCount();
                                        ?>
                                        <div class="stat-panel-number h1"><?php echo htmlentities($queryCount); ?></div>
                                        <div class="stat-panel-title text-uppercase">Queries</div>
                                    </div>
                                </div>
                                <a href="manage-conactusquery.php" class="block-anchor panel-footer text-center">
                                    Full Detail &nbsp;<i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4 panel-container">
                            <div class="panel panel-default">
                                <div class="panel-body bk-info text-light">
                                    <div class="stat-panel text-center">
                                        <?php
                                        $sql5 = "SELECT id FROM ydcs_testimonial";
                                        $query5 = $dbh->prepare($sql5);
                                        $query5->execute();
                                        $testimonials = $query5->rowCount();
                                        ?>
                                        <div class="stat-panel-number h1"><?php echo htmlentities($testimonials); ?></div>
                                        <div class="stat-panel-title text-uppercase">Testimonials</div>
                                    </div>
                                </div>
                                <a href="testimonials.php" class="block-anchor panel-footer text-center">
                                    Full Detail &nbsp;<i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Loading Scripts -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap-select.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>
        <script src="js/fileinput.js"></script>
        <script src="js/main.js"></script>
    </body>
    </html>
    <?php
}
?>
