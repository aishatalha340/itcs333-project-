<?php
    session_start();
    include 'db_connect.php';

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

   
    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $stmt = $conn->prepare("SELECT * FROM posts where post_id = ?");
        $stmt->execute([$id]);
        
        $row = $stmt->fetch();
    }
?>

<!DOCTYPE html>
<html>
<body>

    <h1>Post Details</h1>
    <?php 
       
        if (isset($row) && $row){ ?>
        <p>Author: <?php echo $row['user_id'] ?></p>
        <p>TimeStamp: <?php echo $row['created_at'] ?></p>
        <p>Text:<?php echo $row['post_text'] ?></p>

        <?php if (!empty($row['image_path'])): ?>
                <div>
                    <img src="<?php echo $row['image_path']; ?>" alt="Post Image" style="max-width: 400px; height: auto;">
                </div>
            <?php endif; ?>

    <?php }else{ ?>
        <p>Details Not Found.</p>
    <?php } ?>
</body>
</html>
