<?php 

session_start();
include("../includes/db.php");
include("../functions/payment.php");
include("../functions/processing_fee.php");

if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('../login.php','_self');</script>";
}

if(isset($_POST['mercadopago'])){

	$select_offers = $db->select("messages_offers",array("offer_id" => $_SESSION['c_message_offer_id']));
	$row_offers = $select_offers->fetch();
	$proposal_id = $row_offers->proposal_id;
	$amount = $row_offers->amount;
	$processing_fee = processing_fee($amount);

	$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
	$row_proposals = $select_proposals->fetch();
	$proposal_title = $row_proposals->proposal_title;

	$payment = new Payment();
	$data = [];
	$data['title'] = $proposal_title;
	$data['qty'] = 1;
	$data['price'] = $amount+$processing_fee;
	$data['cancel_url'] = "$site_url/conversations/inbox?single_message_id={$_SESSION['c_single_message_id']}";
	$data['redirect_url'] = "$site_url/mercadopago_order?message_offer_id={$_SESSION['c_message_offer_id']}";
	$payment->mercadopago($data,$processing_fee);

}else{
	echo "<script>window.open('../index','_self');</script>";
}