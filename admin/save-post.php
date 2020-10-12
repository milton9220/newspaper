<?php
session_start();
include_once "../config.php";
require_once "../functions.php";


 $connection=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
 $errors=[];
 if(!$connection){
    echo "Database not connected";
    die();

}
else{
    if(isset($_FILES['fileToUpload'])){
        
        $file_name=$_FILES['fileToUpload']['name'];
        $file_size=$_FILES['fileToUpload']['size'];
        $file_tmp=$_FILES['fileToUpload']['tmp_name'];
        $file_type=$_FILES['fileToUpload']['type'];
        $file_ext=strtolower(end(explode('.',$file_name)));
        $extensions=array("jpg","png","jpeg");
        if(in_array($file_ext,$extensions)===false){

            $status=12;
            header("Location:http://localhost/newspaper/admin/add-post.php?status={$status}");
            die();
        }
        if($file_size > 2097152){
            $errors[]="File Size Must Be Less Than 2MB";
            $status=13;
            header("Location:http://localhost/newspaper/admin/add-post.php?status={$status}");
            die();
        }
        
            move_uploaded_file($file_tmp,"upload/".$file_name);
            $post_title=filter_input(INPUT_POST,'post_title',FILTER_SANITIZE_STRING);
            
           
            $post_description=filter_input(INPUT_POST,'postdesc',FILTER_SANITIZE_STRING);
            
            $category=filter_input(INPUT_POST,'category',FILTER_SANITIZE_STRING);
            $date=date("d M, Y");
            $author=$_SESSION['user_id'];
            $query="INSERT INTO post(title,description,category,post_date,author,post_img)VALUES('{$post_title}','{$post_description}',{$category},'{$date}',{$author},'{$file_name}');";
            $query .="UPDATE category SET post=post+1 WHERE category_id={$category}";
            if(mysqli_multi_query($connection,$query)){
                $status=11;
                header("Location:http://localhost/newspaper/admin/post.php?status={$status}");
            }
        
        
    }
   
} 