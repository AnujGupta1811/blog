<?php
include('common/connection.php');
// Facebook login
$fb = new Facebook\Facebook([
    'app_id' => '566760639149464', // your app id
    'app_secret' => 'a5d8192b659205735c7c4afe254aa30b', // your app secret
    'default_graph_version' => 'v2.4',
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // optional

try {
    if (isset($_SESSION['facebook_access_token'])) {
        $accessToken = $_SESSION['facebook_access_token'];
    } else {
        $accessToken = $helper->getAccessToken();
    }
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (isset($accessToken)) {
    // Set default access token
    $fb->setDefaultAccessToken((string) $accessToken);
    
    // Getting basic info about user
    try {
        $profile_request = $fb->get('/me?fields=name,email');
        $profile = $profile_request->getGraphUser();

        $fbid = $profile->getProperty('id');
        $fbfullname = $profile->getProperty('name');
        $fbemail = $profile->getProperty('email');
		
$_SESSION['fbid'] = $fbid.'</br>';
$_SESSION['fbname'] = $fbfullname.'</br>';
$_SESSION['fbemail'] = $fbemail.'</br>';
        // If you have a profile picture URL:
        // Check if the user already exists
        $stmt = $connect->prepare("SELECT * FROM signup WHERE email=?");
        $stmt->bind_param("s", $fbemail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // User does not exist, insert new user
            $insert_stmt = $connect->prepare("INSERT INTO signup (name, email, is_verified) VALUES (?, ?, 1)");
            $insert_stmt->bind_param("ss", $fbfullname, $fbemail);
            $insert_stmt->execute();
            $insert_stmt->close();
        }

        // Log the user in
        $_SESSION['username'] = $fbfullname;
        header('Location: index.php');
        exit();

    } catch (Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
} else {
    // Generate login URL
    $loginUrl = $helper->getLoginUrl('http://localhost/Blogging/', $permissions);
}




?>