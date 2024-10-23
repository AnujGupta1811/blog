<?php
ob_start();

session_start();
include("common/connection.php");
include('class/loginc.php');

$obb = new User($connect);

if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $post = $obb->readmore();
    $comments = $obb->comdisplay($_GET['id']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title'] ?? 'Blog Post'); ?> - Blog Website</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        h1 {
            font-size: 24px;
            color: #444;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            font-size: 14px;
            line-height: 1.5;
            color: #555;
        }

        .blog-content p {
            margin-bottom: 10px;
        }

        .image-excerpt-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .blog-post-image {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            padding: 5px;
            margin-bottom: 15px;
        }

        .excerpt {
            margin-top: 10px;
            text-align: justify;
        }
    </style>
</head>
<body>
    <div class="container">
        <main class="blog-content">
            <h1><?php echo htmlspecialchars($post['title'] ?? 'Untitled'); ?></h1>
            <p><strong>By:</strong> <?php echo htmlspecialchars($post['author'] ?? 'Unknown'); ?> | <strong>Date:</strong> <?php echo isset($post['created_at']) ? date('F d, Y', strtotime($post['created_at'])) : 'N/A'; ?></p>
            
            <div class="image-excerpt-container">
                <?php if (!empty($post['image'])): ?>
                    <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title'] ?? 'Image'); ?>" class="blog-post-image">
                <?php endif; ?>
                <p class="excerpt"><?php echo nl2br(htmlspecialchars($post['excerpt'] ?? '')); ?><br>
                <?php echo nl2br(htmlspecialchars($post['content'] ?? '')); ?></p>
            </div>
        </main>
    </div>
</body>
</html>

<?php


$html = ob_get_clean();

require 'pdf/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();

// Write HTML content to PDF
$mpdf->WriteHTML($html);

// Output the PDF to browser
$mpdf->Output('blog_post.pdf', 'I');
?>
