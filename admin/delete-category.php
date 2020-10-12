<?php 
 include "header.php";
 include_once "../config.php"; 
 require_once "../functions.php"; 
 if($_SESSION['role']=='0'){
    header("Location:{$localhost}/admin/post.php");
}

 $connection=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
 if(!$connection){
    echo "Database not connected";
    die();

}
else{
    $category_id=$_GET['id'];
    $query="DELETE FROM category WHERE category_id=$category_id LIMIT 1";
    if(mysqli_query($connection,$query)){
        $status=10;
        header("Location:http://localhost/newspaper/admin/category.php?status={$status}");
    }
}