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
$category = $_GET['category'] ?? "All"; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogged Website </title>
    <link rel="stylesheet" href="css/styles.css?v=1.3">
    <link rel="stylesheet" href="css/search.css?v=1.2">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var page_no = 1;
        var is_running = false;

        $(document).ready(function() {
            showdata();

            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() > $(document).height() - 50) {
                    if (!is_running) {
                        showdata();
                    }
                }
            });
        });

        function showdata() {
            is_running = true;
            $(".spinner-border").show();

            $.post("read.php", { page: page_no }, (response) => {
                console.log("Response:", response); // Log the response
                $("#data").append(response);
                $(".spinner-border").hide();
                is_running = false;
                page_no++;
            })
        }
    </script>
</head>
<body>
        <?php include('common/header.php'); ?>
        <div class="container">
            <?php include('common/category.php'); ?>
            <main class="content">
            <h2><?php echo htmlspecialchars($category); ?> Category Blogs</h2>
            <p>
                    <?php include('common/blogtitle.php');?>
                </p>
                <section id="data" class="blog-posts">
                             
                </section>
            </main>
        </div>
        <?php include('common/footer.php'); ?>   
    </body>
</html>
