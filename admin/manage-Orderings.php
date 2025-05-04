<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {
    header('location:index.php');
} else {
    if(isset($_REQUEST['eid'])) {
        $eid = intval($_GET['eid']);
        $status = "2";
        $sql = "UPDATE orders SET orderStatus=:status WHERE id=:eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
        $query->execute();
        $msg = "Order Successfully Cancelled";
    }

    if(isset($_REQUEST['aeid'])) {
        $aeid = intval($_GET['aeid']);
        $status = 1;
        $sql = "UPDATE orders SET orderStatus=:status WHERE id=:aeid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':aeid', $aeid, PDO::PARAM_STR);
        $query->execute();
        $msg = "Order Successfully Confirmed";
    }
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
    <title>Yummy Delights CakeShop | Orders</title>

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
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Manage Orders</h2>
                        <div class="panel panel-default">
                            <button onClick="window.print()">Print Orders</button>
                            <div class="panel-heading">Orders Info</div>
                            <div class="panel-body">
                                <?php if($error) { ?>
                                    <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
                                <?php } else if($msg) { ?>
                                    <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
                                <?php } ?>
                                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Cake</th>
                                            <th>Quantity</th>
                                            <th>Cost</th>
                                            <th>Payment Method</th>
                                            <th>Status</th>
                                            <th>Order Note</th>
                                            <th>Posting Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Cake</th>
                                            <th>Quantity</th>
                                            <th>Cost</th>
                                            <th>Payment Method</th>
                                            <th>Status</th>
                                            <th>Order Note</th>
                                            <th>Posting Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
                                        $status = "2"; // Define the status you want to exclude
                                        $sql = "SELECT users.name AS username,
                                                   users.contactno AS usercontact,
                                                   products.productName AS productname,
                                                   orders.quantity AS quantity,
                                                   orders.orderDate AS orderdate,
                                                   products.productPrice AS productprice,
                                                   orders.paymentMethod,
                                                   orders.orderStatus,
                                                   orders.id AS id,
                                                   orders.ordernote AS ordernote,
                                                   products.shippingCharge AS shippingcharge
                                                FROM orders
                                                JOIN users ON orders.userId = users.id
                                                JOIN products ON products.id = orders.productId
                                                WHERE orders.orderStatus != :status OR orders.orderStatus IS NULL
                                                ORDER BY orders.orderDate ASC"; // FIFO order
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':status', $status, PDO::PARAM_STR);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if($query->rowCount() > 0) {
                                            foreach($results as $result) { ?>
                                                <tr>
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                    <td><?php echo htmlentities($result->username); ?></td>
                                                    <td><?php echo htmlentities($result->usercontact); ?></td>
                                                    <td><?php echo htmlentities($result->productname); ?></td>
                                                    <td><?php echo htmlentities($result->quantity); ?></td>
                                                    <td><?php echo htmlentities($result->quantity * $result->productprice + $result->shippingcharge); ?></td>
                                                    <td><?php echo htmlentities($result->paymentMethod); ?></td>
                                                    <td><?php echo htmlentities($result->orderStatus); ?></td>
                                                    <td><?php echo htmlentities($result->ordernote); ?></td>
                                                    <td><?php echo date('Y-m-d H:i:s', strtotime(htmlentities($result->orderdate))); ?></td>
                                                    <td>
                                                        <a href="updateorder.php?id=<?php echo htmlentities($result->id); ?>" title="Update order" target="_blank"><i class="fa fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                                <?php $cnt++; 
                                            } 
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
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
<?php } ?>
