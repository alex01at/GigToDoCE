<?php

function watermarkImage($image,$data){
  
  global $site_watermark;

  $fileType = pathinfo($image,PATHINFO_EXTENSION);
  if($fileType == "jpg" or $fileType == "jpeg" or $fileType == "png"){

    switch($fileType){
      case 'jpg':
        $img = imagecreatefromjpeg($data); 
        break;
      case 'jpeg':
        $img = imagecreatefromjpeg($data); 
        break;
      case 'png':
        $img = imagecreatefrompng($data); 
        break; 
      default:
        $img = imagecreatefromjpeg($data); 
    }

    $watermark = imagecreatefrompng("images/$site_watermark");
    $margin_right = 25;
    $margin_bottom = 15;
    $sx = imagesx($watermark);
    $sy = imagesy($watermark);

    imagecopy($img, $watermark,imagesx($img) - $sx - $margin_right, imagesy($img) - $sy - $margin_bottom, 0, 0, $sx, $sy);
    ob_start();
    imagejpeg($img,null,100);
    $image_contents = ob_get_clean();
    imagedestroy($img);

    uploadToS3("$image","",$image_contents);

  }else{
    uploadToS3("$image",$data);
  }

}