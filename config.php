<?php
$connect = mysqli_connect("localhost", "root", "", "blogging") or die("Connection Failed: " . mysqli_connect_error());
require_once 'vendor/autoload.php';

// Google API Client Setup
$clientID = '498126298507-fct58uadpo372ep1pol3bsosqgtaj870.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/Blogging/index.php';

$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);
        $_SESSION['access_token'] = $token['access_token'];

        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $name = $google_account_info['name'];
        $email = $google_account_info['email'];

        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;

        // Check if the user already exists
        $query = "SELECT * FROM signup WHERE email = ?";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // User does not exist, insert new user
            $insert_query = "INSERT INTO signup (name, email, is_verified) VALUES (?, ?, 1)";
            $insert_stmt = $connect->prepare($insert_query);
            $insert_stmt->bind_param("ss", $name, $email);
            
            if ($insert_stmt->execute()) {
                echo "User inserted successfully.";
            } else {
                echo "Error inserting user: " . $insert_stmt->error;
            }

            $insert_stmt->close();
        } else {
            echo "User already exists.";
        }

        // Log the user in by setting session variables
        $_SESSION['username'] = $name; // Use the username for logged-in state
        header('Location: index.php');
        exit();
    } else {
        echo "Error fetching access token: " . $token['error'];
    }
}
?>
