<?php
    include("common/connection.php");

if (isset($_POST['query'])) {
    $search = mysqli_real_escape_string($connect, $_POST['query']);
    $query = "SELECT title FROM blogs WHERE title LIKE '%$search%' LIMIT 5";
    $result = mysqli_query($connect, $query);
    
    if (mysqli_num_rows($result) > 0) {
        echo '<ul>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<li>' . $row['title'] . '</li>';

        }
        echo '</ul>';
    } else {
        echo '<ul><li>No results found</li></ul>';
    }
}
?>
