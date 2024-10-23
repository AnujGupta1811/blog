<header>
    <div class="header-container">
        <div class="logo-container">
            <img src="images/logo.jpg" alt="Website Logo" class="logo">
            <h1>BLOGGED WEBSITE</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact us</a></li>
                <li><a href="dashboard/dashboard.php">Dashboard</a></li>
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
                <form action="search.php" method="GET">
                    <input type="text" name="query" id="search" placeholder="Search..." autocomplete="off" required>
                    <button type="submit">Search</button>
                    <div id="suggestions"></div>

                </form>
            </div>
        </nav>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#search').on('input', function() {
            var query = $(this).val();
            if (query != "") {
                $.ajax({
                    url: "autos.php",
                    method: "POST",
                    data: {query: query},
                    success: function(data) {
                        $('#suggestions').fadeIn();
                        $('#suggestions').html(data);
                    }
                });
            } 
            else
            {
                $('#suggestions').fadeOut();
            }
        });

        // Hide suggestions when an item is clicked
        $(document).on('click', 'li', function() {
            $('#search').val($(this).text());
            $('#suggestions').fadeOut();
        });
    });
</script>


</header>


