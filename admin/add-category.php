<?php 
    include "header.php";
    include_once "../config.php";
    require_once "../functions.php"; 
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
            $category=filter_input(INPUT_POST,'cat',FILTER_SANITIZE_STRING);
            
            if($category){
              $query="INSERT INTO category(category_name)VALUES('{$category}')";
              if(mysqli_query($connection,$query)){
                  $status=7;
                  header("Location:http://localhost/newspaper/admin/category.php?status={$status}");
              }
            }
            else{
                $status=8;
                header("Location:http://localhost/newspaper/admin/add-category.php?status={$status}");
            }
        }
    }
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add New Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                  <form action="" method="POST" autocomplete="off">
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat" class="form-control" placeholder="Category Name" required>
                      </div>
                      <p style="color:red;">
                         <?php
                              $statusCode=$_GET['status'] ?? '';
                              if($statusCode){
                                  echo getStatusMessage($statusCode);
                              }

                         ?>
                      </p>
                      <input type="submit" name="save" class="btn btn-primary" value="Save" required />
                  </form>
                  <!-- /Form End -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
