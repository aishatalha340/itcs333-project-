<?php
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // 1. Validation Logic: Ensure data meets minimum security requirements
    $flag = true;
    $message ="";
    if(empty($username) || empty($password) || empty($cpassword)){
        $flag= false;
        $message .= "Some fields are empty </br>";
    }
    
    // Security Tip: Longer usernames/passwords are harder for hackers to guess
    if(strlen($username) < 3){
        $flag= false;
        $message .= "Username must be more than 3 characters <br/>";
    }

    if(strlen($password) < 8){
        $flag= false;
        $message .= "Password must be at least 8 characters <br/>";
    }

    // 2. Data Integrity: Ensure the user typed the same password twice
    if(!($password == $cpassword)){
        $flag= false;
        $message .= "Password and Confirm password do not match! <br/>";
    }
    
    if($flag) {
        /* 3. WHY USE HASHING? 
           We never store passwords as plain text. If a hacker steals the database, 
           they only see a "hash" (a long string of random characters).
           
           MD5 vs SHA-256:
           - MD5 is old and "weak." Modern computers can crack MD5 hashes in seconds.
           - SHA-256 is much more complex and mathematically stronger. It is currently 
             the standard for modern web applications to keep data secure.
        */
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        
        // We hash the password BEFORE it ever hits the database
        //$hashedPassword = hash('md5', $password);  //<- not recommended, weak hash
        $hashedPassword = hash('sha256', $password); 
        $stmt->execute([$username, $hashedPassword]); 
        
        $message ="User Created!";
    }
}
?>

<!DOCTYPE html>
<html>
<body>
    <h1>Register | Sign up</h1>
    <form method="POST" action="">
        Username: <input type="text" name="username"><br/>
        Password: <input type="password" name="password"><br/>
        Confirm Password: <input type="password" name="cpassword"><br/>
        <button name='submit' type="submit">Sign up</button>
    </form>

    <?php if(isset($message)) echo $message; ?>
</body>
</html>