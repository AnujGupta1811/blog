<?php
session_start(); 
include("common/connection.php");
include('class/loginc.php');
$obb = new User($connect);
?>
<html>
    <head>
        <title>Admin Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/styles.css?v=1.1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>
    <body>
    <?php include('common/header.php'); ?>
        <div class="container">
            <?php include('common/category.php'); ?>
            <main class="content">
            <h2>All Category Blogs Which are not approved .</h2>
           
                <section class="blog-posts">
                    <?php $blogs = $obb->admindisplay();
                        foreach ($blogs as $blog) 
                        {
                            echo "<article class='blog-post'>
                                    <img src='{$blog['image']}' alt='{$blog['title']}' class='blog-image'>
                                        <div class='blog-content'>
                                            <h3>" . $blog['title'] . "</h3>
                                            <p><strong>By:</strong> " . $blog['author'] . " | <strong>Date:</strong> " . date('F d, Y', strtotime($blog['created_at'])) . "</p>
                                            <p>" . $blog['excerpt'] . "</p>
                                            <a href='blog.php?id=" . $blog['id'] . "' class='read-more'>Read More</a>
                                            <a href='approve.php?id=" . $blog['id'] . "' class='read-more'>Approve</a>
                                        </div>
                                </article>";
                        } ?>               
                </section>
            </main>
        </div>
        <?php include('common/footer.php'); ?>   
    </body>
</html>