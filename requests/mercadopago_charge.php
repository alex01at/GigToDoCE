<?php 
session_start();
include("../includes/db.php");
include("../functions/payment.php");
include("../functions/functions.php");
if(!isset($_SESSION['seller_user_name'])){
echo "<script>window.open('../login.php','_self');</script>";
}

if(isset($_POST['mercadopago'])){

	$select_offers = $db->select("send_offers",array("offer_id" => $_SESSION['c_offer_id']));
	$row_offers = $select_offers->fetch();
	$request_id = $row_offers->request_id;
	$proposal_id = $row_offers->proposal_id;
	$amount = $row_offers->amount;
	$processing_fee = processing_fee($amount);

	$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
	$row_proposals = $select_proposals->fetch();
	$proposal_title = $row_proposals->proposal_title;

	$data = [];
	$data['title'] = $proposal_title;
	$data['qty'] = 1;
	$data['price'] = $amount + $processing_fee;
	$data['cancel_url'] = "$site_url/requests/view_offers?request_id=$request_id";
	$data['redirect_url'] = "$site_url/mercadopago_order?view_offers=1&offer_id={$_SESSION['c_offer_id']}";
	
	$payment = new Payment();
	$payment->mercadopago($data,$processing_fee);

}else{
	echo "<script>window.open('../index','_self');</script>";
}