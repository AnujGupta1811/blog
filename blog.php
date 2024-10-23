<?php
session_start();
include("common/connection.php");
include('class/loginc.php');
$obb = new User($connect);

if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $post=$obb->readmore();
    $comments=$obb->comdisplay($_GET['id']);
}
else 
{
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - Blog Website</title>
    <link rel="stylesheet" href="css/blog.css?v=1.1">

    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CDN -->

</head>
<body>
    <?php include('common/header.php'); ?>

    <div class="container">
    <main class="blog-content">
        <h1><?php echo htmlspecialchars($post['title']); ?></h1>
        <p><strong>By:</strong> <?php echo htmlspecialchars($post['author']); ?> | <strong>Date:</strong> <?php echo date('F d, Y', strtotime($post['created_at'])); ?></p>
        
        <!-- Flexbox container for the image and excerpt -->
        <div class="image-excerpt-container">
            <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="blog-post-image">
            <p class="excerpt"><?php echo nl2br(htmlspecialchars($post['excerpt'])); ?>
            <?php echo nl2br(htmlspecialchars($post['content'])); ?></p><br>
        </div>
            
        <form class="comment-section" action="comment.php" method="GET">
            <label for="comment-input">
                <i class="fas fa-comment"></i>
            </label>
            

            <?php 
            if (!empty($_SESSION['username'])) 
            { 
                ?>
                <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
                <input type="text" id="comment-input" name="com" placeholder="Write your comment here..." required />
                <button name="comment" type="submit" class="comment-btn">Submit</button>
                <?php 
            } 
            else 
            {   
                ?>
                <input type="text" id="comment-input" placeholder="Write your comment here..." required />
                <button class="comment-btn">First login to Add comment</button>
                <?php
            }
            ?>
        </form>
        <div class="comments-container">
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <p><strong><?php echo htmlspecialchars($comment['username']); ?>:</strong></p>
                    <p><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                    <hr>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="share-container">
            <button type="button" class="share-button"
                onclick="document.getElementById('share-buttons').style.display = (document.getElementById('share-buttons').style.display === 'none' || document.getElementById('share-buttons').style.display === '') ? 'block' : 'none';">
                Share
            </button>
            <div id="share-buttons" class="share-buttons">
                <p>Share this product:</p>
                <a href="https://www.facebook.com/sharer/sharer.php?u=http://192.168.1.80/http://localhost/Blogging/blog.php?id=<?php echo $id; ?>"
                    target="_blank">
                    <img src="images/sharefb.png" alt="Share on Facebook" class="social-icon">
                </a>
                <a href="https://wa.me/?text=http://localhost/Blogging/blog.php?id=<?php echo $post['id']; ?>"
                    target="_blank">
                    <img src="images/sharewb.jpg" alt="Share on WhatsApp" class="social-icon">
                </a>
                <a href="https://twitter.com/intent/tweet?url=http://192.168.1.80/http://localhost/Blogging/blog.php?id=<?php echo $post['id']; ?>" target="_blank">
                    <img src="images/sharetw.png" alt="Share on Twitter" class="social-icon">
            </a>

            </div>

        
         <!-- Full content -->
        <a href="index.php" class="back-btn">Back to Home</a>
    </main>
</div>


    <?php include('common/footer.php'); ?>
</body>
</html>
