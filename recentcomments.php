<?php
    session_start();
    require 'common/connection.php';
    $query = "SELECT c.username,c.post_id, c.comment, c.created_at, b.title AS post_title 
    FROM comment c 
    JOIN blogs b ON c.post_id = b.id 
    ORDER BY c.created_at DESC";
    $result = $connect->query($query);
?>
<html>
    <head>
        <title>Comments</title>
        <link rel="stylesheet" href="css/dashboard.css">
        <link rel="stylesheet" href="css/styles.css?v=1.1">
    </head>
    <body>
        <header>
            <div class="logo-container">
                <img src="images/logo.jpg" alt="Website Logo" class="logo">
                <h1>Recent Comments</h1>
                <nav>
                    <ul>
                        <li><a href="home.php">Home</a></li>
                        <li></li>
                        <li>
                            <div class="btn">
                                <?php if (empty($_SESSION['username'])) { ?>
                                    <a href="login.php"><input type="button" value="Log in"></a>
                                <?php } else { ?>
                                    <a href="index.php?log=1"><input type="button" value="Log Out <?php echo $_SESSION['username']; ?>"></a>
                                <?php } ?>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="table-container">
                <h2>Comments Details</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Comment On</th>
                            <th>Comment</th>
                            <th>Time</th>
                            <th>View Post</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                                    <td><?php echo htmlspecialchars($row['post_title']); ?></td>
                                    <td><?php echo htmlspecialchars($row['comment']); ?></td>
                                    <td><?php echo date('F d, Y h:i A', strtotime($row['created_at'])); ?></td>
                                    <td><a href="blog.php?id=<?php echo $row['post_id']; ?>">View Post</a></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No comments found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php include("common/footer.php"); ?>
    </body>
</html>