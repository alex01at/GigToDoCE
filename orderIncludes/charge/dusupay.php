<?php

session_start();
require_once("../../includes/db.php");
require_once("$dir/functions/payment.php");
require_once("$dir/functions/processing_fee.php");
if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('$site_url/login','_self')</script>";
}

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;

if(isset($_POST['dusupay'])){

	$order_id = $_SESSION['tipOrderId'];
	$amount = $_SESSION['tipAmount'];

	$processing_fee = processing_fee($amount);

	$payment = new Payment();
	$data = [];
	$data['name'] = "Order Tip Payment";
	$data['amount'] = $amount+$processing_fee;
	$data['redirect_url'] = "$site_url/orderIncludes/charge/order/dusupay?orderTip=1";

	$payment->dusupay($data);
}else{
	echo "<script>window.open('index','_self')</script>";
}