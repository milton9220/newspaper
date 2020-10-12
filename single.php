<?php 
 include 'header.php'; 
 include_once "config.php";
$connection=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if(!$connection){
   echo "Database not connected";
   die();

}
 ?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                  <!-- post-container -->
                  <?php
                       $post_id=$_GET['post_id'];
                       $query="SELECT * FROM post
                            LEFT JOIN  category ON  post.category=category.category_id
                            LEFT JOIN  user ON post.author=user.user_id
                            WHERE post.post_id={$post_id} 
                            ORDER BY post.post_id ";
                        $result=mysqli_query($connection,$query);
                        if(mysqli_num_rows($result)>0){ 
                            $data=mysqli_fetch_assoc($result);
                        }
                  ?>
                    <div class="post-container">
                        <div class="post-content single-post">
                            <h3><?php echo $data['title']; ?></h3>
                            <div class="post-information">
                                <span>
                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                    <?php echo $data['category_name']; ?>
                                </span>
                                <span>
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <?php 
                                                    if($data['role']==1){
                                                        echo "<a href='author.php'>Admin</a>";
                                                    }
                                                    else{
                                                        echo "<a href='author.php'>Editor</a>";
                                                    }
                                    ?>
                                </span>
                                <span>
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    <?php echo $data['post_date']; ?>
                                </span>
                            </div>
                            <img class="single-feature-image" src="admin/upload/<?php echo $data['post_img'] ?>" alt=""/>
                            <p class="description">
                            <?php echo $data['description']; ?>
                            </p>
                        </div>
                    </div>
                    <!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
