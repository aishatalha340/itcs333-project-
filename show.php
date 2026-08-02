<?php
    include 'db_connect.php';

    // 1. Check the URL for an 'id' parameter (e.g., show.php?id=5)
    if(isset($_GET['id'])){
        $id = $_GET['id'];

        // 2. We only want the record matching this specific ID
        $stmt = $conn->prepare("SELECT * FROM items where id = ?");
        $stmt->execute([$id]);
        
        // 3. Fetch the single result (no 'while' loop needed since ID is unique)
        $row = $stmt->fetch();
    }
?>

<!DOCTYPE html>
<html>
<body>
    <h1>Item Details</h1>
    <?php 
        //4. if the item here, we have display it based on the fields.
        //isset(row): can check even if the item does not exist, preventing display an error
        //if(row): check if the item is not null. So better to have both to avoid any errors
        if (isset($row) && $row){ ?>
        <p>ID: <?php echo $row['id'] ?></p>
        <p>Name: <?php echo $row['name'] ?></p>
        <p>Subtotal: $<?php echo $row['price'] * $row['quantity'] ?></p>
    <?php }else{ ?>
        <p>Item not found.</p>
    <?php } ?>
</body>
</html>