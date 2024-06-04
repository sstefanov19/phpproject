<?php
session_start();
require_once 'includes/dbh.inc.php';

if (!isset($_GET['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_GET['username'];

// Fetch user data
$sql = "SELECT * FROM users WHERE usersUid = ?";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: index.php?error=stmtfailed");
    exit();
}
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    header("Location: index.php?error=nouser");
    exit();
}

$userId = $user['usersId'];

// Fetch follower count
$sql = "SELECT COUNT(*) as followerCount FROM followers WHERE user_id = ?";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: index.php?error=stmtfailed");
    exit();
}
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$followerData = mysqli_fetch_assoc($result);
$followerCount = $followerData['followerCount'];

// Fetch user posts
$sql = "SELECT * FROM posts WHERE userId = ? ORDER BY postDate DESC";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: index.php?error=stmtfailed");
    exit();
}
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($user['usersUid']); ?>'s Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<?php include_once "header.php"; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <img src="<?php echo isset($user['profilePic']) ? htmlspecialchars($user['profilePic']) : 'https://via.placeholder.com/150'; ?>" class="card-img-top" alt="Profile Picture">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($user['usersUid']); ?></h5>
                    <p class="card-text">Followers: <?php echo $followerCount; ?></p>
                    <?php if (isset($_SESSION['userid']) && $_SESSION['userid'] !== $userId): ?>
                        <form action="follow.php" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                            <button type="submit" name="follow" class="btn btn-primary">
                                <?php
                                // Check if the current user is already following this user
                                $sql = "SELECT * FROM followers WHERE user_id = ? AND follower_id = ?";
                                $stmt = mysqli_stmt_init($conn);
                                if (mysqli_stmt_prepare($stmt, $sql)) {
                                    mysqli_stmt_bind_param($stmt, "ii", $userId, $_SESSION['userid']);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                    if (mysqli_num_rows($result) > 0) {
                                        echo "Unfollow";
                                    } else {
                                        echo "Follow";
                                    }
                                }
                                ?>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <h1 class="mb-4 text-center"><?php echo htmlspecialchars($user['usersUid']); ?>'s Posts</h1>
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($post['postTitle']); ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Posted on <?php echo htmlspecialchars($post['postDate']); ?></h6>
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($post['postContent'])); ?></p>
                            <?php include 'edit_post.php' ?>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">No posts yet.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
