<?php
include_once "../config.php";
require_once "../functions.php";
$post_id=$_GET['post_id'];
$connection=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$errors=[];
if(!$connection){
   echo "Database not connected";
   die();

}
      
if(isset($_POST['submit'])){
    $post_id=filter_input(INPUT_POST,'post_id',FILTER_SANITIZE_STRING);
$post_title=filter_input(INPUT_POST,'post_title',FILTER_SANITIZE_STRING);  
$post_description=filter_input(INPUT_POST,'postdesc',FILTER_SANITIZE_STRING);    
$category=filter_input(INPUT_POST,'category',FILTER_SANITIZE_STRING);
   
    
    if(empty($_FILES['new-image']['name'])){
        $file_name=$_POST['old-image'];
    }
    else{
        
        $file_name=$_FILES['new-image']['name'];
        $file_size=$_FILES['new-image']['size'];
        $file_tmp=$_FILES['new-image']['tmp_name'];
        $file_type=$_FILES['new-image']['type'];
        $file_ext=strtolower(end(explode('.',$file_name)));
        $extensions=array("jpg","png","jpeg");
        if(in_array($file_ext,$extensions)===false){

            $status=12;
            header("Location:http://localhost/newspaper/admin/update-post.php?status={$status}&&post_id={$post_id}");
            die();
            
            
        }
        if($file_size > 2097152){
            $status=13;
            header("Location:http://localhost/newspaper/admin/update-post.php?status={$status}&&post_id={$post_id}");
            die();
        }
        move_uploaded_file($file_tmp,"upload/".$file_name);
        
        
       
    }
        
        $query="UPDATE post SET title='{$post_title}',description='{$post_description}',category='{$category}',post_img='{$file_name}' WHERE post_id={$post_id}";
        if(mysqli_query($connection,$query)){
            $status=14;
            header("Location:http://localhost/newspaper/admin/post.php?status={$status}");
        }

}
  
       
   
