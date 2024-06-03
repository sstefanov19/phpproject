<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'includes/dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    
    $sql = "SELECT userId FROM posts WHERE postId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();
    $stmt->bind_result($userId);
    $stmt->fetch();
    $stmt->close();

    if ($userId == $_SESSION['userid']) {
        $sql = "DELETE FROM posts WHERE postId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $deleteId);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: index.php");
    exit();
} else {
    header("Location: index.php?error=invaliddeleteid");
    exit();
}
?>
