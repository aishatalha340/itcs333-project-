<?php
include 'db_connect.php';

// 1. Check if the form was actually submitted using the POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    // 2. Collect data from the $_POST superglobal (matches the 'name' attribute in HTML)
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $user_id = 1;  // Hardcoded for now; in a real app, this comes from a session/login

    // 3. Basic validation: Ensure fields aren't empty and numbers are actually numbers
    if (empty($name) || !is_numeric($quantity) || !is_numeric($price)) {
        echo "Invalid input!<br/>"; 
    } else {
        // 4. Prepared Statement: We use '?' placeholders to prevent SQL Injection (security)
        $stmt = $conn->prepare("INSERT INTO items (name, quantity, price, user_id) VALUES (?, ?, ?, ?)");
        
        // 5. Execute: This sends the actual data to the database to replace the '?'
        $stmt->execute([$name, $quantity, $price, $user_id]);

        // 6. Redirect: After saving, send the user back to the list so they don't 
        // accidentally resubmit the form if they refresh the page.
        header("Location: index.php"); 
    }
}
?>

<!DOCTYPE html>
<html>
<body>
    <h1>Create Item</h1>
    <form method="POST" action="">
        Name: <input type="text" name="name"><br/>
        Quantity: <input type="number" name="quantity"><br/>
        Price: <input type="number" step="0.01" name="price"><br/>
        <button name='submit1' type="submit">Create</button>
    </form>
</body>
</html>