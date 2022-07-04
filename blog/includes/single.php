<?php 

	$id = $input->get('id');
	$post = $db->select("posts",['id'=>$id])->fetch();
	$url = preg_replace('#[ -]+#','-', $post->title);

	/// Get Category Details
	$get_cat = $db->select("post_categories",['id'=>$post->cat_id]);
	$row_cat = $get_cat->fetch();
	$cat_name = $row_cat->cat_name;

	$comments = $db->select("post_comments",array("post_id"=>$id));
	$count_comments = $comments->rowCount();

?>
<div class="card mb-4"><!--- card Starts --->
	<div class="card-body <?= $textRight; ?>"><!--- card-body Starts --->
		
		<h1 class="h3"><?= $post->title; ?></h1>
		<hr>
	   <p>
	   	Published on: <span class="text-muted"><?= $post->date_time; ?></span> | 
	   	Category: <a href="index?cat_id=<?= $post->cat_id; ?>" class="text-muted"><?= $cat_name; ?></a> |
	   	Author: <a href="index?author=<?= $post->author; ?>" class="text-muted"><?= $post->author; ?></a> 
	   </p>

		<img src="<?= getImageUrl("posts",$post->image); ?>" class="img-fluid mb-3"/>
		<div class="mt-3 post-content">
			<?= $post->content; ?>
		</div>

	</div><!--- card-body Ends --->
</div><!--- card Ends --->

<?php include("post_comments.php"); ?>

<a href="index" class="btn btn-success <?= $floatRight; ?>"> <i class="fa fa-arrow-left"></i>&nbsp; Go Back</a>
