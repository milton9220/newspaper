<?php
include_once "config.php";
$connection=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if(!$connection){
   echo "Database not connected";
   die();

}
?>
<div id="sidebar" class="col-md-4">
    <!-- search box -->
    <div class="search-box-container">
        <h4>Search</h4>
        <form class="search-post" action="search.php" method ="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search .....">
                <span class="input-group-btn">
                    <button type="submit"  class="btn btn-danger">Search</button>
                </span>
            </div>
        </form>
    </div>
    <!-- /search box -->
    <!-- recent posts box -->
    <div class="recent-post-container">
        <h4>Recent Posts</h4>
       <?php
            $query="SELECT * FROM post
            JOIN category ON post.category=category.category_id
            ORDER BY post.post_id DESC LIMIT 5";
            $result=mysqli_query($connection,$query);
            if(mysqli_num_rows($result)>0){
                while($data=mysqli_fetch_assoc($result)){
            
       ?>
        <div class="recent-post">
            <a class="post-img" href="">
                <img src="admin/upload/<?php echo $data['post_img']; ?>" alt=""/>
            </a>
            <div class="post-content">
                <h5><a href="single.php"><?php echo $data['title']; ?></a></h5>
                <span>
                    <i class="fa fa-tags" aria-hidden="true"></i>
                    <a href='category.php?cat_name=<?php echo $data['category_name']; ?>'><?php echo $data['category_name']; ?></a>
                </span>
                <span>
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <?php echo $data['post_date']; ?>
                </span>
                <a class="read-more" href="single.php?post_id=<?php echo $data['post_id']; ?>">read more</a>
            </div>
        </div>
        <?php }
            }
            ?>
    </div>
    <!-- /recent posts box -->
</div>
                