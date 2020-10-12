<?php 
include "header.php";
include_once "../config.php";
require_once "../functions.php";
$status=0;
$connection=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if($_SESSION['role']=='0'){
    header("Location:{$localhost}/admin/post.php");
}
if(!$connection){
    echo "Database not connected";
    die();

}
else{
    if(isset($_POST['save'])){
       $fname=filter_input(INPUT_POST,'fname',FILTER_SANITIZE_STRING);
       $lname=filter_input(INPUT_POST,'lname',FILTER_SANITIZE_STRING);
       $user=filter_input(INPUT_POST,'user',FILTER_SANITIZE_STRING);
       $password=filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);
       $role=filter_input(INPUT_POST,'role',FILTER_SANITIZE_STRING);
       if($fname && $lname && $user && $password ){
          $hash = md5($password);
          $query="INSERT INTO user(first_name,last_name,username,password,role)VALUES('{$fname}','{$lname}','{$user}','{$hash}','{$role}')";
          mysqli_query($connection,$query);
          if(mysqli_error($connection)){
              $status=1;
              header("Location:http://localhost/newspaper/admin/add-user.php?status={$status}");
          }
          else{
              $status=3;
              header("Location:http://localhost/newspaper/admin/users.php?status={$status}");

          }
       }
       else{
           $status=2;
           header("Location:http://localhost/newspaper/admin/add-user.php?status={$status}");
       }
      
    }
    
}



?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add User</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                  <form  action="" method ="POST" autocomplete="off">
                      <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                      </div>
                          <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="user" class="form-control" placeholder="Username" required>
                      </div>

                      <div class="form-group">
                          <label>Password</label>
                          <input type="password" name="password" class="form-control" placeholder="Password" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" >
                              <option value="0">Normal User</option>
                              <option value="1">Admin</option>
                          </select>
                      </div>
                      <p style="color:red;">
                         <?php
                              $statusCode=$_GET['status'] ?? '';
                              if($statusCode){
                                  echo getStatusMessage($statusCode);
                              }

                         ?>
                      </p>
                      <input type="submit"  name="save" class="btn btn-primary" value="Save" required />
                  </form>
                   <!-- Form End-->
               </div>
           </div>
       </div>
   </div>
<?php include "footer.php"; ?>
