<?php
include 'db_connect.php';

session_start();

// User must be logged in
if(!isset($_SESSION['user_id'])){
    header('location: sessions/login.php');
    exit;
}

// Get all posts with the author's name
// Newest posts appear first
$stmt = $conn->prepare("
    SELECT posts.*, users.full_name
    FROM posts
    JOIN users ON posts.user_id = users.user_id
    ORDER BY posts.created_at DESC
");

$stmt->execute();
?>

<!DOCTYPE html>
<html>
<body>

    <h1>Community Blog</h1>

    <h3>
        Welcome <?php echo htmlspecialchars($_SESSION['full_name']); ?>
    </h3>

    <nav>
        <a href="index.php">Home</a> |
        <a href="create.php">Create Post</a> |
        <a href="search.php">Search</a> |
        <a href="sessions/profile.php">Edit Profile</a> |
        <a href="sessions/logout.php">Logout</a>
    </nav>

    <hr>

    <h2>Global Feed</h2>

    <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ ?>

        <div>
            <h3>
                <?php echo htmlspecialchars($row['full_name']); ?>
            </h3>

            <p>
                <?php echo htmlspecialchars($row['post_text']); ?>
            </p>

            <?php if(!empty($row['image_path'])){ ?>
                <img
                    src="<?php echo htmlspecialchars($row['image_path']); ?>"
                    width="300"
                    alt="Post Image"
                >
            <?php } ?>

            <p>
                Posted:
                <?php echo $row['created_at']; ?>
            </p>

            <a href="show.php?id=<?php echo $row['post_id']; ?>">
                View Details
            </a>

            <?php if($row['user_id'] == $_SESSION['user_id']){ ?>
                |
                <a href="delete.php?id=<?php echo $row['post_id']; ?>">
                    Delete
                </a>
            <?php } ?>

            <hr>
        </div>

    <?php } ?>

</body>
</html>