<?php 
include "header.php"; 
require_once "../functions.php";
include_once "../config.php";
 $connection=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
 if(!$connection){
    echo "Database not connected";
    die();

} 

?>
  <div id="admin-content">
      <div class="container">
         <div class="row">
             <div class="col-md-12">
                 <h1 class="admin-heading">Add New Post</h1>
             </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form -->
                  <form  action="save-post.php" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="post_title">Title</label>
                          <input type="text" name="post_title" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1"> Description</label>
                          <textarea name="postdesc" class="form-control" rows="5"  required></textarea>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Category</label>
                          <select name="category" class="form-control">
                              <?php 
                                  $query="SELECT * FROM category";
                                  $result=mysqli_query($connection,$query);
                                  if(mysqli_num_rows($result)>0){
                                       while($data=mysqli_fetch_assoc($result)){
                                           echo "<option value='{$data['category_id']}'>{$data['category_name']} </option>";
                                       } 
                                  }
                              ?>
                              
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Post image</label>
                          <input type="file" name="fileToUpload" required>
                      </div>
                      <p style="color:red;">
                          <?php 
                            $statusCode=$_GET['status'] ?? '';
                            if($statusCode){
                               echo getStatusMessage($statusCode);
                           }
                          ?>
                      </p>
                      <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                  </form>
                  <!--/Form -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
