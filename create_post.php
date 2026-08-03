<?php

session_start();
include 'db_connect.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
   
    $user_id = $_SESSION['user_id'];
    $post_text = $_POST['post_text'];
    $image_path = null;  
    $errors =[];

    $max_size = 10* 1024 *1024;

if((isset($_FILES['image_path'])&& $_FILES['image_path']['size'] <= $max_size )){

$filename_parts = explode('.', $_FILES['image_path']['name']);
$file_ext = (end($filename_parts));

if($file_ext == 'png' || $file_ext == 'jpg'){
$image_path = 'uploads/' . $_FILES['image_path']['name'];
    move_uploaded_file($_FILES['image_path']['tmp_name'], $image_path);
}

if(empty($image_path)){
    $errors['image_path']="Please Upload an image...";
}}


    
if (empty($user_id) || empty($post_text) ) {
 echo "Text field  must be filled!<br/>"; 
    } 
    else {
       
        $stmt = $conn->prepare("INSERT INTO posts (user_id, post_text, image_path) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $post_text, $image_path]);
        header("Location: index.php"); 
    }
}
?>

<!DOCTYPE html>
<html>
<body>

 <nav>
        <a href="index.php" >Home</a> | 
        <a href="search.php" >Search</a> | 
        <a href="create_post.php" >Create Your Post</a> | 

    </nav>
    <h1>Create your Post Here</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="post_text">Post Caption:</label><br>
        <textarea name="post_text" id="post_text" rows="5" cols="40" placeholder="What's on your mind?"></textarea><br>
        <label for="image_path">Upload your post here</label>
        <input type="file" id="image_path" name="image_path"><br>
        <button name='submit' type="submit">Create</button>
    </form>
</body>
</html>
