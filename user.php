<?php
    session_start();
    require 'common/connection.php';
    $query="select * from signup";
    $result=mysqli_query($connect,$query);

?>
<html>
    <head>
        <title>All Users</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard - Blog Website</title>
        <link rel="stylesheet" href="css/dashboard.css">
        <link rel="stylesheet" href="css/styles.css?v=1.1">
    </head>
    </body>
    <header>
        <div class="logo-container">
            <img src="images/logo.jpg" alt="Website Logo" class="logo">
            <h1>Blog Dashboard</h1>
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
                            <th>Id</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Created_at</th>
                            <th>Is_Verified</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo date('F d, Y h:i A', strtotime($row['created_at'])); ?></td>
                                    <td><?php echo $row['is_verified']; ?></td>
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