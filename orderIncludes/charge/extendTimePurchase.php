<?php

require_once("$dir/functions/processing_fee.php");

$extendId = $_SESSION['extendId'];
$order_id = $_SESSION['extendOrderId'];
$proposal_id = $_SESSION['extendProposalId'];

// extend_time
$extend_time = $db->select("order_extend_time",array("id"=>$_SESSION['extendId'],"order_id"=>$_SESSION['extendOrderId']))->fetch();
if($extend_time->customAmount != 0){
	$amount = $extend_time->customAmount;
}else{
	$amount = $extend_time->extended_minutes*$extend_time->price_per_minute;
}
$processing_fee = processing_fee($amount);

// extendTime Code Starts
$get_order = $db->select("orders",array("order_id"=>$order_id));
$count_orders = $get_order->rowCount();
$row_order = $get_order->fetch();
$order_number = $row_order->order_number;
$order_minutes = explode(":",$row_order->order_minutes);
$totalOrderMinutes = $order_minutes[0]+$extend_time->extended_minutes.":$order_minutes[1]";
$totalExtendedMinutes = $row_order->extended_minutes+$extend_time->extended_minutes;
$totalExtendMinutesPrice = $row_order->extended_minutes_price+$amount;

$update = array(
	"order_minutes"=>$totalOrderMinutes,
	"extended_minutes"=>$totalExtendedMinutes,
	"extended_minutes_price"=>$totalExtendMinutesPrice,
	"order_price" => $row_order->order_price+$amount
);

$update_order = $db->update("orders",$update,array("order_id"=>$order_id));
if($update_order){
	if($db->update("order_extend_time",["processing_fee"=>$processing_fee,'status'=>'paid'],['id'=>$extend_time->id])){
		echo "
		<script>
			alert('You have successfully bought extra {$extend_time->extended_minutes} minutes for Order #$order_number, thank you.');
			window.close();
		</script>";
	}
}
// extendTime Code Ends