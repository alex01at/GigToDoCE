<?php

	session_start();
	require_once("../../includes/db.php");

	if(!isset($_SESSION['seller_user_name'])){
  	echo "<script>window.open('../login','_self')</script>";
	}

  $proposal_id = strip_tags($input->post('proposal_id'));
  $name = strip_tags($input->post('name'));
  $new_name = strip_tags($input->post('new_name'));

  $update_extra = $db->update("package_attributes",['attribute_name'=>$new_name],['attribute_name'=>$name,'proposal_id'=>$proposal_id]);