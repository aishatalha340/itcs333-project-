<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$current_userID= $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT *  FROM posts  WHERE post_id = ? AND user_id = ?");
    $stmt->execute([$id,$current_userID]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {     
    $id = $_POST['id'];

    
    $stmt = $conn->prepare("DELETE FROM posts WHERE post_id = ? AND user_id=?");
    $stmt->execute([$id, $current_userID]);
    header("Location: index.php");  
    
}
?>

<!DOCTYPE html>
<html>
<body>
    <h1>Delete Post</h1>
    <?php 
        
        if (isset($row) && $row){ ?>
        <p> Are you sure you want to delete ?</p>
        <ul>
            <li>Author:  <?php echo $row['user_id']; ?></li>
            <li>Post Text: <?php echo $row['post_text']; ?></li>
            <li>TimeStamp: <?php echo $row['created_at']; ?></li>
            <li><div>
                    <img src="<?php echo $row['image_path']; ?>" alt="Post Image" style="max-width: 400px; height: auto;">
                </div></li>
        </ul>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $row['post_id']; ?>">
            <button name='delete_btn' type="submit">Yes, Delete</button>
        </form>

        
        <button onclick="history.go(-1)" >Cancel</button>

        
    <?php }else{ ?>
        <p>Item not found!</p>
    <?php } ?>
</body>
</html>
