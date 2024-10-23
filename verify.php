<?php
session_start();
include('common/connection.php');
include('class/loginc.php');
$obb = new User($connect);

if (isset($_GET['token'])) {
    $obb->verify();
} else {
    echo "No token provided.";
}
?>
