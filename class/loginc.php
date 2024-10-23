<?php
class User {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection; 
    }
    public function signup($name, $email, $password) {
        $token = bin2hex(random_bytes(16));
        $sql = "INSERT INTO signup (name, email, password, verification_token) VALUES ('$name', '$email', '$password', '$token')";
        if (mysqli_query($this->conn, $sql)) {
            $mess=$this->send($email, $token);
            return $mess;
        } else {
            return "Signup not successful: ";
        }
    }

    private function send($to, $token)
    {
        $subject = "Email Verification";  
        $message = "Click here to verify your email: http://localhost/Blogging/verify.php?token=$token";
        $headers = 'From: anuisahu309@gmail.com' . "\r\n" .
                   'Reply-To: anuisahu309@gmail.com' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        if(mail($to, $subject, $message, $headers)){  
            return "Signup successful! And Verification email sent successfully...";  
        } else {  
            echo "Sorry, unable to send email...";  
        }  
    }
    function login($username, $password) {
        $sql = "SELECT * FROM signup WHERE name='$username'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) 
        {
            $user = $result->fetch_assoc();
            if ($user['is_verified'] == 1) {
                session_start();
                $_SESSION['username'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['user_data'] = $user;
                header('Location: index.php');
            } 
            else 
            {
                return 'Please verify your email'; 
            }
        } 
        else 
        {
            return 'No user found with this email'; 
        }
    }
    function display($category) 
    {
        $sql = "SELECT * FROM blogs WHERE category = '$category' and status=1 ORDER BY created_at DESC"; 
        $result = $this->conn->query($sql); 
        if ($result->num_rows > 0) 
        {
            $blogs = [];
            while ($blog = $result->fetch_assoc()) 
            {
                $blogs[] = $blog; 
            }
           
            $_SESSION['blogs']=$blogs;
            return $blogs;
            
        } 
        else 
        {
            return []; 
        }
    }
    function contact()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        global $token;
        // Insert data into the database
        $sql = "INSERT INTO contact (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
        if (mysqli_query($this->conn,$sql)) {
            $this->send($email, $token); 
            echo "<script>alert('Message sent successfully!'); window.location.href = 'index.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $connect->error;
        }
    
        $connect->close();
    }
    function addpost()
    {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $category = $_POST['category'];
        $content = $_POST['content'];
        $excerpt = $_POST['excerpt'];
        $image_path = "";

        if (!empty($_FILES['image']['name'])) {
            $target_dir = "uploads/";
            $image_name = basename($_FILES['image']['name']);
            $image_path = $target_dir . $image_name;
            move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
        }

        $sql = "INSERT INTO blogs (title, author, category ,content, image, excerpt) 
                VALUES ('$title', '$author', '$category', '$content' , '$image_path', '$excerpt')";

        if (mysqli_query($this->conn,$sql)) 
        {
            echo "<script>alert('New post added successfully!'); window.location.href='index.php?category=$category';</script>";
        }
        $connect->close();
    }
    function about()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        global $token;
    
        $stmt = $this->conn->prepare("INSERT INTO about_us (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);
    
        if ($stmt->execute()) {
            $this->send($email, $token); 
            echo "<script>alert('Thank you for contacting us!'); window.location.href = 'index.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    
        $stmt->close();
        $connect->close();
    }
    function readmore()
    {
        $postId = intval($_GET['id']); 
        $sql = "SELECT * FROM blogs WHERE id = $postId";
        $result = mysqli_query($this->conn,$sql);
    
        if ($result->num_rows == 1) {
            $post = $result->fetch_assoc();
            return $post;
        } 
        else
        {
            header('Location: index.php');
            exit();
        }
    }
    function verify()
    {
        $token = $_GET['token'];
        $query = "UPDATE signup SET is_verified = 1 WHERE verification_token = '$token'";
        if (mysqli_query($this->conn, $query)) {
            echo "Your email has been verified. You can now log in.";
            ?>
            <a href="login.php"><input type="button" style="background-color: #2196f3;color:white;width:80px;" value="Login"/></a>
            <?php
        } 
        else
        {
            echo "Verification failed. Please try again.";
        }
    }
    public function comment($com,$id,$username)
    {
        $query="insert into comment (comment,post_id,username) values('$com',$id,'$username')";
        $result=mysqli_query($this->conn,$query);
        if($result)
        {
            return 'Comment added Successfully.';
        }
        else
        {
            return 'Failed To add Comment';
        }
    }
    public function comdisplay($post_id) {
        $query = "SELECT * FROM comment WHERE post_id = ? ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }
        return $comments;
    }
    public function homedisplay($category = null) 
    {
        $query = "SELECT * FROM blogs WHERE status = 1 LIMIT 0, 5"; // Limit the results here too
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function searchBlogs($query) {
        $sql = "SELECT * FROM blogs WHERE title LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $likeQuery = "%" . $query . "%";
        $stmt->bind_param("s", $likeQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function csearch($query)
    {
        $sql = "SELECT * FROM categories WHERE category_name  LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $likeQuery = "%" . $query . "%";
        $stmt->bind_param("s", $likeQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function admindisplay($category = null) {
        if ($category) {
            $query = "SELECT * FROM blogs WHERE category = ? and status=?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("si", $category,1);
        } else {
            $query = "SELECT * FROM blogs where status=0"; 
            $stmt = $this->conn->prepare($query);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        
        $rows = $result->fetch_all(MYSQLI_ASSOC);
       
    return $rows;
    }
    function addcategory($category) {
        $query = "INSERT INTO categories (category_name) VALUES ('$category')";
        if ($this->conn->query($query) === TRUE)
        {
            return true; 
        } 
        else 
        {
            return false;
        }
    }
    public function updatecategory($category, $id) {
        $query = "UPDATE categories SET category_name='$category' WHERE cid = $id";
        
        // Execute the query
        $result = mysqli_query($this->conn, $query);
        
        // Return true if the query was successful, otherwise false
        return $result ? true : false;
    }
    
    public function getcategory($id = null) 
    {
        if ($id) {
            // Fetch a single category if an ID is provided
            $query = "SELECT * FROM categories WHERE cid = $id"; // cid is assumed to be the category ID column
            $result = $this->conn->query($query);
            
            if ($result && $result->num_rows > 0) {
                return $result->fetch_assoc(); // Return the single category as an associative array
            } else {
                return null; // Return null if no category is found
            }
        } else {
            // Fetch all categories if no ID is provided
            $query = "SELECT * FROM categories";
            $result = $this->conn->query($query);
            
            if ($result) {
                $data = []; // Initialize an array to hold the category data
                while ($category = $result->fetch_assoc()) {
                    $data[] = $category; // Add each category to the array
                }
                return $data; // Return the array of categories
            } else {
                return []; // Return an empty array if there is an error
            }
        }
    }
}
class Delete
{
    private $conn;

    function __construct($dbConnection) 
    {
        $this->conn = $dbConnection; 
    }
    function deletepost($user_id) {
        $query = "DELETE FROM blogs WHERE id = $user_id";
        if ($this->conn->query($query) === TRUE)
        {
            return true; 
        } 
        else 
        {
            return false;
        }
    }
    function deleteCategory($category_id) {
        $query = "DELETE FROM categories WHERE cid = $category_id";
        if ($this->conn->query($query) === TRUE)
        {
            return true; 
        } 
        else 
        {
            return false;
        }
    }
    function deleteuser($user_id) {
        $query = "DELETE FROM signup WHERE uid = $user_id";
        if ($this->conn->query($query) === TRUE)
        {
            return true; 
        } 
        else 
        {
            return false;
        }
    }
}
?>
