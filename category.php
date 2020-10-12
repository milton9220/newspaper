<?php 
include 'header.php'; 
include_once "config.php";
$category_name=$_GET['cat_name'];
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
                <div class="post-container">
                  
                  <h2 class="page-heading"><?php echo $category_name; ?></h2>
                  <?php 
                    
                    $limit=3;
                  
                            if(isset($_GET['page'])){
                                $page=$_GET['page'];
                            }
                            else{
                                $page=1;
                            }
                            $offset=($page-1)* $limit;
                            $query="SELECT * FROM post
                            LEFT JOIN  category ON  post.category=category.category_id
                            LEFT JOIN  user ON post.author=user.user_id
                            WHERE category.category_name='{$category_name}' 
                            ORDER BY post.post_id DESC LIMIT {$offset},{$limit}";
                            $result=mysqli_query($connection,$query);
                    $result=mysqli_query($connection,$query);
                    if(mysqli_num_rows($result)){
                      while($data=mysqli_fetch_assoc($result)){
                   ?> 
                    <div class="post-content">
                        <div class="row">
                            <div class="col-md-4">
                                <a class="post-img" href="single.php"><img src="admin/upload/<?php echo $data['post_img'] ?>" alt=""/></a>
                            </div>
                            <div class="col-md-8">
                                <div class="inner-content clearfix">
                                    <h3><a href='single.php'><?php echo $data['title'] ?></a></h3>
                                    <div class="post-information">
                                        <span>
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <a href='category.php?cat_name=<?php echo $data['category_name']; ?>'><?php echo $data['category_name'] ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <?php 
                                                   if($data['role']==1){ ?>
                                                    <a href='author.php?author_id=<?php echo $data['author']; ?>'>Admin</a>
                                               <?php }
                                                else{ ?>
                                                    <a href='author.php?author_id=<?php echo $data['author']; ?>'>Editor</a>;
                                                <?php }
                                            ?>
                                        </span>
                                        <span>
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <?php echo $data['post_date']; ?>
                                        </span>
                                    </div>
                                    <p class="description">
                                    <?php echo substr($data['description'],0,150)."..."; ?>
                                    </p>
                                    <a class='read-more pull-right' href='single.php?post_id=<?php echo $data['post_id']; ?>'>read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }
                            }
                    ?>
                    <?php 
                    $query1="SELECT * FROM post
                             LEFT JOIN  category ON  post.category=category.category_id
                             LEFT JOIN  user ON post.author=user.user_id
                             WHERE category.category_name='{$category_name}'";
                    $result1=mysqli_query($connection,$query1);
                    if(mysqli_num_rows($result1)>0){
                        $total_records=mysqli_num_rows($result1);
                        
                        $total_pages=ceil($total_records/$limit);
                        
                        echo "<ul class='pagination admin-pagination'>";
                        if($page > 1){ ?>
                            <li><a href="category.php?cat_name=<?php echo $category_name; ?>&&page=<?php echo $page-1; ?>">Prev</a></li>
                        <?php }

                        
                        for($i=1;$i<=$total_pages;$i++){ 
                            if($i== $page){
                                $active="active";
                            }
                            else{
                                $active="";
                            }
                            ?>
                           <li class="<?php echo $active ?>"><a  href="category.php?cat_name=<?php echo $category_name; ?>&&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                       <?php }
                       if($total_pages > $page):?>
                        <li><a href="category.php?cat_name=<?php echo $category_name; ?>&&page=<?php echo $page+1; ?>">Next</a></li>
                       <?php endif;
                        echo "</ul>";

                    }
                  ?>        
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
