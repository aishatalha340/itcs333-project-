<?php

//1. start sesson
session_start();

//2. Will distory all the session. forcing logout. The user have to login again
session_destroy();

//3. redirect the user to the login page.
header("Location: login.php");


?>