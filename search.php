<?php

    include 'db_connect.php';

    $query = ""; 

    if(isset($_GET['query'])){                      
        $query = $_GET['query'];
    }


    $searchTerm = "%$query%"; 

    $stmt = $conn->prepare("SELECT * FROM posts  where post_text LIKE ? "); 
    $stmt->execute([$searchTerm]);
?>


<!DOCTYPE html>
<html>
<body>
    <h1>Search Posts</h1>
    
    <br/>

    <form method='GET' action="">
        Name: <input type='text' name='query' />
        <input type='submit' value='Search' />
    </form>
    <br/>

    <table border=1>
        <tr>
            <th>Post ID</th>
            <th>User ID</th>
            <th>Post Text</th>
            <th>Image</th>
            <th>Date</th>
        <tr>

        <?php 
        
            while($row = $stmt->fetch()){ ?>
        <tr>
            <td><?php echo $row['post_id'] ?></td>
            <td><?php echo $row['user_id'] ?></td>
            <td><?php echo $row['post_text'] ?></td>
            <td><img src="uploads/<?php echo $row['image_path']; ?>" width="150"></td>
            <td><?php echo $row['created_at'] ?></td>
        <tr>
        <?php } ?>

    </table>

    
</body>
</html>