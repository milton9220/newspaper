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
   $post_id=$_GET['post_id'];
   $cat_id=$_GET['cat_id'];
   $query2="SELECT * FROM post WHERE post_id={$post_id}";
   $result=mysqli_query($connection,$query2);
   $data=mysqli_fetch_assoc($result);
   
   unlink("upload/".$data['post_img']);
   $query="DELETE FROM post WHERE post_id={$post_id} LIMIT 1;";
   $query .="UPDATE category SET post=post-1 WHERE category_id={$cat_id}";
   if(mysqli_multi_query($connection,$query)){
       $status=15;
       header("Location:http://localhost/newspaper/admin/post.php?status={$status}");
   }
}