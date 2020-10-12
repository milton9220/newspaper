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
                <div class="post-container">
                   
                   
                   <?php
                     $author_id=$_GET['author_id'];
                     $limit=3;
                   
                     if(isset($_GET['page'])){
                        $page=$_GET['page'];
                        }
                    else{
                        $page=1;
                    }
                    $offset=($page-1)* $limit;
                    $query2="SELECT * FROM post
                         
                        JOIN  user ON post.author=user.user_id
                        WHERE post.author={$author_id} 
                        ORDER BY post.post_id DESC";
                       $result2=mysqli_query($connection,$query2);
                       
                       $data2=mysqli_fetch_assoc($result2); ?>
                            <h2 class="page-headning"><?php 
                               if($data2['role']==1){ ?>
                                <a href='author.php?author_id=<?php echo $data2['author']; ?>'>Admin</a>
                           <?php }
                            else{ ?>
                                <a href='author.php?author_id=<?php echo $data2['author']; ?>'>Editor</a>
                            <?php }
                            ?></h2>
                       <?php
                       
                       

                    //query for find all values
                    $query="SELECT * FROM post
                            LEFT JOIN  category ON  post.category=category.category_id
                            LEFT JOIN  user ON post.author=user.user_id
                            WHERE user.user_id={$author_id} 
                            ORDER BY post.post_id DESC LIMIT {$offset},{$limit}";
                    $result=mysqli_query($connection,$query);
                    if(mysqli_num_rows($result)>0){
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
                                            <a href='category.php?cat_name=<?php echo $data['category_name']; ?>'><?php echo $data['category_name']; ?></a>
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
                    $query1="SELECT * FROM post WHERE author={$author_id}";
                    $result1=mysqli_query($connection,$query1);
                    if(mysqli_num_rows($result1)>0){
                        $total_records=mysqli_num_rows($result1);
                        
                        $total_pages=ceil($total_records/$limit);
                        
                        echo "<ul class='pagination admin-pagination'>";
                        if($page > 1){ ?>
                            <li><a href="author.php?author_id=<?php echo $author_id; ?>&&page=<?php echo $page-1; ?>">Prev</a></li>
                        <?php }

                        
                        for($i=1;$i<=$total_pages;$i++){ 
                            if($i== $page){
                                $active="active";
                            }
                            else{
                                $active="";
                            }
                            ?>
                           <li class="<?php echo $active ?>"><a  href="author.php?author_id=<?php echo $author_id; ?>&&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                       <?php }
                       if($total_pages > $page):?>
                        <li><a href="author.php?author_id=<?php echo $author_id; ?>&&page=<?php echo $page+1; ?>">Next</a></li>
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
