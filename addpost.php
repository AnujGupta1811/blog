<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post</title>
    <link rel="stylesheet" href="css/post.css?v=1.1">
    <script src="https://cdn.tiny.cloud/1/cryl9extu64qm6m5abvkf98a4e2ut37sqxw7koum5kw2d9do/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="scripts.js" defer></script>

</head>
<body>
    <div class="form-container">
        <h1>Add New Post</h1>
        <form id="addPostForm" action="post.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="postTitle">Title:</label>
                <input type="text" id="postTitle" name="title" required>
            </div>
            <div>
                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <option value="clothes">Clothes</option>
                    <option value="electronics">Electronics</option>
                    <option value="books">Books</option>
                    <option value="furniture">Furniture</option>
                    <option value="sports">Sports</option>
                    <option value="accessories">Accessories</option>
                </select>
            </div>
            <div>
                <label for="author">Author:</label>
                <input type="text" id="author" name="author" required>
            </div>
            <div>
                <label for="excerpt">Excerpt:</label>
                <input type="text" id="excerpt" name="excerpt" required>
            </div>
            <div>
                <label for="summary">Post Summary:</label>
                <textarea id="summary" name="content" rows="3" required></textarea>
            </div>
            
            <div>
                <label for="image">Upload Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <div>
                <label for="content">Content:</label>
                <textarea id="content" name="content"></textarea>
            </div>
            <div>
                <?php if (empty($_SESSION['username'])) { ?>
                    <a href="login.php"><input type="button" style="background-color:#218838" value="First Login to Add Post"></a>
                <?php } 
                else 
                { ?>
                    <input type="submit" name="addpost" style="background-color:#218838" value="Add Post">
                <?php } ?>
            </div>
        </form>
    </div>
</body>
</html>
