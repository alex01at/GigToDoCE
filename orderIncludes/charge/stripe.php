<?php

session_start();
require_once("../../includes/db.php");
require_once("$dir/functions/payment.php");
@require_once("$dir/functions/functions.php");

if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('$site_url/login','_self')</script>";
}

$order_id = $_SESSION['tipOrderId'];
$amount = $_SESSION['tipAmount'];

$processing_fee = processing_fee($amount);

$data = [];
$data['type'] = 'orderTip';
$data['stripeToken'] = $input->post('stripeToken');
$data['amount'] = $amount+$processing_fee;
$data['desc'] = "Order Tip Payment";

$payment = new Payment();
if($payment->stripe($data)){
	require_once("orderTip.php");
}