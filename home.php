<?php
    include 'db_connect.php';

    
    $stmt = $conn->prepare("SELECT * FROM posts ORDER BY created_at DESC");
    $stmt->execute();
?>

<!DOCTYPE html>
<html>
<body>
    <h1>Global Feed</h1>
    <nav>
        <a href="index.php" >Home</a> | 
        <a href="search.php" >Search</a> | 
    </nav>
    
    <table border='1'>
        <tr>
            <th>Post ID</th>
            <th>User ID</th>
            <th>Post</th>
            <th>Image</th>
            <th>Date</th>
        </tr>

        <?php 
        
        while($row = $stmt->fetch()){ ?>
        <tr>
            <td><?php echo $row['post_id'] ?></td>
            <td><?php echo $row['user_id'] ?></td>
            <td><?php echo $row['post_text'] ?></td>
            <td><img src="uploads/<?php echo $row['image_path']; ?>" width="150"></td>
            <td><?php echo $row['created_at'] ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
