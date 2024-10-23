<?php
    ob_start();
    session_start(); 
    include("common/connection.php");
    include('class/loginc.php');
    $obb = new User($connect);
    $blogs=$_SESSION['blogs'];
    ?>
    <section class="blog-posts">
    <?php 
        foreach ($blogs as $blog) 
        {
            echo "<article class='blog-post'>
                    <img src='{$blog['image']}' alt='{$blog['title']}' class='blog-image'>
                        <div class='blog-content'>
                            <h3>" . $blog['title'] . "</h3>
                            <p><strong>By:</strong> " . $blog['author'] . " | <strong>Date:</strong> " . date('F d, Y', strtotime($blog['created_at'])) . "</p>
                            <p>" . $blog['excerpt'] . "</p>
                            
                        </div>
                </article>";
        } ?>

<style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: auto;
            padding: 0;
            text-align:center;
        }
        h1 {
            text-align: center;
            color: #007BFF;
        }
        .blog-post {
            margin-bottom: 30px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 20px;
        }
        .blog-image {
            width: 70%;
            height: 50%;
            margin-bottom: 10px;
        }
        .blog-content h3 {
            font-size: 20px;
            margin: 0 0 10px 0;
        }
        .blog-content p {
            font-size: 14px;
            line-height: 1.6;
            margin: 5px 0;
        }
        .blog-meta {
            color: #555;
            font-style: italic;
        }
    </style>
</section>
<?php


$html = ob_get_clean();

require 'pdf/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();

// Write HTML content to PDF
$mpdf->WriteHTML($html);

// Output the PDF to browser
$mpdf->Output('blog_post.pdf', 'I');
?>
