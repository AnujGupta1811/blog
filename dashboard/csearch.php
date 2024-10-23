<?php
    session_start();
    include("../common/connection.php");
    include('../class/loginc.php');
    $obb = new User($connect);

    $query = $_GET['query'] ?? ''; 
    $result=$obb->csearch($query);
    ?>
    <table border="1">
        <thead>
        <tr>
            <th>Category ID</th>
            <th>Category Name</th>
            <th>Adding Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            <?php 
            if (empty($result)) {
                echo "<tr><td colspan='4'>No results found</td></tr>";
            } 
            else
            {
                foreach ($result as $user) 
                {
            
                echo "
                    <tr>
                        <td>{$user['cid']}</td>                              
                        <td>{$user['category_name']}</td>                              
                        <td>" . date('F d, Y', strtotime($user['created_at'])) . "</td>
                        <td>
                            <div class='action-buttons'>
                                <a href='addcategory.php?lag=1&eid=" . $user['cid'] . "' class='edit-btn'>Edit</a>/
                                <a href='addcategory.php?lag=1&did=" . $user['cid'] . "' class='delete-btn'>Delete</a>
                            </div>
                        </td>
                    </tr>";
                }
            }
     ?>
    </tbody>
    <table>
    

