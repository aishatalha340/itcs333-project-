<?php
include 'db_connect.php';

// 1. GET PHASE: When the page first loads, we grab the item ID from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // We fetch the current data so we can put it inside the form input boxes
    $stmt = $conn->prepare("SELECT * FROM items WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}

// 3. POST PHASE: When the user clicks "Update", we save the new values
if ($_SERVER['REQUEST_METHOD'] == 'POST') {     //or, we can write it as: // if(isset($_POST['submit'])){ ... }
    // We need the ID from the hidden input to know WHICH record to update
    $id = $_POST['id']; 
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Basic validation to ensure the user didn't leave fields empty or enter text in number fields
    if (empty($name) || !is_numeric($quantity) || !is_numeric($price)) {
        echo "Invalid input!<br/>"; 
    } else {
        // 4. The UPDATE query: Use 'SET' to change specific columns for a specific ID
        $stmt = $conn->prepare("UPDATE items SET name=?, quantity=?, price=? WHERE id=?");
        $stmt->execute([$name, $quantity, $price, $id]);
        
        // After updating, send them back to the list
        header("Location: index.php"); 
    }
}
?>

<!DOCTYPE html>
<html>
<body>
    <h1>Update Item</h1>

    <?php 
        //2. if the item here, we have display it based on the fields.
        //isset(row): can check even if the item does not exist, preventing display an error
        //if(row): check if the item is not null. So better to have both to avoid any errors
        if (isset($row) && $row){ ?>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            
            Name: <input type="text" name="name" value="<?php echo $row['name']; ?>"><br/>
            Quantity: <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>"><br/>
            Price: <input type="number" step="0.01" name="price" value="<?php echo $row['price']; ?>"><br/>
            
            <button name='submit' type="submit">Update</button>
        </form>
    <?php } else { ?>
        <p>Item not found!</p>
    <?php } ?>
</body>
</html>