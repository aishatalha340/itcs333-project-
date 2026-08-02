<?php
include '../db_connect.php';

// Note: session_start() is NOT needed for cookies.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $flag = true;
    $message ="";
    
    // Basic validation (Same as your original login)
    if(empty($username) || empty($password) ){
        $flag= false;
        $message .= "Some fields are empty </br>";
    }
    
    if($flag) {
        $stmt = $conn->prepare("SELECT * from users where username = ? and password = ?");
        // Using SHA-256 for security as discussed
        $stmt->execute([$username, hash('sha256',$password)]); 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row){
            $message = "Welcome " . $row['username'];

            /* COOKIES METHOD:
               setcookie(name, value, expire, path)
               
               - time() + 3600 means the cookie expires in 1 hour (3600 seconds).
            */
            setcookie("user_id", $row['id'], time() + 3600);
            setcookie("username", $row['username'], time() + 3600);
            setcookie("role", "student", time() + 3600);

            // Students: Unlike sessions, these are stored in the USER'S browser.

            //After login, we can navigate the user to another page.
            header('location: profile_with_cookies.php');

        } else {
            $message = "Invalid username or password!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<body>
    <h1>Login (Using Cookies)</h1>
    <form method="POST" action="">
        Username: <input type="text" name="username"><br/>
        Password: <input type="password" name="password"><br/>
        <button type="submit">Login</button>
    </form>
    <?php if(isset($message)) echo $message; ?>
</body>
</html>