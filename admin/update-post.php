<?php 
include "header.php";
require_once "../functions.php";
include_once "../config.php";
$error=[];
$post_id=$_GET['post_id'];
 $connection=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
 if(!$connection){
    echo "Database not connected";
    die();

}
else{
    
}
 ?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->
        <?php
            $post_id=$_GET['post_id'];
            $query="SELECT * FROM post 
            WHERE post_id={$post_id}";
            $result=mysqli_query($connection,$query);
            if(mysqli_num_rows($result)>0){
                $data=mysqli_fetch_assoc($result);
               
            }
        ?>
        <form action="save-update-post.php?post_id=<?php echo $post_id; ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <input type="hidden" name="post_id"  class="form-control" value="<?php echo $data['post_id']; ?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value="<?php echo $data['title']; ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1"> Description</label>
                <textarea name="postdesc" class="form-control"  required rows="5"><?php echo $data['description']; ?>
                </textarea>
            </div>
            <div class="form-group">
               
                <label for="exampleInputCategory">Category</label>
                <select class="form-control" name="category">
                <?php 
                      
                      $query2="SELECT * FROM category";
                      $result2=mysqli_query($connection,$query2);
                      if(mysqli_num_rows($result2)>0){
                          
                      while($category=mysqli_fetch_assoc($result2)){
                        if($category['category_id']==$data['category']){
                    ?>    
                         <option value="<?php echo $category['category_id']; ?>" selected><?php echo $category['category_name']; ?></option> 
                        <?php }
                        else{ ?>
                            <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
                            
                      <?php }
                       }
                      }
                      ?> 
                    
                </select>
            </div>
            <div class="form-group">
                <label for="">Post image</label>
                <input type="file" name="new-image">
                <img  src="upload/<?php echo $data['post_img'] ?>" height="150px">
                <input type="hidden" name="old-image" value="<?php echo $data['post_img'] ?>">
            </div>
            <p style="color:red;">
                          <?php 
                            $statusCode=$_GET['status'] ?? '';
                            if($statusCode){
                               echo getStatusMessage($statusCode);
                           }
                          ?>
            </p>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
        </form>
        <!-- Form End -->
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
