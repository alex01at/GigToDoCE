<?php

session_start();
require_once("../../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('../../login','_self')</script>";
}

if(isset($_POST["proposal_id"])){

	$proposal_id = $input->post("proposal_id");
	$data = $input->post();

	@$file = $_FILES["file"]["name"];
	@$file_tmp = $_FILES["file"]["tmp_name"];
	$allowed = array('jpeg','jpg','gif','png','tif','avi','mpeg','mpg','mov','rm','3gp','flv','mp4','zip','rar','mp3','wav','docx','csv','xls','pptx','pdf','txt');
		
	$file_extension = pathinfo($file, PATHINFO_EXTENSION);

	if(!in_array($file_extension,$allowed) & !empty($file)){
		
		$data["status"] = "error_file";
		
	}else{

		if(!empty($file)){
			$file = pathinfo($file, PATHINFO_FILENAME);
			$file = $file."_".time().".$file_extension";
		   uploadToS3("order_files/$file",$file_tmp);
			$data['file'] = $file;
			$data['isS3'] = $enable_s3;
		}else{
			$file = "";
		}

		if($input->post('enable')){
			$data['enable'] = 1;
		}else{
			$data['enable'] = 0;
		}
		
		$update = $db->update("instant_deliveries",$data,["proposal_id"=>$proposal_id]);
		if($update){
			$data["status"] = "success";
		}

	}

	echo json_encode($data);

}