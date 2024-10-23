<?php
session_start(); 
include("common/connection.php");

if (empty($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
if (isset($_GET['id'])) {
    $blogId = $_GET['id']; 

    $checkQuery = "SELECT * FROM blogs WHERE id = $blogId";
    $checkResult = mysqli_query($connect, $checkQuery);

    if (!$checkResult || mysqli_num_rows($checkResult) === 0) {
        // Blog not found
        header("Location: admin.php?error=Blog not found.");
        exit();
    }

    $query = "UPDATE blogs SET status = 1 WHERE id = $blogId";
    $updateResult = mysqli_query($connect, $query);

    if ($updateResult && mysqli_affected_rows($connect) > 0) {
        header("Location: admin.php?success=Blog approved successfully!");
        exit();
    } else {
        $errorMessage = "Blog might already be approved or no changes made.";
        header("Location: admin.php?error=" . urlencode($errorMessage));
        exit();
    }
} else {
    header("Location: admin.php?error=No blog ID provided.");
    exit();
}
?>
