<?php
include_once "../config.php";
$connection=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if($_SESSION['role']=='0'){
    header("Location:{$localhost}/admin/post.php");
}
if(!$connection){
     echo "Database not connected";
     die();

}
else{
    $user_id=$_GET['id'];
    $query="DELETE FROM user WHERE user_id=$user_id LIMIT 1";
    if(mysqli_query($connection,$query)){
        $status=4;
        header("Location:http://localhost/newspaper/admin/users.php?status={$status}");
    }
}
