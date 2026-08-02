<?php

    include 'db_connect.php';

    // We initailly set query to empty.  So it can show us everything when we start.
    $query = ""; 

    // We use get here. Because we want to be able to share the search url or change it from url
    // http://localhost/sites/333/samplecode/search.php?query=apple   <-- se apple at the end is GET URI parameter
    // We change the query here. if there is a value in it.

    // 1. Use $_GET for search so users can bookmark search results or share the link
    if(isset($_GET['query'])){                      
        $query = $_GET['query'];
    }

    // 2. The Wildcard: 
    // $searchTerm = "%$query%" means "find any name that CONTAINS these letters"
    // $searchTerm = "query%" would mean "must START with these letters"
    $searchTerm = "%$query%"; 

    //$stmt = $conn->prepare("SELECT * FROM items where name = ? ");  // For search, we don't user `=`. Because it will look for exact matched query.
    $stmt = $conn->prepare("SELECT * FROM items,users where username like ? AND  items.user_id = users.id ");

    $stmt->execute([$searchTerm]);

?>



<!DOCTYPE html>
<html>
<body>
    <h1>Items List</h1>
    <nav>
        <a href="create.php" >Create new item</a> | 
        <a href="index.php" >Index</a> | <!-- index.php is the default name for the first page to open in any php folder -->
        <a href="search.php" >Search for items</a> |
        <a href="search_by_username.php" >Search by username</a> |
        <a href="list.php" >List items</a> 
    </nav>
    
    <br/><br/>

    <form method='GET' action="">
        Username: <input type='text' name='query' placeholder='e.g. Alice' />
        <input type='submit' value='Search' />
    </form>
    <br/>

    <table border='1'>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Username</th>
        <tr>

        <?php 
        /* 3. The Fetch Loop:
           $stmt->fetch() grabs one row at a time. 
           The 'while' loop continues as long as there is data left in the database.
        */
            while($row = $stmt->fetch()){ ?>
        <tr>
            <td><?php echo $row['id'] ?></td>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['quantity'] ?></td>
            <td><?php echo $row['price'] ?></td>
            <td><?php echo $row['username'] ?></td>
        <tr>
        <?php } ?>

    </table>

    
</body>
</html>