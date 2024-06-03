<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'includes/dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $postId = $_POST['postId'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    if (!isset($_SESSION['userid'])) {
        echo json_encode(['error' => 'User not logged in']);
        exit();
    }

    if (empty($title) || empty($content)) {
        echo json_encode(['error' => 'Title or content cannot be empty']);
        exit();
    }

    $userId = $_SESSION['userid'];

    $sql = "SELECT userId FROM posts WHERE postId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $stmt->bind_result($postUserId);
    $stmt->fetch();
    $stmt->close();

    if ($postUserId != $userId) {
        echo json_encode(['error' => 'Unauthorized']);
        exit();
    }

    $sql = "UPDATE posts SET postTitle = ?, postContent = ? WHERE postId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $content, $postId);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['success' => 'Post updated']);
    exit();
}
?>
