<?php
session_start(); 
include("common/connection.php");
include('class/loginc.php');
$obb = new User($connect);
if (!empty($_GET['log'])) 
{
    session_destroy();
    header('location:index.php');
}
include('config.php');
include('face.php');
$category = $_GET['category'] ?? "Clothes"; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogged Website </title>
    <link rel="stylesheet" href="css/styles.css?v=1.1">
    <link rel="stylesheet" href="css/search.css?v=1.2">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
        <?php include('common/header.php'); ?>
        <div class="container">
            <?php include('common/category.php'); ?>
            <main class="content">
            <a href="catpdf.php?category=<?php echo $category ?>"><input type="button" class="cpdf" 
                style="
                    margin-top: 10px;
                    padding: 10px 20px;
                    background-color: #ff6347;
                    color: #fff;
                    text-decoration: none;
                    border-radius: 5px;
                    border:#fff;
                    transition: background-color 0.3s ease;
                    "value="Create pdf"> </a>
                <h2><?php echo htmlspecialchars($category); ?> Category Blogs</h2>
                <p>
                    <?php include('common/blogtitle.php');?>
                </p>
                <section class="blog-posts">
                    <?php 
                        $blogs = $obb->display($category);
                        foreach ($blogs as $blog) 
                        {
                            echo "<article class='blog-post'>
                                    <img src='{$blog['image']}' alt='{$blog['title']}' class='blog-image'>
                                        <div class='blog-content'>
                                            <h3>" . $blog['title'] . "</h3>
                                            <p><strong>By:</strong> " . $blog['author'] . " | <strong>Date:</strong> " . date('F d, Y', strtotime($blog['created_at'])) . "</p>
                                            <p>" . $blog['excerpt'] . "</p>
                                            <a href='blog.php?id=" . $blog['id'] . "' class='read-more'>Read More</a>
                                            <a href='pdf.php?id=" . $blog['id'] . "' class='read-more'>Create Pdf</a>
                                        </div>
                                </article>";
                        } ?>               
                </section>
            </main>
        </div>
       
        <?php include('common/footer.php'); ?>   
    </body>
</html>
