<?php

include 'db_connect.php';

// 1. CONFIRMATION PHASE: Fetch the item details so the user knows exactly WHAT they are deleting
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT *  FROM items  WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}

// 3. DELETION PHASE: This only runs if the user clicks the "Yes, Delete" button inside the POST form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {     //// or if (isset($_POST['delete_btn'])) {
    $id = $_POST['id'];

    // 4. The DELETE query: BE CAREFUL! Always use a WHERE clause or you will delete everything!
    $stmt = $conn->prepare("DELETE FROM items WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");  // Redirect
    // Output: No echo, but deletes and redirects
}
?>

<!DOCTYPE html>
<html>
<body>
    <h1>Delete Item</h1>
    <?php 
        // 2. Display the item to confirm its deletion
        //isset(item): can check even if the item does not exist, preventing display an error
        //if(item): check if the item is not null. So better to
        if (isset($row) && $row){ ?>
        <p> Are you sure you want to delete ?</p>
        <ul>
            <li>Name:  <?php echo $row['name']; ?></li>
            <li>Quantity: <?php echo $row['quantity']; ?></li>
            <li>Price: <?php echo $row['price']; ?></li>
        </ul>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <button name='delete_btn' type="submit">Yes, Delete</button>
        </form>

        <!-- history.go(-1), allow you to go one page back. Act like cancel here  :D
        Better to put it outside of the form to avoid triggering form submission -->
        <button onclick="history.go(-1)" >Cancel</button>

        <!-- Output: Shows confirmation form, e.g., Delete Apple (Quantity: 10, Price: 1.5, User: alice)? -->
    <?php }else{ ?>
        <p>Item not found!</p>
    <?php } ?>
</body>
</html>