<?php

    include '../db_connect.php';

    // 1. SECURITY CHECK: Beginners should always check if the cokies exists.
    // If the user isn't logged in, $_COOKIE['user_id'] won't exist and the page will crash.
    // We check $_COOKIE instead of $_SESSION
    if (!isset($_COOKIE['user_id'])) {
        header("Location: login_with_cookies.php");
        exit();
    }

    $user_id = $_COOKIE['user_id'];
    $username = $_COOKIE['username'];

    // Prepare query for this specific user
    $stmt = $conn->prepare("SELECT * FROM items WHERE user_id = ?");
    $stmt->execute([$user_id]);
?>

<!DOCTYPE html>
<html>
<body>
    <h1>Welcome, <?php echo $username; ?> (via Cookie)</h1>
    <p>Your Items:</p>
    <ul>
        <?php while($row = $stmt->fetch()){ ?>
            <li><?php echo $row['name']; ?> - $<?php echo $row['price']; ?> -  <a href="delete.php?id=<?php echo $row["id"]; ?>">Delete</a></td>
</li>
        <?php } ?>
    </ul>
    <a href="logout_with_cookies.php">Logout</a>
</body>
</html>