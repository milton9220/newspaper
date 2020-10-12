<?php
 session_start();
 include_once "../config.php";
 require_once "../functions.php";
 $connection=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
 $status=0;
 if(isset($_SESSION['username'])){
    header("Location:{$localhost}/admin/post.php");
}
if(!$connection){
    echo "Database not connected";
    die();

}
else{
    if(isset($_POST['login'])){
        $username=filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
        $password=md5($_POST['password']);
        if($username && $password){
            $query="SELECT user_id,username,password,role FROM user WHERE username='{$username}'";
            $result=mysqli_query($connection,$query);
            if(mysqli_num_rows($result)>0){
                $data=mysqli_fetch_assoc($result);
                $_password=$data['password'];
                $_username=$data['username'];
                $_id=$data['user_id'];
                $_role=$data['role'];
                
                if($password==$_password){
                    $_SESSION['user_id']=$_id;
                    $_SESSION['username']=$_username;
                    $_SESSION['role']=$_role;
                    header('Location: http://localhost/newspaper/admin/post.php');
                    die();

                }
                else{
                    $status=5;
                    header("Location:http://localhost/newspaper/admin/index.php?status={$status}");
                }
            }
            else{
                    $status=6;
                    header("Location:http://localhost/newspaper/admin/index.php?status={$status}");
            }
        }
    }
}
?>

<!doctype html>
<html>
   <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ADMIN | Login</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link rel="stylesheet" href="font/font-awesome-4.7.0/css/font-awesome.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body>
        <div id="wrapper-admin" class="body-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <img class="logo" src="images/news.jpg">
                        <h3 class="heading">Admin</h3>
                        <!-- Form Start -->
                        <form  action="" method ="POST">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="" required>
                            </div>
                            <p style="color:red;">
                             <?php
                              $statusCode=$_GET['status'] ?? '';
                              if($statusCode){
                                  echo getStatusMessage($statusCode);
                              }

                            ?>
                      </p>
                            <input type="submit" name="login" class="btn btn-primary" value="login" />
                        </form>
                        <!-- /Form  End -->
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
