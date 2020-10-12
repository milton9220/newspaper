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
        if(isset($_POST['submit'])){
           $user_id=filter_input(INPUT_POST,'user_id',FILTER_SANITIZE_STRING);
           $fname=filter_input(INPUT_POST,'f_name',FILTER_SANITIZE_STRING);
           $lname=filter_input(INPUT_POST,'l_name',FILTER_SANITIZE_STRING);
           $user=filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
          
           $role=filter_input(INPUT_POST,'role',FILTER_SANITIZE_STRING);
           if($fname && $lname && $user && $user_id ){
              
              $query="UPDATE user SET first_name='{$fname}',last_name='{$lname}',username='{$user}',role='{$role}' WHERE user_id=$user_id LIMIT 1";
              mysqli_query($connection,$query);
              if(mysqli_error($connection)){
                  $status=1;
                  header("Location:http://localhost/newspaper/admin/update-user.php?status={$status}&&id={$user_id}");
              }
              else{
                  $status=9;
                  header("Location:http://localhost/newspaper/admin/users.php?status={$status}");
    
              }
           }
           else{
               $status=2;
               header("Location:http://localhost/newspaper/admin/update-user.php?status={$status}");
           }
          
        }
        
        
    }

?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Modify User Details</h1>
              </div>
              <div class="col-md-offset-4 col-md-4">
                  <!-- Form Start -->
                  <?php 
                     
                      $user_id=$_GET['id'];
                      $query="SELECT * FROM user WHERE user_id=$user_id";
                      $result=mysqli_query($connection,$query);
                      if(mysqli_num_rows($result)>0){?>
                       <?php while($data=mysqli_fetch_assoc($result)){ ?>
                  
                  <form  action="" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="user_id"  class="form-control" value="<?php echo $data['user_id']; ?>" placeholder="" >
                      </div>
                          <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="f_name" class="form-control" value="<?php echo $data['first_name']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="l_name" class="form-control" value="<?php echo $data['last_name']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="username" class="form-control" value="<?php echo $data['username']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" value="<?php echo $row['role']; ?>">

                          <?php
                                  if(1==$data['role']){ ?>
                                      <option value="0">normal User</option>
                                      <option value="1" selected>Admin</option>
                                   <?php }
                                  else{ ?>
                                      <option value="0" selected>normal User</option>
                                      <option value="1">Admin</option>
                                 <?php }
                              ?>
                              
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
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                  <!-- /Form -->
                      <?php 
                      }
                    }
                    mysqli_close($connection);
                      ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
