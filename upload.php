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

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];

    if (in_array($fileExt, $allowedExtensions)) {
        if ($fileError === 0) {
            if ($fileSize < 5000000) {
                $fileNameNew = uniqid('', true) . "." . $fileExt;
                $fileDestination = 'uploads/' . $fileNameNew;

                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    $userId = $_SESSION['userid'];

                    $sql = "UPDATE users SET profile_pic_path=? WHERE usersId=?";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "SQL error. Please try again later.";
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "si", $fileDestination, $userId);
                        mysqli_stmt_execute($stmt);
                        $_SESSION['profilePicPath'] = $fileDestination; // Store the path in the session for immediate use
                        header("Location: index.php?upload=success");
                        exit();
                    }
                } else {
                    echo "Failed to move uploaded file.";
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
