<aside class="sidebar">
    <h2>Categories</h2>
    <ul>
        <?php if (!empty($_GET['lag'])) { ?>
            <?php if (isset($_SESSION['user_data'])) 
            {
                $role=$_SESSION['role'];
                if ($role == '1')
                { 
                    ?>
                        <li><a href="addcategory.php?lag=1">Add category</a></li>
                        <li><a href="../approve.php">For Approved</a></li> 
                    <?php
                } 
            }?>
        <li><a href="dashboard.php?lag=1">Recent Posts</a></li>
        <li><a href="commentveiw.php?lag=1">Recent Comments</a></li>
        <li><a href="addpost.php?lag=1">Add Post</a></li>
        



        <?php } else { ?>
            <?php
                        $query="select * from categories";
                        $result=mysqli_query($connect,$query);
                        while($row=mysqli_fetch_assoc($result))
                        {
                    ?>
                        <li><a href="clothes.php?category=<?php echo $row['category_name']?>"><?php echo $row['category_name']?></a>
                        </li>
                    <?php }?>
        
        
        <?php } ?>
    </ul>
</aside>