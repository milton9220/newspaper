<?php 
 include "header.php"; 
 require_once "../functions.php";
 include_once "../config.php";
 $connection=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME); 
 if($_SESSION['role']=='0'){
    header("Location:{$localhost}/admin/post.php");
}
if(!$connection){
    echo "Database not connected";
    die();

}
 ?>
 
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
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
                        <th>Category Name</th>
                        <th>No. of Posts</th>
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
                       $offset=($page-1)*$limit;
                       $query="SELECT * FROM category ORDER BY category_id DESC LIMIT {$offset},{$limit}";
                       $result=mysqli_query($connection,$query);
                       if(mysqli_num_rows($result)>0){ 
                           while($data=mysqli_fetch_assoc($result)){
                           ?>
                        <tr>
                            <td class='id'><?php echo $data['category_id']; ?></td>
                            <td><?php echo $data['category_name']; ?></td>
                            <td><?php echo $data['post']; ?></td>
                            <td class='edit'><a href='update-category.php?id=<?php echo $data['category_id']; ?>'><i class='fa fa-edit'></i></a></td>
                            <td class='delete'><a href='delete-category.php?id=<?php echo $data['category_id']; ?>'><i class='fa fa-trash-o'></i></a></td>
                        </tr>
                        
                       <?php 
                         } 
                       }
                       ?>
                        
                        
                        
                    </tbody>
                </table>
                <?php 
                    $query1="SELECT * FROM category";
                    $result1=mysqli_query($connection,$query1);
                    if(mysqli_num_rows($result1)>0){
                        $total_records=mysqli_num_rows($result1);
                        
                        $total_pages=ceil($total_records/$limit);
                        
                        echo "<ul class='pagination admin-pagination'>";
                        if($page > 1){ ?>
                            <li><a href="category.php?page=<?php echo $page-1; ?>">Prev</a></li>
                        <?php }

                        
                        for($i=1;$i<=$total_pages;$i++){ 
                            if($i== $page){
                                $active="active";
                            }
                            else{
                                $active="";
                            }
                            ?>
                           <li class="<?php echo $active ?>"><a  href="category.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                       <?php }
                       if($total_pages > $page):?>
                        <li><a href="category.php?page=<?php echo $page+1; ?>">Next</a></li>
                       <?php endif;
                        echo "</ul>";

                    }
                  ?>
                  
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
