<?php
session_start();
include('common/connection.php');
include('class/loginc.php');
$obb = new User($connect);

if (isset($_POST['signup'])) {
    $message = $obb->signup( $_POST['name'],  $_POST['email'], $_POST['password']);
    echo "<script>alert('$message');</script>";
}

if (isset($_POST['login'])) {
    $username = isset($_POST['un']) ? $_POST['un'] : ''; 
    $password = isset($_POST['pw']) ? $_POST['pw'] : '';  
    $obb->login($username, $password);
}
include('config.php');
include('face.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Slide Navbar</title>
    <link rel="stylesheet" href="css/style2.css?v=1.1">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="main">    
        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="signup">
            <!-- Sign-up form -->
            <form method="POST">
                <label for="chk" aria-hidden="true">Sign up</label>
                <input type="text" name="name" placeholder="User name" required="">
                <input type="email" name="email" placeholder="Email" required="">
                <input type="password" name="password" placeholder="Password" required="">
                <!-- Hidden input to indicate this is the sign-up form -->
                <input type="hidden" name="signup" value="1">
                <button type="submit">Sign up</button>
            </form>
        </div>

        <div class="login">
    <!-- Login form -->
    <form method="POST">
        <label for="chk" aria-hidden="true">Login</label>
        <input type="text" name="un" placeholder="Username" required="">
        <input type="password" name="pw" placeholder="Password" required="">
        <input type="hidden" name="login" value="1">
        <button type="submit" name="login">Login</button>
    </form>
    <!-- Add social login buttons -->
    <div class="social-login">
        
        <a href="<?php echo $client->createAuthUrl(); ?>" class="google-login"><img src="images/gogle.png" alt="Login with Google" style="width: 200px; height: 35px;"/></a>
        <a href="<?php echo $loginUrl; ?>" class="facebook-login"><img src="images/fb1.png" alt="Login with FB" style="width: 200px; height: 37px;,margin:auto;"/></a>
    </div>
</div>

    </div>
</body>
</html>