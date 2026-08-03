<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
        
    $host = "localhost";    
    $user = "root";         
    $password = ""; 
    $database = "itcs333_blog";   

    
    try {
       
        $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);

       
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       

    } catch (PDOException $e) {
       
        die("Connection failed: " . $e->getMessage());
    }
?>