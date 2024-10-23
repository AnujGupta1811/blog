<?php
session_start();
require '../common/connection.php';

// Check if user is logged in
if (empty($_SESSION['username'])) {
    header("Location:../login.php");
    exit();
}

$queryPosts = "SELECT COUNT(*) AS title FROM blogs";
$queryComments = "SELECT COUNT(*) AS content FROM comment";

$username = $_SESSION['username'];
$queryUserPosts = "SELECT COUNT(*) AS user_posts FROM blogs WHERE author = '$username'";
$totalUserPosts = $connect->query($queryUserPosts)->fetch_assoc()['user_posts'];

$totalPosts = $connect->query($queryPosts)->fetch_assoc()['title'];
$totalComments = $connect->query($queryComments)->fetch_assoc()['content'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Blog Website</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/styles.css?v=1.1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="../images/logo.jpg" alt="Website Logo" class="logo">
            <h1>Blog Dashboard</h1>
            <nav>
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li></li>
                    <li>
                        <div class="btn">
                            <?php if (empty($_SESSION['username'])) { ?>
                                <a href="../login.php"><input type="button" value="Log in"></a>
                            <?php } else { ?>
                                <a href="../index.php?log=1"><input type="button" value="Log Out <?php echo $_SESSION['username']; ?>"></a>
                            <?php } ?>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <aside class="sidebar">
            <h2>Dashboard</h2>
            <ul>
             
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" onclick="toggleDropdown()">
                    <i class="fas fa-play-circle" style="font-size: 12px;"></i>
                    Categories
                    </a>
                    <ul class="dropdown-menu">
                        <?php 
                            include("../common/category.php");
                        ?>
                    </ul>
                </li>
                <li><a href="../addpost.php">Add Post</a></li>
                
                <?php
                    if(isset($_SESSION['user_data']))
                    {
                        $role=$_SESSION['role'];
                        if($role==1)
                        {
                            ?>
                            <li><a href="../approve.php">To Approve Posts</a></li>
                            <li><a href="addcategory.php?lag=1">Add Category</a></li>
                            <?php
                        }
                    }
                ?>
            </ul>
        </aside>

    
        <div class="content">
            <div class="dashboard-container">
                <div class="card">
                    <h3>Total Posts</h3>
                    <p><?php echo $totalPosts; ?></p>
                </div>
                <div class="card">
                    <h3>Your Posts</h3>
                    <p><?php echo $totalUserPosts ?></p>
                </div>
                <div class="card">
                    <h3>Total Comments</h3>
                    <p><?php echo $totalComments; ?></p>
                </div>
            </div>

          
            <div class="blog-posts">
                <?php 
                    $query="select * from blogs where author='$username' ";
                    $result=mysqli_query($connect,$query);
                    while($blog=$result->fetch_assoc())
                    {
                        echo "<article class='blog-post'>
                                            <img src='../{$blog['image']}' alt='{$blog['title']}' class='blog-image'>
                                                <div class='blog-content'>
                                                    <h3>" . $blog['title'] . "</h3>
                                                    <p><strong>By:</strong> " . $blog['author'] . " | <strong>Date:</strong> " . date('F d, Y', strtotime($blog['created_at'])) . "</p>
                                                    <p>" . $blog['excerpt'] . "</p>
                                                    <a href='blog.php?id=" . $blog['id'] . "' class='read-more'>Read More</a>
                                                </div>
                                        </article>";
                    }
                ?>
            </div>
        </div>
    </div>
    <?php include('../common/footer.php'); ?>       
</body>
</html>
<script>
function toggleDropdown() {
    const dropdown = document.querySelector('.dropdown');
    dropdown.classList.toggle('open');
}
</script>
