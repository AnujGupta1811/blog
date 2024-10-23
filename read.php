<?php
sleep(0.1);
include('common/connection.php');

$page = $_POST['page']??1; 
$limit = 4; 
$row = ($page - 1) * $limit; 

$query = "SELECT * FROM blogs LIMIT $row, $limit";
$result = mysqli_query($connect, $query);

$blogs = []; 

if ($result) 
{
    while ($blog = mysqli_fetch_assoc($result)) {
        $blogs[] = $blog; 
    }
} 

if (!empty($blogs)) 
{ 
    foreach ($blogs as $blog) {
        echo "<article class='blog-post'>
                <img src='{$blog['image']}' alt='{$blog['title']}' class='blog-image'>
                <div class='blog-content'>
                    <h3>" . $blog['title'] . "</h3>
                    <p><strong>By:</strong> " . $blog['author'] . " | <strong>Date:</strong> " . date('F d, Y', strtotime($blog['created_at'])) . "</p>
                    <p>" . $blog['excerpt'] . "</p>
                    <a href='readmore.php?id=" . $blog['id'] . "' class='read-more'>Read More</a>
                    <a href='pdf/mpdf.php?id=" . $blog['id'] . "' class='read-more'>Create PDF </a>
                </div>
            </article>";
    }
}
?>
