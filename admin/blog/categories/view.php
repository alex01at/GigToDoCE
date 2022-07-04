
<div class="breadcrumbs">
	<div class="col-sm-4">
		<div class="page-header float-left">
		  <div class="page-title">
		    <h1><i class="menu-icon fa fa-rss"></i> Blog</h1>
		  </div>
		</div>
	</div>
	<div class="col-sm-8">
		<div class="page-header float-right">
		  <div class="page-title">
				<ol class="breadcrumb text-right">
				  <li class="active">Categories</li>
				</ol>
		  </div>
		</div>
	</div>
</div>

<div class="container"><!--- container Starts --->

<div class="row"><!-- row Starts -->
<div class="col-lg-12"><!-- col-lg-12 Starts -->
<div class="card card-default"><!-- card card-default Starts -->

<div class="card-header"><!-- card-header Starts -->
	<i class="fa fa-money fa-fw"></i> Manage Categories 
</div><!-- card-header Ends -->

<div class="card-body"><!-- card-body Starts -->

	<h3>New Category</h3>
	
	<form action="" method="post" enctype="multipart/form-data">
		<div class="form-group mt-2">
			<label for="cat_name">Name</label>
			<input class="form-control input-md" type="text" name="cat_name" placeholder="Name" required="">
		</div>
		<div class="form-group mt-2">
			<label for="cat_name">Image</label>
			<input class="form-control input-md" type="file" name="cat_image" required="">
		</div>
		<div class="form-group">
			<input class="form-control btn btn-success" name="insert" type="submit" value="Insert New Category">
		</div>
	</form>

	<div class="table-responsive"><!--- table-responsive Starts -->
	<table class="table table-bordered table-hover table-striped"><!--- table table-bordered table-hover table-striped Starts -->
	<thead>
	<tr>
	<th>No</th>
	<th>Category Name</th>
	<!-- <th>Date Added</th> -->
	<th>Added By</th>
	<th>Actions</th>
	</tr>
	</thead>
	<tbody>
		<?php
		$i = 0;
		$categories = $db->select("post_categories","","DESC");
		while($cat = $categories->fetch()){
			$i++;
		?>
		<tr>
			<td><?= $i; ?></td>
			<td><?= $cat->cat_name; ?></td>
			<td><?= $cat->date_time; ?></td>
			<!-- <td><?= $cat->cat_creator; ?></td> -->
			<td>
				<div class="dropdown">
					<button class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-cog"></i> Actions
					</button>
					<div class="dropdown-menu" style="margin-left: -125px;">
						<a class="dropdown-item" href="index?edit_post_cat=<?= $cat->id; ?>">
							<i class="fa fa-pencil"></i> Edit
						</a>
						<a class="dropdown-item" href="index?delete_post_cat=<?= $cat->id; ?>" 
						onclick="if(!confirm('Are you sure you want to delete selected item.')){ return false; }">
							<i class="fa fa-trash"></i> Delete
						</a>
					</div>
				</div>
			</td>
		</tr>
		<?php } ?>
	</tbody>
	</table><!--- table table-bordered table-hover table-striped Starts -->
	</div><!--- table-responsive Ends -->
</div><!-- card-body Ends -->
</div><!-- card card-default Ends -->
</div>
</div>
</div>

<?php 

if(isset($_POST['insert'])){

	$data = $input->post();
	$data['date_time'] = date("F d, Y");
	unset($data['insert']);

	$cat_image = $_FILES['cat_image']['name'];
	$tmp_cat_image = $_FILES['cat_image']['tmp_name'];

	$allowed = array('jpeg','jpg','gif','png','tif','ico','webp');
	$file_extension = pathinfo($cat_image, PATHINFO_EXTENSION);
	if(!in_array($file_extension,$allowed) & !empty($cat_image)){
	   echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
	}else{
	                  
	   uploadToS3("blog_cat_images/$cat_image",$tmp_cat_image);
      $data['cat_image'] = $cat_image;
      $data['isS3'] = $enable_s3;

		$update = $db->insert("post_categories",$data);
		if($update){
			$insert_id = $db->lastInsertId();
			$insert_log = $db->insert_log($admin_id,"post_cat",$insert_id,"updated");
			echo "<script>alert_success('One Post Category has been Inserted Successfully.','index?post_categories');</script>";
		}

	}

}

?>