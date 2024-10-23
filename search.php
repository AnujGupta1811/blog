<?php
session_start();
include("common/connection.php");
include('class/loginc.php');
$obb = new User($connect);


$query = $_GET['query'] ?? ''; 
$blogs = $obb->searchBlogs($query); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="css/styles.css?v=1.1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include('common/header.php'); ?>
    <div class="container">
        <main class="content">
            <h2>Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>
            <section class="blog-posts">
                <?php
                if (!empty($blogs)) {
                    foreach ($blogs as $blog) {
                        echo "<article class='blog-post'>
                                <img src='{$blog['image']}' alt='{$blog['title']}' class='blog-image'>
                                <div class='blog-content'>
                                    <h3>" . htmlspecialchars($blog['title']) . "</h3>
                                    <p><strong>By:</strong> " . htmlspecialchars($blog['author']) . " | <strong>Date:</strong> " . date('F d, Y', strtotime($blog['created_at'])) . "</p>
                                    <p>" . htmlspecialchars($blog['excerpt']) . "</p>
                                    <a href='blog.php?id=" . $blog['id'] . "' class='read-more'>Read More</a>
                                </div>
                            </article>";
                    }
                } else {
                    echo "<p>No results found for \"$query\".</p>";
                }
                ?>
            </section>
        </main>
    </div>
    <?php include('common/footer.php'); ?>
</body>
</html>
