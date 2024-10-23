<?php
include('common/connection.php');
include('class/loginc.php');
$obb = new User($connect);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $obb->addpost();
}
