<?php

session_start();
include("../../../../../includes/db.php");
include("../../../../../functions/payment.php");
if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('$site_url/login','_self')</script>";
}

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;

$status = (isset($_GET['status'])) ? $input->get('status') : '';

if(isset($_GET['orderTip']) & $status == "COMPLETED"){
   $_SESSION['method'] = "dusupay";
	require_once("../orderTip.php");
}