<?php
include("common/connection.php");
include('class/loginc.php');
$obb = new User($connect);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $obb->contact();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="css/contact.css?v=1.1">
</head>
<body>
    <!-- Form Section -->
    <div class="form-container">
        <h1>Contact Us</h1>
        <form action="contact.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit">
                <i class="fas fa-paper-plane"></i> Send Message
            </button>
        </form>
    </div>

    <!-- Contact Information Section -->
    <div class="contact-info">
        <h2>Contact Information</h2>
        <p><i class="fas fa-phone"></i> Phone: +1 234 567 890</p>
        <p><i class="fas fa-envelope"></i> Email: contact@blogsite.com</p>
        <p><i class="fas fa-map-marker-alt"></i> Address: 123 Blog St, City, Country</p>
    </div>
</body>
</html>
