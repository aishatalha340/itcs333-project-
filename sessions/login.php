<?php
include '../db_connect.php';

// Start session to remember the logged-in user
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Basic validation
    $flag = true;
    $message = "";

    if(empty($email) || empty($password)){
        $flag = false;
        $message .= "Some fields are empty <br/>";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $flag = false;
        $message .= "Invalid email format <br/>";
    }

    if(strlen($password) < 8){
        $flag = false;
        $message .= "Password must be at least 8 characters <br/>";
    }

    if($flag) {

        // Check email and hashed password in the database
        $stmt = $conn->prepare(
            "SELECT * FROM users WHERE email = ? AND password_hash = ?"
        );

        $stmt->execute([
            $email,
            hash('sha256', $password)
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row){

            $message = "Welcome ".$row['full_name'];

            // Store logged-in user information in the session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['full_name'] = $row['full_name'];

            // Temporary redirect
            header('location: ../index.php');
            exit;

        } else {
            $message = "Invalid email or password!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<body>

    <h1>Login | Sign in</h1>

    <form method="POST" action="">
        Email: <input type="email" name="email"><br/>
        Password: <input type="password" name="password"><br/>
        <button name="submit" type="submit">Login</button>
    </form>

    <?php if(isset($message)) echo $message; ?>

</body>
</html>