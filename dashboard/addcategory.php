<?php
session_start();
include("../common/connection.php");
include('../class/loginc.php');
$obb = new User($connect);
$delete = new Delete($connect);

$category = ""; 
$action = "add"; 
$buttonLabel = "Add Category"; 


if (isset($_GET['log'])) {
    session_destroy();
    header('Location: ../index.php');
    exit();
}


if (isset($_GET['eid'])) {
    $id = $_GET['eid'];
    $user = $obb->getcategory($id);
    if ($user) {
        $category = $user['category_name'];   
        $action = "edit";
        $buttonLabel = "Update Category";
    } else {
        header('Location: addcategory.php?lag=1&msg=Error loading category.');
        exit();
    }
}


if (isset($_GET['did'])) {
    $deleteResult = $delete->deleteCategory($_GET['did']);
    if ($deleteResult) {
        header('Location: addcategory.php?lag=1&msg=Category deleted successfully.');
    } else {
        header('Location: addcategory.php?lag=1&msg=Error deleting category.');
    }
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];

    if ($action === "edit" && isset($_POST['eid'])) {
        $id = $_POST['eid'];
        $updateResult = $obb->updatecategory($category, $id);
        if ($updateResult) {
            header('Location: addcategory.php?lag=1&msg=Category%20updated%20successfully.');
        } else {
            header('Location: addcategory.php?lag=1&msg=Error updating category.');
        }
    } else {
        $addResult = $obb->addcategory($category);
        if ($addResult) {
            header('Location: addcategory.php?lag=1&msg=Category added successfully.');
        } else {
            header('Location: addcategory.php?lag=1&msg=Error adding category.');
        }
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogging Website - Add/Edit Category</title>
    <link rel="stylesheet" href="../css/styles.css?v=1.3">
    <link rel="stylesheet" href="../css/dashboard.css?v=1.1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<header>
    <?php include("header.php"); ?>

</header>

    <div class="container">
        <?php include('../common/category.php'); ?>
        
        <main class="content">    
            <h2><?php echo ($action === 'edit') ? 'Edit Category' : 'Add New Category'; ?></h2><br>
            <div class="add-category-form">
                <!-- Category Form -->
                <form action="addcategory.php<?php echo ($action === 'edit') ? '?eid=' . $_GET['eid'] : ''; ?>" method="POST">
                    <label for="category_name">Category Name:</label>
                    <input type="text" id="category_name" name="category" value="<?php echo htmlspecialchars($category); ?>" required>
                    <?php if ($action === 'edit'): ?>
                        <input type="hidden" name="eid" value="<?php echo $_GET['eid']; ?>">
                    <?php endif; ?>
                    <button type="submit"><?php echo $buttonLabel; ?></button>
                </form>
            </div>

            <table>
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
                    $data = $obb->getcategory(); 
                    foreach ($data as $user) {
                        echo "<tr>
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
                    } ?>
                </tbody>
            </table>
        </main>
    </div>
    <?php include('../common/footer.php'); ?>
</body>
</html>

