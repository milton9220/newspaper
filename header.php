<?php 
 
 include_once "config.php";
 $connection=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
 $title="Index Page";
 if(!$connection){
    echo "Database not connected";
    die();
 
 }
 else{
     $page=basename($_SERVER['PHP_SELF']);
     switch($page){
        case "single.php":
            if(isset($_GET['post_id'])){
                $query_title="SELECT * FROM post WHERE post_id={$_GET['post_id']}";
                $result_title=mysqli_query($connection,$query_title);
                $data_title=mysqli_fetch_assoc($result_title);
                $title=$data_title['title'];

            }
            else{
                $title="No Post Found";
            }
           
            break;
        case "index.php":
            $title="Home Page";
            break;
        case "category.php":
            if(isset($_GET['cat_name'])){
                 $query_cate="SELECT * FROM category WHERE category_name='{$_GET['cat_name']}'";
                 
                 $result_cate=mysqli_query($connection,$query_cate);
                 $data_cate=mysqli_fetch_assoc($result_cate);
                 $title=$data_cate['category_name'];

            }
            else{
                $title="No Post Found";
            }
            
            break;
        
        case "author.php":
            $title="Author  Page";
        break;        
     }
 }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $title; ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- HEADER -->
<div id="header">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- LOGO -->
            <div class=" col-md-offset-4 col-md-4">
                <a href="index.php" id="logo"><img src="images/news.jpg"></a>
            </div>
            <!-- /LOGO -->
        </div>
    </div>
</div>
<!-- /HEADER -->
<!-- Menu Bar -->
<div id="menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class='menu'>
                    <li><a href='index.php'>Home</a></li>
                    <?php 
                         $query="SELECT * FROM category";
                         $result=mysqli_query($connection,$query);
                         if(mysqli_num_rows($result)>0){

                         while($data=mysqli_fetch_assoc($result)){
                    ?>
                           <li><a href='category.php?cat_name=<?php echo $data['category_name']; ?>'><?php echo $data['category_name'] ?></a></li>
                         <?php }
                         }
                         ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /Menu Bar -->
