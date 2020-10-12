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
        $category_id=filter_input(INPUT_POST,'cat_id',FILTER_SANITIZE_STRING);
        $category_name=filter_input(INPUT_POST,'cat_name',FILTER_SANITIZE_STRING);
        if($category_id && $category_name){
            $query="UPDATE category SET category_name='{$category_name}'  WHERE category_id=$category_id LIMIT 1";
            
            if(mysqli_query($connection,$query)){
                $status=9;
                  header("Location:http://localhost/newspaper/admin/category.php?status={$status}");
            }
        }
       
    }
    

}    
 
 ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="adin-heading"> Update Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <?php 
                    $category_id=$_GET['id'];
                    if($category_id){
                        $query="SELECT category_id,category_name FROM category WHERE category_id='{$category_id}'";
                        $result=mysqli_query($connection,$query);
                        if(mysqli_num_rows($result)>0){
                            $data=mysqli_fetch_assoc($result);
                        }
                     
                    }
                  ?>
                  <form action="" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="cat_id"  class="form-control" value="<?php echo $data['category_id']; ?>" placeholder="">
                      </div>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat_name" class="form-control" value="<?php echo $data['category_name']; ?>"  placeholder="" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                </div>
              </div>
            </div>
          </div>
<?php include "footer.php"; ?>
