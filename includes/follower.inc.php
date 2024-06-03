<?php
session_start();
require_once 'includes/dbh.inc.php';

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['follow']) && isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];
    $followerId = $_SESSION['userid'];

    // Check if the user is already following the target user
    $sql = "SELECT * FROM followers WHERE user_id = ? AND follower_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ii", $userId, $followerId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // Already following, unfollow
        $sql = "DELETE FROM followers WHERE user_id = ? AND follower_id = ?";
    } else {
        // Not following, follow
        $sql = "INSERT INTO followers (user_id, follower_id) VALUES (?, ?)";
    }

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ii", $userId, $followerId);
    mysqli_stmt_execute($stmt);

    header("Location: profile.php?user_id=" . $userId);
    exit();
}
?>
