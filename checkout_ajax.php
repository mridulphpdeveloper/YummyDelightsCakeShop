<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

require_once(__DIR__ . "/lib/SslCommerzNotification.php");
include("db_connection.php");
include("OrderTransaction.php");

use SslCommerz\SslCommerzNotification;

$requestData = (array) json_decode($_POST['cart_json']);

$post_data['total_amount'] = '100';
$post_data['currency'] = "BDT";
$post_data['tran_id'] = "SSLCZ_TEST_" . uniqid();

//# CUSTOMER INFORMATION
$post_data['cus_name'] = isset($requestData['cus_name']) ? $requestData['cus_name'] : "John Doe";
$post_data['cus_email'] = isset($requestData['cus_email']) ? $requestData['cus_email'] : "john.doe@email.com";
$post_data['cus_add1'] = isset($requestData['cus_add1']) ? $requestData['cus_add1'] : "Dhaka";
$post_data['cus_add2'] = "Dhaka";
$post_data['cus_city'] = "Dhaka";
$post_data['cus_state'] = "Dhaka";
$post_data['cus_postcode'] = "1000";
$post_data['cus_country'] = "Bangladesh";
$post_data['cus_phone'] = isset($requestData['cus_phone']) ? $requestData['cus_phone'] : "01711111111";
$post_data['cus_fax'] = "01711111111";

# SHIPMENT INFORMATION
$post_data["shipping_method"] = "YES";
$post_data['ship_name'] = "Store Test";
$post_data['ship_add1'] = "Dhaka";
$post_data['ship_add2'] = "Dhaka";
$post_data['ship_city'] = "Dhaka";
$post_data['ship_state'] = "Dhaka";
$post_data['ship_postcode'] = "1000";
$post_data['ship_phone'] = "";
$post_data['ship_country'] = "Bangladesh";

$post_data['emi_option'] = "1";
$post_data["product_category"] = "Electronic";
$post_data["product_profile"] = "general";
$post_data["product_name"] = "Computer";
$post_data["num_of_item"] = "1";

$query = new OrderTransaction();
$sql = $query->saveTransactionQuery($post_data);

if ($conn_integration->query($sql) === TRUE) {

    # Call the Payment Gateway Library
    $sslcz = new SslCommerzNotification();
    $sslcz->makePayment($post_data, 'checkout', 'plain');
} else {
    echo "Error: " . $sql . "<br>" . $conn_integration->error;
}
