<?php
session_start();
include_once 'includes/dbh.inc.php';

if (isset($_POST['submit'])) {
    $file = $_FILES['profilePic'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileExt, $allowedExtensions)) {
        if ($fileError === 0) {
            if ($fileSize < 5000000) { 
                $imageData = file_get_contents($fileTmpName);
                $imageData = mysqli_real_escape_string($conn, $imageData);
                $userId = $_SESSION['userid'];

                $sql = "UPDATE users SET profile_pic=? WHERE usersId=?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "SQL error. Please try again later.";
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "si", $imageData, $userId);
                    mysqli_stmt_execute($stmt);
                    header("Location: index.php?upload=success");
                    exit();
                }
            } else {
                echo "File is too large.";
                exit();
            }
        } else {
            echo "There was an error uploading your file.";
            exit();
        }
    } else {
        echo "Invalid file type.";
        exit();
    }
}
?>
