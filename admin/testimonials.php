<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if the user is logged in
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
} else {
    $error = ""; // Initialize error variable
    $msg = "";   // Initialize message variable

    // Handle deactivation of testimonial
    if (isset($_REQUEST['eid'])) {
        $eid = intval($_GET['eid']);
        $status = "0";
        $sql = "UPDATE productreviews SET status = :status WHERE id = :eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
        if ($query->execute()) {
            $msg = "Review successfully set to inactive.";
        } else {
            $error = "Failed to update review status.";
        }
    }

    // Handle activation of testimonial
    if (isset($_REQUEST['aeid'])) {
        $aeid = intval($_GET['aeid']);
        $status = 1;
        $sql = "UPDATE productreviews SET status = :status WHERE id = :aeid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':aeid', $aeid, PDO::PARAM_STR);
        if ($query->execute()) {
            $msg = "Review successfully set to active.";
        } else {
            $error = "Failed to update Review status.";
        }
    }
?>

<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>Yummy Delights CakeShop | Manage Testimonials</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .errorWrap { padding: 10px; background: #fff; border-left: 4px solid #dd3d36; }
        .succWrap { padding: 10px; background: #fff; border-left: 4px solid #5cb85c; }
        .printer { background-color: green; text-align: center; }
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
                        <h2 class="page-title">Manage Testimonials</h2>
                      
                            						<button onClick="window.print()">Print Users</button>
                
                        <div class="panel panel-default">
                            <div class="panel-heading">User Testimonials</div>
                            <div class="panel-body">
                                <?php if ($error) { ?>
                                    <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?></div>
                                <?php } else if ($msg) { ?>
                                    <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?></div>
                                <?php } ?>
                                <table id="zctb" class="display table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Review</th>
            <th>Review Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch reviews from productreviews table
        $sql = "SELECT id, name, review, reviewDate, status FROM productreviews";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $cnt = 1;

        if ($query->rowCount() > 0) {
            foreach ($results as $result) { ?>    
                <tr>
                    <td><?php echo htmlentities($cnt); ?></td>
                    <td><?php echo htmlentities($result->name); ?></td>
                    <td><?php echo htmlentities($result->review); ?></td>
                    <td><?php echo htmlentities($result->reviewDate); ?></td>
					<td>
						<?php if ($result->status == 0) { ?>
							<a href="testimonials.php?aeid=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Do you really want to activate this review?')">Inactive</a>
						<?php } else { ?>
							<a href="testimonials.php?eid=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Do you really want to deactivate this review?')">Active</a>
						<?php } ?>
					</td>
                </tr>
            <?php 
                $cnt++;
            }
        } else {
            echo "<tr><td colspan='4'>No reviews found.</td></tr>";
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

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
<?php } ?>
