<?php

@session_start();

if(!isset($_SESSION['admin_email'])){     
      echo "<script>window.open('../../login','_self');</script>";     
}else{

if(isset($_GET['delete_post_cat'])){
      
    $delete_id = $input->get('delete_post_cat');
    $delete_post = $db->delete("post_categories",array('id' => $delete_id));
    
    if($delete_post){

        $insert_log = $db->insert_log($admin_id,"post",$delete_id,"deleted");

        echo "<script>

            swal({
            type: 'success',
            text: 'One Blog Category Has Been Deleted Successfully!',
            timer: 3000,
            onOpen: function(){
            swal.showLoading()
            }
            }).then(function(){
                window.open('index?post_categories','_self');
            });

        </script>";
    }

}

?>

<?php } ?>