<?php
    include '../db_connect.php';
    
    // 1. Start a session: This is required to access the $_SESSION array
    session_start();

    // 2. SECURITY CHECK: Beginners should always check if the session exists.
    // If the user isn't logged in, $_SESSION['user_id'] won't exist and the page will crash.
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php"); // Send them to login if they aren't authorized
        exit(); // Stop the script here
    }

    /* 3. The Query:
       We use 'WHERE user_id = ?' to ensure users only see THEIR own items.
       Without this, every user would see every item in the database.
    */
    $stmt = $conn->prepare("SELECT * FROM items WHERE user_id = ?");
    
    /* 4. Execute: 
       We pass the ID saved in the session during login.php.
    */
    $stmt->execute([$_SESSION['user_id']]);
?>

<!DOCTYPE html>
<html>
<body>
    <h1>My Profile (My Items)</h1>
    <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
    
    <nav>
        <a href="create.php">Create new item</a> | 
        <a href="index.php">View All Items</a> |
        <a href="logout.php">Logout</a>
    </nav>
    
    <table border='1'>
        <tr>
            <th>ID</th><th>Name</th><th>Quantity</th><th>Price</th><th>Actions</th>
        </tr>

        <?php 
        // 5. Fetch Loop: Standard way to display rows one by one
        while($row = $stmt->fetch()){ ?>
        <tr>
            <td><?php echo $row['id'] ?></td>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['quantity'] ?></td>
            <td><?php echo $row['price'] ?></td>
            <td>
                <a href="delete.php?id=<?php echo $row["id"]; ?>">Delete</a></td>

            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
