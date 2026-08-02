<?php
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // 1. Validation Logic: Ensure data meets minimum security requirements
    $flag = true;
    $message ="";
    if(empty($full_name) || empty($email) || empty($password) || empty($cpassword)){
        $flag= false;
        $message .= "Some fields are empty </br>";
    }
    
    // Security Tip: Longer usernames/passwords are harder for hackers to guess
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $flag = false;
    $message .= "Invalid email format <br/>";
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
        $stmt = $conn->prepare("INSERT INTO users (email, password_hash, full_name) VALUES (?, ?, ?)");        
        // We hash the password BEFORE it ever hits the database
        //$hashedPassword = hash('md5', $password);  //<- not recommended, weak hash
        $hashedPassword = hash('sha256', $password);
        $stmt->execute([$email, $hashedPassword, $full_name]);
        
        $message ="User Created!";
    }
}
?>

<!DOCTYPE html>
<html>
<body>
    <h1>Register | Sign up</h1>
    <form method="POST" action="">
        Full Name: <input type="text" name="full_name"><br/>
        Email: <input type="email" name="email"><br/>
        Password: <input type="password" name="password"><br/>
        Confirm Password: <input type="password" name="cpassword"><br/>
        <button name='submit' type="submit">Sign up</button>
    </form>

    <?php if(isset($message)) echo $message; ?>
</body>
</html>