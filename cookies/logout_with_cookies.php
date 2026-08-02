<?php
/* To delete a cookie, we set the expiration time to 1 hour ago (past).
   The browser will see it is expired and delete it immediately.
*/

setcookie("user_id", "", time() - 3600);
setcookie("user_name", "", time() - 3600);
setcookie("user_role", "", time() - 3600);

// Redirect back to the login page
header("Location: login_with_cookies.php");
exit();
?>