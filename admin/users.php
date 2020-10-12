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
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Users</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-user.php">add user</a>
                  
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
                  <?php 
                  $limit=3;
                  
                  if(isset($_GET['page'])){
                      $page=$_GET['page'];
                  }
                  else{
                      $page=1;
                  }
                 
                  $offset=($page-1)* $limit;
                  $query="SELECT * FROM user ORDER BY user_id DESC LIMIT {$offset},{$limit}";
                  $result=mysqli_query($connection,$query);
                  if(mysqli_num_rows($result)>0){ ?>
         
                
                      <thead>
                          <th>S.No.</th>
                          <th>Full Name</th>
                          <th>User Name</th>
                          <th>Role</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                          <?php while($data=mysqli_fetch_assoc($result)):?>
                          <tr>
                              <td class='id'><?php echo $data['user_id']; ?></td>
                              <td><?php echo $data['first_name']." ".$data['last_name']; ?></td>
                              <td><?php echo $data['username']; ?></td>
                              <td><?php
                                  if(1==$data['role']){
                                      echo "Admin";
                                  }
                                  else{
                                      echo "Normal";
                                  }
                              ?></td>
                              <td class='edit'><a href='update-user.php?id=<?php echo $data["user_id"];  ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-user.php?id=<?php echo $data["user_id"];  ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php endwhile; ?>
                         
                          
                      </tbody>
                  </table>
                  <?php }

                  ?>

                  <?php 
                    $query1="SELECT * FROM user";
                    $result1=mysqli_query($connection,$query1);
                    if(mysqli_num_rows($result1)>0){
                        $total_records=mysqli_num_rows($result1);
                        
                        $total_pages=ceil($total_records/$limit);
                        
                        echo "<ul class='pagination admin-pagination'>";
                        if($page > 1){ ?>
                            <li><a href="users.php?page=<?php echo $page-1; ?>">Prev</a></li>
                        <?php }

                        
                        for($i=1;$i<=$total_pages;$i++){ 
                            if($i== $page){
                                $active="active";
                            }
                            else{
                                $active="";
                            }
                            ?>
                           <li class="<?php echo $active ?>"><a  href="users.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                       <?php }
                       if($total_pages > $page):?>
                        <li><a href="users.php?page=<?php echo $page+1; ?>">Next</a></li>
                       <?php endif;
                        echo "</ul>";

                    }
                  ?>
                  
                      <!--<li class="active"><a>1</a></li>-->
                      
                  
              </div>
          </div>
      </div>
  </div>
<?php include "header.php"; ?>
