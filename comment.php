<?php
session_start();
include("common/connection.php");
include("class/loginc.php");

$obb = new User($connect);
$id = $_GET['id'];


if (isset($_GET['com']) && $id) {
    $comment = $obb->comment($_GET['com'],$id,$_SESSION['username']);
    echo "<script>alert('$comment');</script>";
    ?>
    <a href="blog.php?id=<?php echo $id; ?>">Back to Previous page</a>
    <?php
}
else{
    header("location:login.php");
}
   

?>
