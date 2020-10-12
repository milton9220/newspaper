<?php 

include "header.php";
include_once "../config.php";
require_once "../functions.php";
 $connection=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
 if(!$connection){
    echo "Database not connected";
    die();

} 

?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
              <h4>
           <?php
                    $statusCode=$_GET['status'] ?? '';
                     if($statusCode){
                        echo getStatusMessage($statusCode);
                    }

            ?>
           </h4>
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
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
                            ORDER BY post.post_id DESC LIMIT {$offset},{$limit}";
                            $result=mysqli_query($connection,$query);
                            if(mysqli_num_rows($result)>0){ 
                                while($data=mysqli_fetch_assoc($result)){
                                ?>
                      
                          <tr>
                              <td class='id'><?php echo $data['post_id']; ?></td>
                              <td><?php echo $data['title']; ?></td>
                              <td><?php echo $data['category_name']; ?></td>
                              <td><?php echo $data['post_date']; ?></td>
                              <td><?php 
                                    echo strtoupper($data['username']);
                              ?></td>
                              <td class='edit'><a href='update-post.php?post_id=<?php echo $data['post_id']; ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?post_id=<?php echo $data['post_id']; ?>&&cat_id=<?php echo $data['category_id']; ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                                <?php }
                            }
                            ?>
                          
                      </tbody>
                  </table>
                  <?php 
                    $query1="SELECT * FROM post";
                    $result1=mysqli_query($connection,$query1);
                    if(mysqli_num_rows($result1)>0){
                        $total_records=mysqli_num_rows($result1);
                        
                        $total_pages=ceil($total_records/$limit);
                        
                        echo "<ul class='pagination admin-pagination'>";
                        if($page > 1){ ?>
                            <li><a href="post.php?page=<?php echo $page-1; ?>">Prev</a></li>
                        <?php }

                        
                        for($i=1;$i<=$total_pages;$i++){ 
                            if($i== $page){
                                $active="active";
                            }
                            else{
                                $active="";
                            }
                            ?>
                           <li class="<?php echo $active ?>"><a  href="post.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                       <?php }
                       if($total_pages > $page):?>
                        <li><a href="post.php?page=<?php echo $page+1; ?>">Next</a></li>
                       <?php endif;
                        echo "</ul>";

                    }
                  ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
