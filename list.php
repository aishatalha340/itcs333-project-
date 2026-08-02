<?php
    include 'db_connect.php';

    // 1. Prepare the query to select all records from the 'items' table
    $stmt = $conn->prepare("SELECT * FROM items");
    $stmt->execute();
?>

<!DOCTYPE html>
<html>
<body>
    <h1>Items List</h1>
    <nav>
        <a href="create.php" >Create new item</a> | 
        <a href="index.php" >Index</a> | <!-- index.php is the default name for the first page to open in any php folder -->
        <a href="search.php" >Search for items</a> |
        <a href="search_by_username.php" >Search by username</a> |
        <a href="list.php" >List items</a> 
    </nav>
    
    <table border='1'>
        <tr>
            <th>ID</th><th>Name</th><th>Quantity</th><th>Price</th><th>Show</th>
        </tr>

        <?php 
        /* 2. The Fetch Loop:
           $stmt->fetch() grabs one row at a time. 
           The 'while' loop continues as long as there is data left in the database.
        */
        while($row = $stmt->fetch()){ ?>
        <tr>
            <td><?php echo $row['id'] ?></td>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['quantity'] ?></td>
            <td><?php echo $row['price'] ?></td>
            <td><a href="show.php?id=<?php echo $row["id"]; ?>">View Details</a></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>