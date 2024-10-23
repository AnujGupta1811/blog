<div class="header-container">
        <div class="logo-container">
            <img src="../images/logo.jpg" alt="Website Logo" class="logo">
            <h1>BLOGGED WEBSITE</h1>
        </div>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../about.php">About</a></li>
                <li><a href="../contact.php">Contact us</a></li>
                <li><a href="../dashboard/dashboard.php">Dashboard</a></li>
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
            <div class="search-container">
                <form action="csearch.php" method="GET">
                    <input type="text" name="query" placeholder="Search..." required>
                    <button type="submit">Search</button>
                </form>
            </div>
        </nav>
    </div>
    <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>