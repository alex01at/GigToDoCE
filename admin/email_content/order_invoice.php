<?php 

$get_email_content = "select * from email_content where name='order-invoice'";
	
$run_email_content = mysqli_query($con,$get_email_content);

$row_email_content = mysqli_fetch_array($run_email_content);

$content = $row_email_content['content'];

?>

<form action="" method="post">
	
<input type="hidden" name="name" value="order-invoice">

<div class="form-group">
	
<textarea name="content" class="form-control" rows="15"><?= $content; ?></textarea>

</div>

<div class="form-group text-right mb-0">

<input type="submit" name="update" class="btn btn-success" value="Save Changes">	

</div>

</form>