<?php 

session_start();
require_once 'dbh.inc.php'; // Database connection
require_once 'functions.inc.php'; // Your functions file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    if (!isset($_SESSION['userid'])) {
        header("Location: login.php?error=notloggedin");
        exit();
    }

    $userId = $_SESSION['userid']; // User ID from session

    if (emptyPost($title, $content)) {
        header("Location: posts.php?error=emptyinput");
        exit();
    }

    createPost($conn, $title, $content, $userId);
}
